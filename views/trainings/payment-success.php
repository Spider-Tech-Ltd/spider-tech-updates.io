<?php
/**
 * Official Payment Receipt & Enrollment Confirmation View — Spider Tech
 * Delegated to centralized InvoiceRenderer engine
 */

$data = InvoiceRenderer::normalizeData($application ?? [], [
    'invoice_number' => $invoice_number ?? ($application['invoice_number'] ?? 'STP-INV-0000'),
    'reference'      => $reference ?? ($application['payment_reference'] ?? ''),
    'amount_kobo'    => (int)($amount_kobo ?? ($application['amount_paid'] ?? 0)),
]);

echo InvoiceRenderer::renderStandalonePage($data, [
    'show_actions' => true
]);
