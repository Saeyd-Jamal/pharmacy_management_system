<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="utf-8" />
    <title>تقرير الموردين</title>
    <style>
        *{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'XBRiyaz', sans-serif;
        }
        @page {
            header: page-header;
            footer: page-footer;
        }
        hr {
            right: 25px;
        }
        html {
            direction: rtl;
        }

        .head_td{
            text-align: right;
        }
        h3 {
            text-align: center;
            margin-top: 0;
            margin-bottom: 1em;
        }
    </style>
    <style>
        .container {
            max-width: 100%;
            margin: 0 10px;
        }

        .personal-info-title {
            text-align: right;
            color: #632423;
        }

        .table-responsive {
            text-align: justify;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table td {
            padding: 12px;
            border: 1px solid #000000;
            font-size: 35px;
        }

        .head_td {
            background: #d6e3bc;
            font-weight: bold;
            width: 350px;
            font-size: 35px;
        }

        .data_td {
            background: #fdf8ed;
            color: #000000;
        }

        /* Specific width adjustments */
        .gender-label {
            width: 207px;
        }

        .wide-cell {
            width: 800px;
        }

        .medium-cell {
            width: 700px;
        }

        .relation-label {
            width: 366px;
        }

        /* Table responsiveness */
        @media screen and (max-width: 768px) {
            .table-responsive {
                overflow-x: auto;
            }

            .table td {
                white-space: nowrap;
            }
        }
    </style>
    <style>
        table.blueTable {
            width: 100%;
            text-align: right;
            border-collapse: collapse;
        }

        table.blueTable td,
        table.blueTable th {
            border: 1px solid #AAAAAA;
            padding: 5px 9px;
            white-space: nowrap;
        }

        table.blueTable tbody td {
            font-size: 13px;
            color: #000000;
        }

        table.blueTable tr:nth-child(even) {
            background: #F5F5F5;
        }

        table.blueTable thead {
            background: #eeeeee;
            background: -moz-linear-gradient(top, #dedede 0%, #d7d7d7 66%, #D3D3D3 100%);
            background: -webkit-linear-gradient(top, #dedede 0%, #d7d7d7 66%, #D3D3D3 100%);
            background: linear-gradient(to bottom, #dedede 0%, #d7d7d7 66%, #D3D3D3 100%);
            border-bottom: 2px solid #444444;
        }

        table.blueTable thead th {
            font-size: 18px;
            font-weight: bold;
            text-align: right;
        }

        table.blueTable tfoot {
            font-size: 14px;
            font-weight: bold;
            color: #FFFFFF;
            background: #EEEEEE;
            background: -moz-linear-gradient(top, #f2f2f2 0%, #efefef 66%, #EEEEEE 100%);
            background: -webkit-linear-gradient(top, #f2f2f2 0%, #efefef 66%, #EEEEEE 100%);
            background: linear-gradient(to bottom, #f2f2f2 0%, #efefef 66%, #EEEEEE 100%);
            border-top: 2px solid #444444;
        }

        table.blueTable tfoot td {
            font-size: 14px;
        }

        table.blueTable tfoot .links {
            text-align: right;
        }

        table.blueTable tfoot .links a {
            display: inline-block;
            background: #1C6EA4;
            color: #FFFFFF;
            padding: 2px 8px;
            border-radius: 5px;
        }
    </style>
</head>

<body>
    <htmlpageheader name="page-header">
    </htmlpageheader>

    <div id="content" lang="ar" style="margin-top: 5em;">
        <div class="container">
            <div style="margin: 1em 0;">
                <div style="float: right; width: 60%; text-align: right;">
                    <h2 style="display: inline;">
                        {{ config('app.name_shop') }}
                    </h2>
                </div>
                <div style="float: left; width: 40%; text-align: left;">
                    <p style="margin-bottom: 0;">{{Carbon\Carbon::now()->format('Y-m-d')}}</p>
                </div>
            </div>
            <hr />
            <h2 class="personal-info-title" style="margin-bottom: 1em;">
                تقرير الموردين
            </h2>
            <div class="table-responsive">
                <table class="blueTable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>المورد</th>
                            <th>مندوب</th>
                            <th>العنوان</th>
                            <th>إجمالي عدد الأدوية</th>
                            <th>إجمالي حساب الفواتير</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $total_quantity = 0;
                            $total_amount = 0;
                        @endphp
                        @foreach ($suppliers as $supplier)
                            @php
                                $total_quantity += $supplier->medicines->sum('quantity');
                                $total_amount += $supplier->purchaseInvoices->sum('total_amount');
                            @endphp
                            <tr>
                                <th>{{ $loop->iteration }}</th>
                                <th>{{ $supplier->name }}</th>
                                <th>{{ $supplier->contact_person}}</th>
                                <th>{{ $supplier->address }}</th>
                                <th>{{ $supplier->medicines->sum('quantity') }}</th>
                                <th>{{ $supplier->purchaseInvoices->sum('total_amount') }}</th>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="4" class="text-center">المجموع</th>
                            <th>{{ $total_quantity }}</th>
                            <th>{{ $total_amount }}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>     
        </div>
        {{-- <tr>
            <td class="head_td"> :</td>
            <td class="data_td wide-cell"></td>
            <td class="head_td gender-label">  :&nbsp;</td>
            <td class="data_td medium-cell"></td>
        </tr> --}}

    </div>


</body>

</html>
