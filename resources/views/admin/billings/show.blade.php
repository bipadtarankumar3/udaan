<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fee Receipt #{{ $bill->invoice_no }} — {{ $bill->student_name }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: #f1f5f9;
            color: #0f172a;
            padding: 30px 15px;
            font-size: 13px;
            line-height: 1.5;
        }
        .invoice-card {
            background: #ffffff;
            max-width: 820px;
            margin: 0 auto;
            border-radius: 12px;
            box-shadow: 0 10px 35px rgba(0, 0, 0, 0.08);
            border: 2px solid #005697;
            padding: 30px 36px;
            position: relative;
        }

        /* Header layout */
        .inv-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2.5px solid #005697;
            padding-bottom: 14px;
            margin-bottom: 18px;
            gap: 15px;
        }
        .inv-logo-left {
            flex: 1;
        }
        .inv-center-info {
            flex: 2;
            text-align: center;
        }
        .inv-seal-right {
            flex: 0.8;
            display: flex;
            justify-content: flex-end;
            align-items: center;
        }

        .inv-title-banner {
            background: #005697;
            color: #ffffff;
            text-align: center;
            font-size: 15px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 6px 14px;
            border-radius: 6px;
            margin-bottom: 18px;
        }

        /* 2-Column Meta details */
        .meta-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
            margin-bottom: 20px;
        }
        .meta-box {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 12px 16px;
        }
        .meta-box-title {
            font-size: 11px;
            font-weight: 800;
            color: #005697;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
            border-bottom: 1px solid #cbd5e1;
            padding-bottom: 4px;
        }
        .meta-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 4px;
            font-size: 12px;
        }
        .meta-label {
            color: #64748b;
            font-weight: 600;
        }
        .meta-val {
            color: #0f172a;
            font-weight: 700;
        }

        /* Items Table */
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 18px;
            border: 1.5px solid #005697;
        }
        .items-table th {
            background: #005697;
            color: #ffffff;
            padding: 8px 12px;
            font-size: 11.5px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .items-table td {
            border: 1px solid #cbd5e1;
            padding: 10px 12px;
            font-size: 12.5px;
        }

        /* Total calculation block */
        .calc-grid {
            display: grid;
            grid-template-columns: 1.3fr 1fr;
            gap: 16px;
            margin-bottom: 22px;
        }
        .words-box {
            background: #f8fafc;
            border: 1px dashed #cbd5e1;
            border-radius: 8px;
            padding: 12px 14px;
            font-size: 11.5px;
            line-height: 1.5;
        }
        .summary-table {
            width: 100%;
            border-collapse: collapse;
        }
        .summary-table td {
            padding: 4px 8px;
            font-size: 12px;
        }
        .summary-table .sum-label {
            color: #475569;
            font-weight: 600;
        }
        .summary-table .sum-val {
            text-align: right;
            font-weight: 700;
            color: #0f172a;
        }
        .summary-table .grand-total {
            font-size: 14px;
            font-weight: 900;
            color: #005697;
            border-top: 1.5px solid #005697;
            border-bottom: 1.5px solid #005697;
            padding: 6px 8px;
        }

        /* Status Stamp Overlay */
        .status-stamp {
            display: inline-block;
            padding: 4px 14px;
            font-size: 13px;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 1px;
            border-radius: 4px;
            border: 2px solid;
        }
        .stamp-paid {
            color: #047857;
            border-color: #047857;
            background: #ecfdf5;
        }
        .stamp-partial {
            color: #b45309;
            border-color: #b45309;
            background: #fffbeb;
        }
        .stamp-unpaid {
            color: #be123c;
            border-color: #be123c;
            background: #fff1f2;
        }

        /* Bottom Signatures & Footer */
        .footer-grid {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            border-top: 1.5px solid #005697;
            padding-top: 14px;
            margin-top: 10px;
        }
        .terms-box {
            font-size: 10px;
            color: #64748b;
            max-width: 480px;
            line-height: 1.4;
        }
        .sig-box {
            text-align: center;
            width: 170px;
        }

        /* Top Action Bar (No Print) */
        .top-action-bar {
            max-width: 820px;
            margin: 0 auto 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #ffffff;
            padding: 12px 18px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            border: 1px solid #e2e8f0;
        }

        @media print {
            body {
                background: #ffffff !important;
                padding: 0 !important;
                margin: 0 !important;
            }
            .top-action-bar, .no-print {
                display: none !important;
            }
            .invoice-card {
                border: 2px solid #005697 !important;
                box-shadow: none !important;
                max-width: 100% !important;
                padding: 20px 24px !important;
                border-radius: 0 !important;
            }
        }
    </style>
</head>
<body>

    <!-- Top Action Bar (No Print) -->
    <div class="top-action-bar no-print">
        <a href="{{ route('admin.billings.index') }}" style="text-decoration: none; color: #475569; font-size: 12.5px; font-weight: 700; display: inline-flex; align-items: center; gap: 6px;">
            <i class="fa-solid fa-arrow-left"></i>
            <span>Back to Billing Ledger</span>
        </a>

        <div style="display: flex; gap: 10px;">
            <button onclick="window.print()" style="background: #005697; color: #ffffff; border: none; padding: 8px 18px; border-radius: 6px; font-size: 12.5px; font-weight: 700; cursor: pointer; display: inline-flex; align-items: center; gap: 6px;">
                <i class="fa-solid fa-print"></i>
                <span>Print Official Receipt</span>
            </button>
        </div>
    </div>

    <!-- Official Printable Invoice Card -->
    <div class="invoice-card">
        
        <!-- Header -->
        <div class="inv-header">
            <!-- Logo Left -->
            <div class="inv-logo-left">
                <img src="{{ asset('logo.png') }}" alt="Uddan Educational Foundation" style="max-height: 52px; width: auto; object-fit: contain;">
                <div style="font-size: 7.5px; font-weight: 800; color: #475569; letter-spacing: 1px; margin-top: 4px; text-transform: uppercase;">
                    UDDAN EDUCATIONAL FOUNDATION
                </div>
            </div>

            <!-- Center Info -->
            <div class="inv-center-info">
                <div style="color: #005697; font-size: 18px; font-weight: 800; line-height: 1.2;">
                    Combined Counselling Board
                </div>
                <div style="background: #005697; color: #ffffff; font-weight: 800; font-size: 10.5px; padding: 2px 8px; text-transform: uppercase; margin: 3px auto 4px; display: inline-block; letter-spacing: 0.5px; border-radius: 2px;">
                    BIHAR STUDENT COUNSELLING CENTER (BSCC)
                </div>
                <div style="font-size: 9.5px; color: #334155; line-height: 1.35;">
                    Kargil Chowk (Gandhi Maidan), Beside Aawaran Vastralaya, Ashok Rajpath, Patna, Bihar
                </div>
                <div style="font-size: 9px; color: #005697; font-weight: 700; margin-top: 2px;">
                    Helpline: 6202601616 &nbsp;|&nbsp; Web: www.bscc.net.in &nbsp;|&nbsp; Email: ccbwelfare@gmail.com
                </div>
            </div>

            <!-- Right Circular Stamp -->
            <div class="inv-seal-right">
                <img src="{{ asset('images/stamp_top.png') }}" alt="Seal" style="max-height: 76px; width: auto; object-fit: contain; background: transparent;">
            </div>
        </div>

        <!-- Banner Title -->
        <div class="inv-title-banner">
            Student Fee Receipt &amp; Billing Invoice
        </div>

        <!-- Meta Grid -->
        <div class="meta-grid">
            
            <!-- Student Details -->
            <div class="meta-box">
                <div class="meta-box-title">Student Information</div>
                <div class="meta-row">
                    <span class="meta-label">Student Name:</span>
                    <span class="meta-val" style="text-transform: capitalize;">{{ $bill->student_name }}</span>
                </div>
                <div class="meta-row">
                    <span class="meta-label">Father's Name:</span>
                    <span class="meta-val">{{ $bill->student_father_name ?: '—' }}</span>
                </div>
                <div class="meta-row">
                    <span class="meta-label">Contact / Phone:</span>
                    <span class="meta-val">{{ $bill->student_phone }}</span>
                </div>
                @if($bill->course_name)
                    <div class="meta-row">
                        <span class="meta-label">Course / Program:</span>
                        <span class="meta-val" style="color: #c2410c;">{{ $bill->course_name }}</span>
                    </div>
                @endif
            </div>

            <!-- Invoice Details -->
            <div class="meta-box">
                <div class="meta-box-title">Invoice &amp; Payment Status</div>
                <div class="meta-row">
                    <span class="meta-label">Invoice Number:</span>
                    <span class="meta-val" style="font-family: monospace; color: #005697; font-size: 13px;">{{ $bill->invoice_no }}</span>
                </div>
                <div class="meta-row">
                    <span class="meta-label">Billing Date:</span>
                    <span class="meta-val">{{ $bill->billing_date?->format('d M Y') }}</span>
                </div>
                @if($bill->due_date)
                    <div class="meta-row">
                        <span class="meta-label">Payment Due Date:</span>
                        <span class="meta-val">{{ $bill->due_date?->format('d M Y') }}</span>
                    </div>
                @endif
                <div class="meta-row" style="margin-top: 6px; align-items: center;">
                    <span class="meta-label">Status:</span>
                    <div>
                        @if($bill->payment_status === 'paid')
                            <span class="status-stamp stamp-paid">PAID</span>
                        @elseif($bill->payment_status === 'partially_paid')
                            <span class="status-stamp stamp-partial">PARTIALLY PAID</span>
                        @elseif($bill->payment_status === 'cancelled')
                            <span class="status-stamp stamp-unpaid">CANCELLED</span>
                        @else
                            <span class="status-stamp stamp-unpaid">UNPAID</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Items Table -->
        <table class="items-table">
            <thead>
                <tr>
                    <th style="width: 8%; text-align: center;">#</th>
                    <th style="width: 52%; text-align: left;">Particulars / Fee Description</th>
                    <th style="width: 14%; text-align: right;">Base Fee</th>
                    <th style="width: 12%; text-align: right;">Discount</th>
                    <th style="width: 14%; text-align: right;">Total Amount</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="text-align: center; font-weight: 700; color: #64748b;">1</td>
                    <td>
                        <div style="font-weight: 800; color: #0f172a;">{{ $bill->title }}</div>
                        @if($bill->course_name)
                            <div style="font-size: 11px; color: #005697; margin-top: 2px;">
                                Enrolled Course / Stream: <strong>{{ $bill->course_name }}</strong>
                            </div>
                        @endif
                        @if($bill->notes)
                            <div style="font-size: 10.5px; color: #64748b; margin-top: 3px; font-style: italic;">
                                Notes: {{ $bill->notes }}
                            </div>
                        @endif
                    </td>
                    <td style="text-align: right; font-weight: 700;">₹{{ number_format($bill->amount, 2) }}</td>
                    <td style="text-align: right; color: #059669;">
                        {{ $bill->discount > 0 ? '-₹' . number_format($bill->discount, 2) : '—' }}
                    </td>
                    <td style="text-align: right; font-weight: 800; color: #005697;">
                        ₹{{ number_format($bill->total_payable, 2) }}
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- Calculation & Words Block -->
        <div class="calc-grid">
            <!-- Left: Amount in Words & Payment Reference -->
            <div class="words-box">
                <div style="margin-bottom: 6px;">
                    <span style="color: #64748b; font-weight: 700; font-size: 10.5px; text-transform: uppercase;">Amount in Words:</span>
                    <div style="font-weight: 800; color: #005697; font-size: 12px; margin-top: 2px;">
                        {{ $bill->amount_in_words }}
                    </div>
                </div>

                <div style="border-top: 1px dashed #cbd5e1; padding-top: 6px; margin-top: 6px; font-size: 11px;">
                    <div><strong>Payment Method:</strong> {{ $bill->payment_method ?: 'Cash' }}</div>
                    @if($bill->transaction_id)
                        <div><strong>Transaction / UTR:</strong> <span style="font-family: monospace;">{{ $bill->transaction_id }}</span></div>
                    @endif
                    @if($bill->paid_at)
                        <div><strong>Receipt Timestamp:</strong> {{ $bill->paid_at->format('d M Y, h:i A') }}</div>
                    @endif
                </div>
            </div>

            <!-- Right: Summary Totals -->
            <div>
                <table class="summary-table">
                    <tr>
                        <td class="sum-label">Sub Total:</td>
                        <td class="sum-val">₹{{ number_format($bill->amount, 2) }}</td>
                    </tr>
                    @if($bill->discount > 0)
                        <tr>
                            <td class="sum-label" style="color: #059669;">Special Concession:</td>
                            <td class="sum-val" style="color: #059669;">-₹{{ number_format($bill->discount, 2) }}</td>
                        </tr>
                    @endif
                    @if($bill->tax_amount > 0)
                        <tr>
                            <td class="sum-label">Tax / GST:</td>
                            <td class="sum-val">+₹{{ number_format($bill->tax_amount, 2) }}</td>
                        </tr>
                    @endif
                    <tr>
                        <td class="grand-total">Total Net Payable:</td>
                        <td class="grand-total sum-val">₹{{ number_format($bill->total_payable, 2) }}</td>
                    </tr>
                    <tr>
                        <td class="sum-label" style="font-weight: 800; color: #047857; padding-top: 6px;">Amount Received:</td>
                        <td class="sum-val" style="font-weight: 800; color: #047857; padding-top: 6px;">₹{{ number_format($bill->paid_amount, 2) }}</td>
                    </tr>
                    <tr>
                        <td class="sum-label" style="font-weight: 800; color: #b45309;">Balance Due:</td>
                        <td class="sum-val" style="font-weight: 800; color: #b45309;">₹{{ number_format($bill->due_amount, 2) }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- Footer & Official Signatures -->
        <div class="footer-grid">
            <!-- Terms -->
            <div class="terms-box">
                <strong>Terms &amp; Important Information:</strong>
                <ol style="padding-left: 14px; margin-top: 3px;">
                    <li>This is an official computer-generated fee receipt issued by Uddan Educational Foundation.</li>
                    <li>Payments are subject to clearing of cheque / electronic realization.</li>
                    <li>Bihar Student Credit Card (BSCC) counseling &amp; guidance is provided free of cost.</li>
                </ol>
            </div>

            <!-- Official Stamp & Sign -->
            <div class="sig-box">
                <img src="{{ asset('images/stamp_signature.png') }}" alt="Signature & Stamp" style="max-height: 80px; width: auto; object-fit: contain; background: transparent; display: block; margin: 0 auto;">
                <div style="font-size: 11px; font-weight: 800; color: #005697; border-top: 1px solid #005697; padding-top: 3px; margin-top: 2px;">
                    Authorized Signatory
                </div>
                <div style="font-size: 9px; color: #64748b;">
                    Combined Counselling Board
                </div>
            </div>
        </div>

    </div>

</body>
</html>
