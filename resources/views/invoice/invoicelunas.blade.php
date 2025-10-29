<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<<<<<<< HEAD
    <title>Invoice</title>
=======
    <title>TITLE</title>
>>>>>>> 6a64ba7d511d7658144f76f58b9770456dae4af7
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

        .col-xl,
        .col-xl-auto,
        .col-xl-12,
        .col-xl-11,
        .col-xl-10,
        .col-xl-9,
        .col-xl-8,
        .col-xl-7,
        .col-xl-6,
        .col-xl-5,
        .col-xl-4,
        .col-xl-3,
        .col-xl-2,
        .col-xl-1,
        .col-lg,
        .col-lg-auto,
        .col-lg-12,
        .col-lg-11,
        .col-lg-10,
        .col-lg-9,
        .col-lg-8,
        .col-lg-7,
        .col-lg-6,
        .col-lg-5,
        .col-lg-4,
        .col-lg-3,
        .col-lg-2,
        .col-lg-1,
        .col-md,
        .col-md-auto,
        .col-md-12,
        .col-md-11,
        .col-md-10,
        .col-md-9,
        .col-md-8,
        .col-md-7,
        .col-md-6,
        .col-md-5,
        .col-md-4,
        .col-md-3,
        .col-md-2,
        .col-md-1,
        .col-sm,
        .col-sm-auto,
        .col-sm-12,
        .col-sm-11,
        .col-sm-10,
        .col-sm-9,
        .col-sm-8,
        .col-sm-7,
        .col-sm-6,
        .col-sm-5,
        .col-sm-4,
        .col-sm-3,
        .col-sm-2,
        .col-sm-1,
        .col,
        .col-auto,
        .col-12,
        .col-11,
        .col-10,
        .col-9,
        .col-8,
        .col-7,
        .col-6,
        .col-5,
        .col-4,
        .col-3,
        .col-2,
        .col-1 {
            position: relative;
            width: 100%;
            padding-right: 15px;
            padding-left: 15px;
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
            /* padding: 1px */

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

        .invoice main .thanks {
            margin-top: -100px;
            font-size: 2em;
            margin-bottom: 50px
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

            /* background-color: aqua; */
            /* background-image: url(admin/assets/images/lunas-watermark-02.png); */
        }

        .invoice table::after {
            content: "";
            background: url('lunas-watermark-03.png');
            top: 280px;
            left: 150px;
            bottom: 0px;
            right: 0px;
            background-size: 700px 400px;
            position: absolute;
            z-index: -1;
            background-repeat: no-repeat;
            /* opacity: 0.7; */
            /* background-position: 30px 30px; */
        }

        .invoice table td,
        .invoice table th {
            padding: 15px;
            background: #eee;
            border-bottom: 1px solid #fff;
        }

        .invoice table th {
            white-space: nowrap;
            font-weight: 400;
            font-size: 10px
        }

        .invoice table td h3 {
            margin: 0;
            font-weight: 400;
            color: #0d6efd;
            font-size: 1.2em
        }

        .invoice table .qty,
        .invoice table .total,
        .invoice table .unit {
            text-align: right;
            font-size: 1.2em
        }

        .invoice table .no {
            color: #fff;
            font-size: 1.6em;
            background: #0d6efd
        }

        .invoice table .unit {
            background: #ddd
        }

        .invoice table .total {
            background: #0d6efd;
            color: #fff
        }

        .invoice table tbody tr:last-child td {
            border: none
        }

        .invoice table tfoot td {
            background: 0 0;
            border-bottom: none;
            white-space: nowrap;
            text-align: right;
            padding: 10px 20px;
            font-size: 1.1em;
            border-top: 1px solid #aaa
        }

        .invoice table tfoot tr:first-child td {
            border-top: none
        }

        .invoice table tfoot tr:last-child td {
            color: #0d6efd;
            font-size: 1.4em;
            border-top: 1px solid #0d6efd
        }

        .invoice table tfoot tr td:first-child {
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

        .float-none {
            float: none !important;
        }

        .d-flex {
            display: -ms-flexbox !important;
            display: flex !important;
        }

        .flex-row {
            -ms-flex-direction: row !important;
            flex-direction: row !important;
        }

        .flex-column {
            -ms-flex-direction: column !important;
            flex-direction: column !important;
        }

        .flex-row-reverse {
            -ms-flex-direction: row-reverse !important;
            flex-direction: row-reverse !important;
        }

        .flex-column-reverse {
            -ms-flex-direction: column-reverse !important;
            flex-direction: column-reverse !important;
        }

        .flex-container {
            display: flex;
            background-color: #f1f1f1;
        }

        .flex-container>div {
            background-color: DodgerBlue;
            color: white;
            width: 100px;
            margin: 10px;
            text-align: center;
            line-height: 75px;
            font-size: 30px;
        }

        .row {
            display: -ms-flexbox;
            display: flex;
            -ms-flex-wrap: wrap;
            flex-wrap: wrap;
            margin-right: -15px;
            margin-left: -15px;
        }

        /* header {
			display: flex;
			padding: 10px
		} */

        img {
            float: left;
            margin-left: 15px;
            margin-right: 15px;
        }

        .text-center {
            text-align: center !important;
        }

        .address {
            text-align: justify;
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
                        <h2 class="name">
                            <a target="_blank">
                                {{-- AKARINDO.ID --}}
                            </a>
                        </h2>
                        <div>
                            Jl. Jenderal Sudirman No.354, Gisikdrono, Kec.
                            Semarang Barat, Kota Semarang, Jawa Tengah 50149
                            <br>
                            (024) 76435498
                            <br>
                            info.ehrindo@gmail.com
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
                            <h2 class="to">{{$profile->name}}</h2>
                            <div class="email"><a href="mailto:">{{Auth::user()->email}}</a></div>
                            <small>({{$profile->phone_region}}){{$profile->phone}}</small>
                            <br>
                            <small>{{substr($profile->description,0,97).'...'}}</small>
                        </div>
                    </div>
                    <div class="float-right invoice-details">
                        <div class="col-lg-6">
                            <div class="date">Tanggal Invoice
                                :{{Carbon\Carbon::parse($payment->created_at)->format('d-m-Y')}}</div>
                            <h2 class="invoice-id">No. Invoice : <span
                                    style="text-transform: uppercase;">{{$payment->no_invoice}}</span></h2>
                        </div>
                    </div>
                </div>
                <br><br><br><br><br><br><br>
                <table>
                    <thead>
                        <tr>
                            <th width='5%' class="text-left">NO.</th>
                            <th class="text-left">KELAS</th>
                            <th width='5%' style="text-align: right;">HARGA</th>
                            {{-- <th width='5%' style="text-align: right;">PROMO</th> --}}
                            <th width='5%' style="text-align: right;">ADD. DISKON</th>
                            <th width='5%' style="text-align: right;">KODE UNIK</th>
                            <th width='5%' style="text-align: right;">(-)PROMO</th>
                            <th width='5%' style="text-align: right;">(-)KUPON</th>
                            <th width='5%' style="text-align: right;">(-)REFERRAL</th>
                            <th width='5%' style="text-align: right;">SERTIFIKAT</th>
                            <th width='5%' style="text-align: right;">QTY</th>
                            <th style="text-align: right;">TOTAL</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <th class="text-left"
                                style="word-wrap: break-word; overflow: wrap; white-space: unset !important; max-width: 300px;">
<<<<<<< HEAD
                                {{$class->title}}
                            </th>
=======
                                {{$class->title}}</th>
>>>>>>> 6a64ba7d511d7658144f76f58b9770456dae4af7
                            <td class="unit">{{substr(numfmt_format_currency(numfmt_create('id_ID',
                                \NumberFormatter::CURRENCY),$class->pricing->price,"IDR"),0,-3) }}</td>
                            {{-- <td class="unit">
                                {{substr(numfmt_format_currency(numfmt_create('id_ID',
                                \NumberFormatter::CURRENCY),$payment->unique_code?$payment->unique_code:0,"IDR"),0,-3) }}
                            </td> --}}
                            @if($diskon_existing>0)
                            <td class="unit">
                                {{-- {{substr(numfmt_format_currency(numfmt_create('id_ID',
                                \NumberFormatter::CURRENCY),$diskon_existing,"IDR"),0,-3) }} --}}
                                {{$diskon_existing}} %
                            </td>
                            @else
                            <td class="unit">
                                {{substr(numfmt_format_currency(numfmt_create('id_ID',
                                \NumberFormatter::CURRENCY),0,"IDR"),0,-3) }}
                            </td>
                            @endif
                            <td class="unit">
                                {{substr(numfmt_format_currency(numfmt_create('id_ID',
                                \NumberFormatter::CURRENCY),$payment->unique_code?$payment->unique_code:0,"IDR"),0,-3) }}
                            </td>
                            <td class="unit">
                                @if ($class->pricing->promo==1)
                                {{substr(numfmt_format_currency(numfmt_create('id_ID',
                                \NumberFormatter::CURRENCY),$class->pricing->promo_price,"IDR"),0,-3) }}
                                @endif
                            </td>
                            <td class="unit">
                                @if ($payment->promo)
                                {{substr(numfmt_format_currency(numfmt_create('id_ID',
                                \NumberFormatter::CURRENCY),$payment->promo,"IDR"),0,-3)}}
                                @endif
                            </td>
                            <td class="unit">
                                {{substr(numfmt_format_currency(numfmt_create('id_ID',
                                \NumberFormatter::CURRENCY),$payment->reff,"IDR"),0,-3)}}
                            </td>
                            <td class="unit">
                                {{substr(numfmt_format_currency(numfmt_create('id_ID',
                                \NumberFormatter::CURRENCY),$payment->sertifikat?$payment->sertifikat:0,"IDR"),0,-3)}}
                            </td>
                            <td class="unit">
                                {{$payment->jumlah}}
                            </td>
                            <td class="unit">
                                {{substr(numfmt_format_currency(numfmt_create('id_ID',
                                \NumberFormatter::CURRENCY),$payment->totalAkhir,"IDR"),0,-3)
                                }}
                            </td>
                        </tr>
                    </tbody>
                    <tfoot>
                        {{-- <tr>
                            <td colspan="1"></td>
                            <td colspan="2">SUBTOTAL</td>
                            <td>SUBTOTAL</td>
                        </tr> --}}

                        {{-- <tr>
                            <td colspan="1"></td>
                            <td colspan="2">PAJAK PAJAK</td>
                            <td>NOMINAL PAJAK</td>
                        </tr> --}}
                        {{-- <tr>
                            <td colspan="5"></td>
                            <td colspan="2">GRAND TOTAL</td>
                            <td>{{substr(numfmt_format_currency(numfmt_create('id_ID',
                                \NumberFormatter::CURRENCY),$payment->totalAkhir,"IDR"),0,-3)
                                }}</td>
                        </tr> --}}
                    </tfoot>
                </table>
                <div style="text-align: right">
                    <h2>Grand Total : {{substr(numfmt_format_currency(numfmt_create('id_ID',
                        \NumberFormatter::CURRENCY),$payment->totalAkhir,"IDR"),0,-3)
                        }}</h2>
                    <p style="text-transform: capitalize;">{{$terbilang}}</p>
                </div>
                <div class="notices">
                    <div>Informasi:</div>
                    <div class="notice">
<<<<<<< HEAD
                        Bank : BNI || No.Rekening : 1956061505 || Atas Nama
                        : CV Anugrah Karya Indonesia
                    </div>
                    <div class="notice">
                        Apabila telah melakukan pembayaran harap melakukan
                        Konfirmasi pada Whatsapp +62895333017060 atau pada
=======
                        Bank : BCA || No.Rekening : 8035559091 || Atas Nama
                        : PT. Bankir Academy Indonesia
                    </div>
                    <div class="notice">
                        Apabila telah melakukan pembayaran harap melakukan
                        Konfirmasi pada Whatsapp +6289531229494 atau pada
>>>>>>> 6a64ba7d511d7658144f76f58b9770456dae4af7
                        nomor (024) 76435498
                    </div>
                </div>
            </main>
        </div>
        <!--DO NOT DELETE THIS div. IT is responsible for showing footer always at the bottom-->
        <div></div>
    </div>
</body>

</html>