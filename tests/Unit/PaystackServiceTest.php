<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use PaystackService;

class PaystackServiceTest extends TestCase
{
    public function testFormatKobo(): void
    {
        $this->assertSame('₦25,000.00', PaystackService::formatKobo(2500000));
        $this->assertSame('₦0.00', PaystackService::formatKobo(0));
    }

    public function testNairaToKoboConversion(): void
    {
        $this->assertSame(3500000, PaystackService::nairaToKobo(35000));
    }

    public function testKoboToNairaConversion(): void
    {
        $this->assertSame(35000.0, PaystackService::koboToNaira(3500000));
    }

    public function testResolveCaBundlePathIfExists(): void
    {
        $bundlePath = PaystackService::resolveCaBundlePath();
        if ($bundlePath !== null) {
            $this->assertFileExists($bundlePath);
        } else {
            $this->assertTrue(true);
        }
    }

    public function testVerifyWebhookSignatureAuthentic(): void
    {
        $secret = 'sk_test_mock_secret_key_12345';
        putenv("PAYSTACK_SECRET_KEY={$secret}");
        $_ENV['PAYSTACK_SECRET_KEY'] = $secret;
        $_SERVER['PAYSTACK_SECRET_KEY'] = $secret;

        $payload = json_encode(['event' => 'charge.success', 'data' => ['reference' => 'TEST_REF_001', 'amount' => 500000]]);
        $validSignature = hash_hmac('sha512', (string)$payload, $secret);

        $this->assertTrue(PaystackService::verifyWebhookSignature((string)$payload, $validSignature));
    }

    public function testVerifyWebhookSignatureRejectsForgedOrEmpty(): void
    {
        $secret = 'sk_test_mock_secret_key_12345';
        putenv("PAYSTACK_SECRET_KEY={$secret}");
        $_ENV['PAYSTACK_SECRET_KEY'] = $secret;
        $_SERVER['PAYSTACK_SECRET_KEY'] = $secret;

        $payload = json_encode(['event' => 'charge.success', 'data' => ['reference' => 'TEST_REF_001', 'amount' => 500000]]);
        $this->assertFalse(PaystackService::verifyWebhookSignature((string)$payload, 'invalid_signature_here'));
        $this->assertFalse(PaystackService::verifyWebhookSignature((string)$payload, ''));
    }

    public function testInvoiceTokenGenerationAndValidation(): void
    {
        $ref = 'STP_8_1_' . time() . '_abcd';
        $token = PaystackService::generateInvoiceToken($ref);

        $this->assertNotEmpty($token);
        $this->assertTrue(PaystackService::validateInvoiceToken($ref, $token));
        $this->assertFalse(PaystackService::validateInvoiceToken($ref, 'forged_token'));
        $this->assertFalse(PaystackService::validateInvoiceToken('DIFFERENT_REF', $token));
    }
}
