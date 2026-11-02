<?php

/**
 * Paystack Payment Gateway Service
 * Pure cURL implementation with zero third-party SDK dependencies.
 */
class PaystackService
{
    private static function getBaseUrl(): string
    {
        return rtrim(Env::get('PAYSTACK_PAYMENT_URL', 'https://api.paystack.co'), '/');
    }

    public static function getSecretKey(): string
    {
        return (string)Env::get('PAYSTACK_SECRET_KEY', '');
    }

    public static function getPublicKey(): string
    {
        return (string)Env::get('PAYSTACK_PUBLIC_KEY', '');
    }

    /**
     * Check whether Paystack is configured with valid credentials
     */
    public static function isConfigured(): bool
    {
        $key = self::getSecretKey();
        return !empty($key) && !str_contains($key, 'xxxxxxxx');
    }

    /**
     * Initialize a Paystack hosted checkout transaction
     *
     * @param array $payload [email, amount (kobo), reference, callback_url, metadata]
     * @return array ['success' => bool, 'message' => string, 'authorization_url' => string, 'reference' => string, 'raw' => array]
     */
    public static function initializeTransaction(array $payload): array
    {
        $secretKey = self::getSecretKey();
        if (empty($secretKey)) {
            return [
                'success' => false,
                'message' => 'Paystack secret key is not configured.'
            ];
        }

        $url = self::getBaseUrl() . '/transaction/initialize';
        $jsonPayload = json_encode($payload);

        $timeout = (int)Env::get('PAYSTACK_TIMEOUT_SECONDS', 30);
        $verifySsl = (bool)Env::get('PAYSTACK_VERIFY_SSL', true);

        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL            => $url,
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => $jsonPayload,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CONNECTTIMEOUT => 10,
            CURLOPT_TIMEOUT        => $timeout,
            CURLOPT_SSL_VERIFYPEER => $verifySsl,
            CURLOPT_SSL_VERIFYHOST => $verifySsl ? 2 : 0,
            CURLOPT_HTTPHEADER     => [
                'Authorization: Bearer ' . $secretKey,
                'Content-Type: application/json',
                'Cache-Control: no-cache',
                'User-Agent: SpiderTech-Paystack/1.0'
            ]
        ]);

        $response = curl_exec($ch);
        $errNo    = curl_errno($ch);
        $errMsg   = curl_error($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($errNo !== 0) {
            return [
                'success' => false,
                'message' => "Payment gateway network error: {$errMsg}"
            ];
        }

        $data = json_decode($response, true);
        if (!$data || empty($data['status']) || empty($data['data']['authorization_url'])) {
            $msg = $data['message'] ?? "Failed to initialize payment (HTTP {$httpCode}).";
            return [
                'success' => false,
                'message' => $msg,
                'raw'     => $data
            ];
        }

        return [
            'success'           => true,
            'authorization_url' => $data['data']['authorization_url'],
            'access_code'       => $data['data']['access_code'] ?? '',
            'reference'         => $data['data']['reference'] ?? ($payload['reference'] ?? ''),
            'message'           => $data['message'] ?? 'Initialization successful',
            'raw'               => $data
        ];
    }

    /**
     * Verify a transaction via Paystack REST API
     *
     * @param string $reference
     * @return array ['success' => bool, 'paid' => bool, 'amount' => int, 'currency' => string, 'data' => array, 'message' => string]
     */
    public static function verifyTransaction(string $reference): array
    {
        $secretKey = self::getSecretKey();
        if (empty($secretKey)) {
            return [
                'success' => false,
                'paid'    => false,
                'message' => 'Paystack secret key is not configured.'
            ];
        }

        $url = self::getBaseUrl() . '/transaction/verify/' . rawurlencode($reference);
        $timeout = (int)Env::get('PAYSTACK_TIMEOUT_SECONDS', 30);
        $verifySsl = (bool)Env::get('PAYSTACK_VERIFY_SSL', true);

        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL            => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CONNECTTIMEOUT => 10,
            CURLOPT_TIMEOUT        => $timeout,
            CURLOPT_SSL_VERIFYPEER => $verifySsl,
            CURLOPT_SSL_VERIFYHOST => $verifySsl ? 2 : 0,
            CURLOPT_HTTPHEADER     => [
                'Authorization: Bearer ' . $secretKey,
                'Cache-Control: no-cache',
                'User-Agent: SpiderTech-Paystack/1.0'
            ]
        ]);

        $response = curl_exec($ch);
        $errNo    = curl_errno($ch);
        $errMsg   = curl_error($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($errNo !== 0) {
            return [
                'success' => false,
                'paid'    => false,
                'message' => "Gateway verification connection error: {$errMsg}"
            ];
        }

        $data = json_decode($response, true);
        if (!$data || empty($data['status']) || !isset($data['data'])) {
            $msg = $data['message'] ?? "Unable to verify transaction (HTTP {$httpCode}).";
            return [
                'success' => false,
                'paid'    => false,
                'message' => $msg,
                'data'    => $data
            ];
        }

        $tx = $data['data'];
        $isPaid = (isset($tx['status']) && $tx['status'] === 'success');

        return [
            'success'          => true,
            'paid'             => $isPaid,
            'status'           => $tx['status'] ?? 'unknown',
            'amount'           => (int)($tx['amount'] ?? 0), // in kobo
            'currency'         => $tx['currency'] ?? 'NGN',
            'channel'          => $tx['channel'] ?? '',
            'paid_at'          => $tx['paid_at'] ?? null,
            'gateway_response' => $tx['gateway_response'] ?? '',
            'customer_email'   => $tx['customer']['email'] ?? '',
            'metadata'         => $tx['metadata'] ?? [],
            'data'             => $tx,
            'message'          => $data['message'] ?? 'Verification successful'
        ];
    }

    /**
     * Validate Paystack Webhook HMAC-SHA512 Signature
     *
     * @param string $rawBody
     * @param string $signature
     * @return bool
     */
    public static function verifyWebhookSignature(string $rawBody, string $signature): bool
    {
        $secretKey = self::getSecretKey();
        if (empty($secretKey) || empty($signature)) {
            return false;
        }

        $computedSignature = hash_hmac('sha512', $rawBody, $secretKey);
        return hash_equals($computedSignature, $signature);
    }

    /**
     * Format kobo amount into Naira display string (e.g. 2500000 -> "₦25,000.00")
     */
    public static function formatKobo(int $kobo): string
    {
        return '₦' . number_format($kobo / 100, 2);
    }

    /**
     * Convert Naira amount to Kobo integer
     */
    public static function nairaToKobo(float|int $naira): int
    {
        return (int)round((float)$naira * 100);
    }

    /**
     * Convert Kobo integer to Naira float
     */
    public static function koboToNaira(int $kobo): float
    {
        return round($kobo / 100, 2);
    }

    /**
     * Generate secure hash token for printable invoice URLs
     */
    public static function generateInvoiceToken(string $reference): string
    {
        $salt = (string)Env::get('INVOICE_HASH_SALT', 'spider_tech_default_invoice_salt');
        return hash_hmac('sha256', $reference, $salt);
    }

    /**
     * Validate printable invoice security token
     */
    public static function validateInvoiceToken(string $reference, string $token): bool
    {
        $expected = self::generateInvoiceToken($reference);
        return hash_equals($expected, $token);
    }
}
