<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="utf-8" />
    <title>جدول المستحقات والقروض للموظفين</title>
    <style>
        body {
            font-family: 'XBRiyaz', sans-serif;
        }

        @page {
            header: page-header;
            footer: page-footer;
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
            background: #D3D3D3;
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
    @php
        $filedsEmpolyees = [
            'gender',
            'matrimonial_status',
            'scientific_qualification',
            'area',
            'working_status',
            'type_appointment',
            'field_action',
            'dual_function',
            'state_effectiveness',
            'nature_work',
            'association',
            'workplace',
            'section',
            'dependence',
            'establishment',
            'payroll_statement'
        ];
    @endphp
    <htmlpageheader name="page-header">
        <div style="padding: 5px 0">
            @if(!isset($filter["association"][1]) && isset($filter["association"][0]))
                @if ($filter["association"][0] == "المدينة")
                <img src="{{ public_path('imgs/headers/city_architecture.jpg') }}" style="max-width: 100%;" alt="">
                @elseif ($filter["association"][0] == "حطين")
                <img src="{{ public_path('imgs/headers/hetten.png') }}" style="max-width: 100%;" alt="">
                @elseif ($filter["association"][0] == "الكويتي")
                <img src="{{ public_path('imgs/headers/Kuwaiti.jpg') }}" style="max-width: 100%;" alt="">
                @elseif ($filter["association"][0] == "يتيم")
                <img src="{{ public_path('imgs/headers/orphan.jpg') }}" style="max-width: 100%;" alt="">
                @elseif ($filter["association"][0] == "صلاح")
                <img src="{{ public_path('imgs/headers/salah.png') }}" style="max-width: 100%;" alt="">
                @endif
            @endif
        </div>
    </htmlpageheader>

    <div lang="ar">
        <table class="blueTable">
            <thead>
                <tr style="background: #ffffff; border:0;">
                    <td colspan="7" style="border:0;">
                        <p>
                            <span>قسم المالية</span> /
                            <span>جدول المستحقات والقروض للموظفين</span>
                            @if (isset($filter))
                                @foreach ($filedsEmpolyees as $name)
                                    @if (isset($filter["$name"]))
                                    /
                                        @foreach ($filter["$name"] as $value)
                                            <span> {{ $value }} / </span>
                                        @endforeach
                                    @endif
                                @endforeach
                            @endif
                        </p>
                    </td>
                </tr>
                <tr style="background: #ffffff; border:0;">
                    <td colspan="7" align="center" style="color: #000;border:0;">
                        <h1>جدول المستحقات والقروض للموظفين</h1>
                    </td>
                </tr>
                <tr  style="background: #dddddd;">
                    <th>#</th>
                    <th>الاسم</th>
                    <th>إجمالي المستحقات</th>
                    <th>إجمالي الإدخارات $</th>
                    <th>قرض الجمعية</th>
                    <th>قرض الإدخار $</th>
                    <th>قرض اللجنة</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($totals as $total)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $total->employee->name }}</td>
                        <td>{{ $total->total_receivables_view }}</td>
                        <td>{{ $total->total_savings_view }}</td>
                        <td>{{ $total->total_association_loan_view }}</td>
                        <td>{{ $total->total_savings_loan_view }}</td>
                        <td>{{ $total->total_shekel_loan_view }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr  style="background: #dddddd;">
                    <td>00</td>
                    <td>الإجمالي الكلي</td>
                    <td>{{ $totalsFooterArray['total_receivables'] }}</td>
                    <td>{{ $totalsFooterArray['total_savings'] }}</td>
                    <td>{{ $totalsFooterArray['total_association_loan'] }}</td>
                    <td>{{ $totalsFooterArray['total_savings_loan'] }}</td>
                    <td>{{ $totalsFooterArray['total_shekel_loan'] }}</td>
                </tr>
            </tfoot>
        </table>
        <htmlpagefooter name="page-footer">
            <table width="100%" style="vertical-align: bottom; color: #000000;  margin: 1em">
                <tr>
                    <td width="33%">{DATE j-m-Y}</td>
                    <td width="33%" align="center">{PAGENO}/{nbpg}</td>
                    @auth
                        <td width="33%" style="text-align: left;">{{ Auth::user()->name }}</td>
                    @else
                        <td width="33%" style="text-align: left;">اسم المستخدم</td>
                    @endauth
                </tr>
            </table>
        </htmlpagefooter>
    </div>


</body>

</html>
