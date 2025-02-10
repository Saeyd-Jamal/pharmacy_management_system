<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Medicine;
use App\Models\PurchaseInvoice;
use App\Models\PurchaseInvoiceItem;
use App\Models\SaleInvoice;
use App\Models\SaleInvoiceItem;
use App\Models\Supplier;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Mccarlosen\LaravelMpdf\Facades\LaravelMpdf as PDF;

class ReportController extends Controller
{
    // مصفوفة لأسماء الأشهر باللغة العربية
    protected $monthNameAr;

    public function __construct(){
        $this->monthNameAr = [
            '01' => 'يناير',
            '02' => 'فبراير',
            '03' => 'مارس',
            '04' => 'أبريل',
            '05' => 'مايو',
            '06' => 'يونيو',
            '07' => 'يوليو',
            '08' => 'أغسطس',
            '09' => 'سبتمبر',
            '10' => 'أكتوبر',
            '11' => 'نوفمبر',
            '12' => 'ديسمبر'
        ];
    }

    public function index(){
        $this->authorize('report.view');
        $month = Carbon::now()->format('Y-m');
        $suppliers = Supplier::all();
        $customer_names = SaleInvoice::select('customer_name')->distinct()->pluck('customer_name')->toArray();
        $categories = Category::all();

        return view('dashboard.pages.report', compact('month', 'suppliers', 'customer_names', 'categories'));
    }


    public function export(Request $request)
    {
        $report_type = $request->report_type;
        $export_type = $request->export_type;
        $type_print = $request->type_print ?? 'A4';

        // Filters 
        $month = $request->month ?? Carbon::now()->format('Y-m');
        $to_month = $request->to_month != null || $request->to_month != '' ? $request->to_month : Carbon::now()->format('Y-m');
        $suppliers = $request->supplier_id;
        $categories = $request->category_id;
        $customer_names = $request->customer_name;

        if($report_type == 'current_inventory'){
            $medicines = Medicine::with('category', 'supplier')->get();

            // Apply filters
            if($suppliers != null){
                $medicines = $medicines->whereIn('supplier_id', $suppliers);
            }
            if($categories != null){
                $medicines = $medicines->whereIn('category_id', $categories);
            }

            if($export_type == 'view' || $export_type == 'export_pdf'){
                $margin_top = 3;
                $pdf = PDF::loadView('dashboard.reports.current_inventory',['medicines' =>  $medicines],[],[
                    'format' => $type_print,
                    'margin_left' => 3,
                    'margin_right' => 3,
                    'margin_top' => $margin_top,
                    'margin_bottom' => 10
                ]);
                return $pdf->stream();
            }
        }

        if($report_type == 'supplier_report'){
            $suppliers = Supplier::with('medicines','purchaseInvoices')->get();

            // Apply filters
            foreach($suppliers as $supplier){
                $medicines = $supplier->medicines;
                if($categories != null){
                    $medicines = $medicines->whereIn('category_id', $categories);
                }
                if($customer_names != null){
                    $medicines = $medicines->whereIn('customer_name', $customer_names);
                }
                $supplier->medicines = $medicines;

                $purchaseInvoices = $supplier->purchaseInvoices;
                $purchaseInvoices = $purchaseInvoices->whereBetween('date',[$month.'-01',$to_month.'-31']);
                $supplier->purchaseInvoices = $purchaseInvoices;
            }
            if($export_type == 'view' || $export_type == 'export_pdf'){
                $margin_top = 3;
                $pdf = PDF::loadView('dashboard.reports.supplier_report',['suppliers' =>  $suppliers],[],[
                    'format' => $type_print,
                    'margin_left' => 3,
                    'margin_right' => 3,
                    'margin_top' => $margin_top,
                    'margin_bottom' => 10
                ]);
                return $pdf->stream();
            }
        }

        if($report_type == 'day_sale_report'){
            $purchaseInvoices = PurchaseInvoice::with('medicines')->get();
            $saleInvoices = SaleInvoice::with('medicines')->get();
            // Apply filters
            $purchaseInvoices = $purchaseInvoices->whereBetween('date',[$month.'-01',$to_month.'-31']);
            $saleInvoices = $saleInvoices->whereBetween('date',[$month.'-01',$to_month.'-31']);
            if($suppliers != null){
                $purchaseInvoices = $purchaseInvoices->whereIn('supplier_id', $suppliers);
            }
            if($customer_names != null){
                $saleInvoices = $saleInvoices->whereIn('customer_name', $customer_names);
            }

            $dates = [];
            $total_quantities = 0;
            $total_prices = 0;
            $total_amounts = 0;
            foreach($purchaseInvoices as $purchaseInvoice){
                $dates[] = $purchaseInvoice->date;
                $total_quantities += PurchaseInvoiceItem::where('purchase_invoice_id', $purchaseInvoice->id)->sum('quantity');
                $total_prices += PurchaseInvoiceItem::where('purchase_invoice_id', $purchaseInvoice->id)->sum('total_price');
                $total_amounts_temp = 0;
                foreach($purchaseInvoice->medicines as $medicine){
                    $total_amounts_temp += $medicine->price - $medicine->unit_price;
                }
                $total_amounts += $total_amounts_temp;
            } 
            foreach($saleInvoices as $saleInvoice){
                $dates[] = $saleInvoice->date;
                $total_quantities += SaleInvoiceItem::where('sale_invoice_id', $saleInvoice->id)->sum('quantity');
                $total_prices += SaleInvoiceItem::where('sale_invoice_id', $saleInvoice->id)->sum('total_price');
                $total_amounts_temp = 0;
                foreach($purchaseInvoice->medicines as $medicine){
                    $total_amounts_temp += $medicine->price - $medicine->unit_price;
                }
                $total_amounts += $total_amounts_temp;            
            } 
            $dates = array_unique($dates);
            sort($dates);

            if($export_type == 'view' || $export_type == 'export_pdf'){
                $margin_top = 3;
                $pdf = PDF::loadView('dashboard.reports.day_sale_report',['purchaseInvoices' =>  $purchaseInvoices, 'saleInvoices' =>  $saleInvoices, 'dates' =>  $dates, 'total_quantities' =>  $total_quantities, 'total_prices' =>  $total_prices, 'total_amounts' =>  $total_amounts],[],[
                    'format' => $type_print,
                    'margin_left' => 3,
                    'margin_right' => 3,
                    'margin_top' => $margin_top,
                    'margin_bottom' => 10
                ]);
                return $pdf->stream();
            }
        }
    }

}
