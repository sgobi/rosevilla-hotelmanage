<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ ($isProforma ?? false) ? 'Quotation / Proforma Invoice' : 'Reservation Confirmation' }} #{{ $booking->id }} - Rose Villa</title>
    <style>
        body { 
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #000000;
            background-color: #f3f4f6;
            margin: 0;
            padding: 20px;
        }
        .invoice-container {
            background: white;
            max-width: 800px;
            margin: 0 auto;
            padding: 40px;
            box-shadow: 0 0 20px rgba(0,0,0,0.05);
            border: 1px solid #e5e7eb;
        }
        .header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        .logo {
            width: 250px;
        }
        .contact-info {
            text-align: right;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: bold;
        }
        .meta-data {
            margin-bottom: 20px;
            font-size: 13px;
        }
        .meta-row {
            display: flex;
            margin-bottom: 5px;
        }
        .label {
            font-weight: bold;
            width: 130px;
        }
        .separator {
            width: 20px;
        }
        .divider {
            border-top: 1px solid #000;
            margin: 20px 0;
        }
        .greeting {
            margin-bottom: 20px;
            font-size: 13px;
        }
        .details-list {
            margin-bottom: 25px;
            font-size: 13px;
        }
        .details-row {
            display: flex;
            margin-bottom: 8px;
        }
        .details-label {
            font-weight: bold;
            width: 200px;
        }
        .total-section {
            border-top: 1px solid #000;
            border-bottom: 1px solid #000;
            padding: 10px 0;
            margin: 20px 0;
            font-weight: bold;
            font-size: 15px;
        }
        .advance-receipt {
            background-color: #f9fafb;
            border: 1px solid #f3f4f6;
            padding: 15px;
            border-radius: 8px;
            margin: 20px 0;
        }
        .receipt-title {
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
            color: #6b7280;
            margin-bottom: 10px;
            font-style: italic;
        }
        .receipt-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
        }
        .footer {
            margin-top: 30px;
            font-size: 12px;
            font-style: italic;
        }
        .signature {
            margin-top: 20px;
        }
        .signature-title {
            font-weight: bold;
            font-size: 13px;
        }
    </style>
</head>
<body>

    <div class="invoice-container">
        {{-- Header Section --}}
        <table width="100%" cellpadding="0" cellspacing="0" border="0">
            <tr>
                <td>
                    <img src="{{ asset('storage/logos/invoice logo.png') }}" alt="Rose Villa Logo" class="logo" style="width: 250px;">
                </td>
                <td align="right" class="contact-info" style="font-size: 10px; text-transform: uppercase; letter-spacing: 1px; font-weight: bold;">
                    TEL : {{ $content['contact_phone'] ?? '+94 76 319 3311' }}<br>
                    EMAIL : {{ $content['contact_email'] ?? 'stay@rosevillaheritagehomes.com' }}<br>
                    WEBSITE : WWW.ROSEVILLAHERITAGEHOMES.COM
                </td>
            </tr>
        </table>

        {{-- Meta Data --}}
        <div class="divider"></div>
        <div class="meta-data">
            <div class="meta-row"><span class="label">Date</span><span class="separator">:</span><span>{{ now()->format('d m Y') }}</span></div>
            <div class="meta-row"><span class="label">From</span><span class="separator">:</span><span>Reservation Office</span></div>
            <div class="meta-row"><span class="label">Subject</span><span class="separator">:</span><span>{{ ($isProforma ?? false) ? 'Quotation / Proforma Invoice' : 'Reservation Confirmation' }}</span></div>
        </div>

        <div class="divider"></div>

        {{-- Greeting --}}
        <div class="greeting">
            <p>Thank you for choosing <strong>Rose Villa Heritage Homes</strong>. We are pleased to provide the {{ ($isProforma ?? false) ? 'quotation / proforma invoice' : 'confirmation details' }} for your upcoming stay.</p>
        </div>

        {{-- Main Details --}}
        <div class="details-list">
            <div class="details-row">
                <span class="details-label">Confirmation Number</span>
                <span>: <strong>{{ str_pad($booking->id, 5, '0', STR_PAD_LEFT) }}</strong></span>
            </div>
            <div class="details-row">
                <span class="details-label">Guest Name</span>
                <span style="text-transform: capitalize;">: {{ strtolower($booking->guest_name) }}</span>
            </div>
            <div class="details-row">
                <span class="details-label">Check-in</span>
                <span>: {{ $booking->check_in->format('d-m-Y') }}</span>
            </div>
            <div class="details-row">
                <span class="details-label">Check-out</span>
                <span>: {{ $booking->check_out->format('d-m-Y') }}</span>
            </div>
            <div class="details-row">
                <span class="details-label">Name of Rooms</span>
                <span>: {{ $booking->rooms()->pluck('title')->implode(', ') }}</span>
            </div>
            <div class="details-row">
                <span class="details-label">Number of Persons</span>
                <span>: {{ $booking->guests }}</span>
            </div>
            <div class="details-row">
                <span class="details-label">Room Rate</span>
                <span>: LKR {{ number_format($booking->total_price, 2) }}</span>
            </div>
            
            @if($booking->tax_amount > 0)
                <div class="details-row">
                    <span class="details-label">Taxes ({{ number_format($booking->tax_percentage, 1) }}%)</span>
                    <span>: LKR {{ number_format($booking->tax_amount, 2) }}</span>
                </div>
            @endif

            @if($booking->discount_percentage > 0 && $booking->discount_status === 'approved')
                <div class="details-row">
                    <span class="details-label">Discount ({{ $booking->discount_percentage }}%)</span>
                    <span>: - LKR {{ number_format($booking->discount_amount, 2) }}</span>
                </div>
            @endif
        </div>

        <div class="total-section">
            <table width="100%">
                <tr>
                    <td style="font-weight: bold;">Gross Amount</td>
                    <td align="right" style="font-weight: bold;">: LKR {{ number_format($booking->final_price, 2) }}</td>
                </tr>
            </table>
        </div>

        @if($booking->advance_amount > 0)
            <div class="advance-receipt">
                <p class="receipt-title">Advance Payment Receipt</p>
                <table width="100%" style="font-size: 12px;">
                    <tr>
                        <td><strong>Payment Method</strong>: {{ ucfirst($booking->advance_payment_method) }}</td>
                        <td><strong>Amount Paid</strong>: LKR {{ number_format($booking->advance_amount, 2) }}</td>
                    </tr>
                    <tr>
                        <td><strong>Payee Name</strong>: {{ $booking->advance_guest_name }}</td>
                        <td><strong>Payee NIC</strong>: {{ $booking->advance_nic_no }}</td>
                    </tr>
                </table>
            </div>
            <div style="font-weight: bold; font-size: 15px; margin-bottom: 20px;">
                <table width="100%">
                    <tr>
                        <td>Balance Payable</td>
                        <td align="right">: LKR {{ number_format($booking->final_price - $booking->advance_amount, 2) }}</td>
                    </tr>
                </table>
            </div>
        @endif

        <div class="footer">
            <p>Should you need to cancel your booking, please do so up to 72 hours prior to your scheduled arrival day to avoid late cancellation or no-show charges.</p>
            <p>If you require any information prior to your arrival, please visit our website www.rosevillaheritagehomes.com or contact our customer service.</p>
            <p><strong>We are looking forward to welcoming you to the Rose Villa Heritage Homes.</strong></p>
        </div>

        {{-- Footer Signature --}}
        <div class="signature">
            <p class="signature-title">Reservation Officer</p>
            @if($content['signature_path'] ?? null)
                <img src="{{ asset('storage/' . $content['signature_path']) }}" alt="Signature" style="height: 50px; width: auto;">
            @endif
            <div class="divider" style="margin-top: 10px;"></div>
            <div style="font-size: 9px; text-transform: uppercase; letter-spacing: 1px; font-weight: bold;">
                TEL : {{ $content['contact_phone'] ?? '+94 76 319 3311' }} | 
                EMAIL : {{ $content['contact_email'] ?? 'stay@rosevillaheritagehomes.com' }} | 
                WWW : WWW.ROSEVILLAHERITAGEHOMES.COM
            </div>
        </div>
    </div>

</body>
</html>
