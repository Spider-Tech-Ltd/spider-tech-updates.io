<?php
/**
 * Official Printable Invoice & Payment Receipt — Spider Tech
 * Delegated to centralized InvoiceRenderer engine
 */

$data = InvoiceRenderer::normalizeData($application ?? [], [
    'reference' => $reference ?? ($application['payment_reference'] ?? '')
]);

echo InvoiceRenderer::renderStandalonePage($data, [
    'show_actions' => true
]);
