<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ ($isProforma ?? false) ? 'Event Quotation / Proforma Invoice' : 'Event Confirmation' }} #{{ $booking->id }} - Rose Villa</title>
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
            <div class="meta-row"><span class="label">From</span><span class="separator">:</span><span>Events Department</span></div>
            <div class="meta-row"><span class="label">Subject</span><span class="separator">:</span><span>{{ ($isProforma ?? false) ? 'Event Quotation / Proforma Invoice' : 'Event Confirmation' }}</span></div>
        </div>

        <div class="divider"></div>

        {{-- Greeting --}}
        <div class="greeting">
            <p>Thank you for choosing <strong>Rose Villa Heritage Homes</strong>. We are pleased to provide the {{ ($isProforma ?? false) ? 'quotation / proforma invoice' : 'confirmation details' }} for your upcoming event.</p>
        </div>

        {{-- Main Details --}}
        <div class="details-list">
            <div class="details-row">
                <span class="details-label">Confirmation Number</span>
                <span>: <strong>E-{{ str_pad($booking->id, 5, '0', STR_PAD_LEFT) }}</strong></span>
            </div>
            <div class="details-row">
                <span class="details-label">Customer Name</span>
                <span style="text-transform: capitalize;">: {{ strtolower($booking->customer_name) }}</span>
            </div>
            <div class="details-row">
                <span class="details-label">Event Date</span>
                <span>: {{ $booking->event_date->format('d-m-Y') }}</span>
            </div>
            <div class="details-row">
                <span class="details-label">Event Type</span>
                <span>: {{ $booking->event_type }}</span>
            </div>
            <div class="details-row">
                <span class="details-label">Number of Guests</span>
                <span>: {{ $booking->guests }}</span>
            </div>

            @if(!empty($booking->additional_services))
                <div class="divider" style="border-top: 1px solid #eee; margin: 10px 0;"></div>
                @foreach($booking->additional_services as $service)
                    @if(!empty($service['type']))
                        <div class="details-row">
                            <span class="details-label">{{ $service['type'] }}</span>
                            <span>: LKR {{ number_format($service['price'] ?? 0, 2) }}</span>
                        </div>
                    @endif
                @endforeach
                <div class="divider" style="border-top: 1px solid #eee; margin: 10px 0;"></div>
            @endif

            @if($booking->garden_selection)
                <div class="details-row">
                    <span class="details-label">Garden Venue ({{ $booking->duration }} days)</span>
                    <span>: LKR {{ number_format($booking->garden_price_per_day * $booking->duration, 2) }}</span>
                </div>
            @endif

            @foreach($booking->rooms_list as $room)
                <div class="details-row">
                    <span class="details-label">{{ $room->title }} ({{ $booking->duration }} days)</span>
                    <span>: LKR {{ number_format($room->price_per_night * $booking->duration, 2) }}</span>
                </div>
            @endforeach

            @if($booking->total_price > 0)
                <div class="details-row">
                    <span class="details-label">Additional Quoted Rate</span>
                    <span>: LKR {{ number_format($booking->total_price, 2) }}</span>
                </div>
            @endif
            
            @if($booking->tax_amount > 0)
                <div class="details-row">
                    <span class="details-label">Taxes ({{ number_format($booking->tax_percentage, 1) }}%)</span>
                    <span>: LKR {{ number_format($booking->tax_amount, 2) }}</span>
                </div>
            @endif

            @if($booking->discount_amount > 0)
                <div class="details-row">
                    <span class="details-label">Discount</span>
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
            <p>Please note that event bookings are subject to our standard event policies. Cancellations must be made at least 14 days in advance.</p>
            <p>If you require any information prior to your event, please visit our website www.rosevillaheritagehomes.com or contact our events team.</p>
            <p><strong>We are looking forward to hosting your event at Rose Villa Heritage Homes.</strong></p>
        </div>

        {{-- Footer Signature --}}
        <div class="signature">
            <p class="signature-title">Events Manager</p>
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
