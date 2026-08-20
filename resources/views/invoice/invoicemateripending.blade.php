<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <style>
        body {
            font-size: 12px;
            color: #4c5258;
            letter-spacing: .5px;
            overflow-x: hidden;
            background-color: #fff;
            font-family: Roboto, sans-serif
        }

        a {
            text-decoration: none
        }

        .col-auto {
            flex: 0 0 auto;
            width: auto;
            max-width: 100%;
        }

        .col-1 {
            flex: 0 0 8.3333333333%;
            max-width: 8.3333333333%;
        }

        .col-2 {
            flex: 0 0 16.6666666667%;
            max-width: 16.6666666667%;
        }

        .col-3 {
            flex: 0 0 25%;
            max-width: 25%;
        }

        .col-4 {
            flex: 0 0 33.3333333333%;
            max-width: 33.3333333333%;
        }

        .col-5 {
            flex: 0 0 41.6666666667%;
            max-width: 41.6666666667%;
        }

        .col-6 {
            flex: 0 0 50%;
            max-width: 50%;
        }

        .col-7 {
            flex: 0 0 58.3333333333%;
            max-width: 58.3333333333%;
        }

        .col-8 {
            flex: 0 0 66.6666666667%;
            max-width: 66.6666666667%;
        }

        .col-9 {
            flex: 0 0 75%;
            max-width: 75%;
        }

        .col-10 {
            flex: 0 0 83.3333333333%;
            max-width: 83.3333333333%;
        }

        .col-11 {
            flex: 0 0 91.6666666667%;
            max-width: 91.6666666667%;
        }

        .col-12 {
            flex: 0 0 100%;
            max-width: 100%;
        }

        .no-gutters>.col,
        .no-gutters>[class*=col-] {
            padding-right: 0;
            padding-left: 0;
        }

        .col {
            flex-basis: 0;
            flex-grow: 1;
            max-width: 100%;
        }

        #invoice {
            padding: 0
        }

        .invoice {
            position: relative;
            background-color: #fff;
            min-height: 680px;
        }

        .invoice header {
            padding: 15px 0;
            margin-bottom: 10px;
            border-bottom: 1px solid #0d6efd
        }

        .invoice .company-details {
            text-align: right
        }

        .invoice .company-details .name {
            margin-top: 0;
            margin-bottom: 0
        }

        .invoice .contacts {
            margin-bottom: 20px
        }

        .invoice .invoice-to {
            text-align: left
        }

        .invoice .invoice-to .to {
            margin-top: 0;
            margin-bottom: 0
        }

        .invoice .invoice-details {
            text-align: right;
            margin-right: 30px;
        }

        .invoice .invoice-details .invoice-id {
            margin-top: 0;
            color: #0d6efd
        }

        .invoice main {
            padding-bottom: 30px
        }

        .invoice main .notices {
            padding-left: 6px;
            border-left: 6px solid #0d6efd;
            background: #e7f2ff;
            padding: 10px
        }

        .invoice main .notices .notice {
            font-size: 1.2em
        }

        .invoice table {
            width: 100%;
            border-collapse: collapse;
            border-spacing: 0;
            margin-bottom: 20px;
        }

        .invoice table td,
        .invoice table th {
            padding: 15px;
            background: #eee;
            border-bottom: 1px solid #fff
        }

        .invoice table th {
            white-space: nowrap;
            font-weight: 400;
            font-size: 10px
        }

        .invoice table .unit {
            text-align: right;
            font-size: 1.2em;
            background: #ddd
        }

        .invoice table tbody tr:last-child td {
            border: none
        }

        .invoice footer {
            width: 100%;
            text-align: center;
            color: #777;
            border-top: 1px solid #aaa;
            padding: 8px 0
        }

        @media print {
            .invoice {
                font-size: 11px !important;
                overflow: hidden !important
            }

            .invoice footer {
                position: absolute;
                bottom: 10px;
                page-break-after: always
            }

            .invoice>div:last-child {
                page-break-before: always
            }
        }

        .float-left {
            float: left !important;
        }

        .float-right {
            float: right !important;
        }

        .row {
            display: -ms-flexbox;
            display: flex;
            -ms-flex-wrap: wrap;
            flex-wrap: wrap;
            margin-right: -15px;
            margin-left: -15px;
        }

        img {
            float: left;
            margin-left: 15px;
            margin-right: 15px;
        }

        .invoice header img {
            display: block;
            float: none;
            margin-bottom: 2px;
        }

        .invoice header .name {
            margin: 0;
            line-height: 0;
        }

        .invoice header .company-address {
            clear: both;
            margin-left: 15px;
        }

        .text-center {
            text-align: center !important;
        }
    </style>
</head>

<body>
    <div class="invoice overflow-auto">
        <div>
            <header>
                <div class="row">
                    <div class="col">
                        <img src="Bank-academy-logo-03.png" width="500" alt="" />
                        <h2 class="name"><a target="_blank"></a></h2>
                        <div class="company-address">
                            Jl. Bukit Limau VIII, Bringin, Kec. Ngaliyan, Kota Semarang.
                            <br> (024) 76435498
                            <br> info@bankiracademy.co.id
                        </div>
                    </div>
                </div>
            </header>
            <br>
            <main>
                <div class="row contacts">
                    <div class="float-left invoice-to">
                        <div class="col-lg-6">
                            <div class="text-gray-light">INVOICE TO:</div>
                            <h2 class="to">{{ $profile->name ?? 'User' }}</h2>
                            <div class="email"><a href="mailto:">{{ $profile->email ?? '-' }}</a></div>
                        </div>
                    </div>
                    <div class="float-right invoice-details">
                        <div class="col-lg-6">
                            <div class="date">Tanggal Invoice :
                                {{ Carbon\Carbon::parse($payment->created_at)->format('d-m-Y') }}</div>
                            <h2 class="invoice-id">No. Invoice : <span
                                    style="text-transform: uppercase;">{{ $payment->no_invoice }}</span></h2>
                        </div>
                    </div>
                </div>
                <br><br><br><br><br><br><br>
                <table>
                    <thead>
                        <tr>
                            <th width='5%' class="text-left">NO.</th>
                            <th class="text-left">SUBMATERI</th>
                            <th width='10%' style="text-align: right;">HARGA</th>
                            <th width='10%' style="text-align: right;">DISKON</th>
                            <th width='10%' style="text-align: right;">KODE UNIK</th>
                            <th width='10%' style="text-align: right;">(-)PROMO</th>
                            <th width='10%' style="text-align: right;">(-)REFERRAL</th>
                            <th width='5%' style="text-align: right;">QTY</th>
                            <th style="text-align: right;">TOTAL</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <th class="text-left"
                                style="word-wrap: break-word; overflow: wrap; white-space: unset !important; max-width: 300px;">
                                {{ $materi->nama ?? 'Submateri Tidak Ditemukan' }}
                            </th>
                            <td class="unit">
                                {{ number_format($materi->harga ?? 0, 0, ',', '.') }}
                            </td>
                            <td class="unit">
                                {{ number_format($materi->diskon ?? 0, 0, ',', '.') }}
                            </td>
                            <td class="unit">
                                {{ number_format($payment->unique_code ?? 0, 0, ',', '.') }}
                            </td>
                            <td class="unit">
                                {{ number_format($payment->promo ?? 0, 0, ',', '.') }}
                            </td>
                            <td class="unit">
                                {{ number_format($payment->reff ?? 0, 0, ',', '.') }}
                            </td>
                            <td class="unit">
                                {{ $payment->jumlah ?? 1 }}
                            </td>
                            <td class="unit">
                                {{ number_format($payment->totalAkhir ?? ($payment->nominal ?? 0), 0, ',', '.') }}
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div style="text-align: right">
                    <h2>Grand Total : Rp
                        {{ number_format($payment->totalAkhir ?? ($payment->nominal ?? 0), 0, ',', '.') }}</h2>
                    @if (isset($terbilang))
                        <p style="text-transform: capitalize;">{{ $terbilang }}</p>
                    @endif
                </div>
                <div class="notices">
                    <div>Informasi:</div>
                    <div class="notice">
                        Bank : BCA || No.Rekening : 8035559091 || Atas Nama : PT. Bankir Academy Indonesia
                    </div>
                    <div class="notice">
                        Apabila telah melakukan pembayaran harap melakukan Konfirmasi pada Whatsapp +62895333017060 atau
                        pada nomor (024) 76435498
                    </div>
                </div>
            </main>
        </div>
        <div></div>
    </div>
</body>

</html>
