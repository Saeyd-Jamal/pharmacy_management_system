<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Medicine;
use App\Models\MedicineSize;
use App\Models\SaleInvoice;
use App\Models\SaleInvoiceItem;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Mccarlosen\LaravelMpdf\Facades\LaravelMpdf as PDF;

class SaleInvoiceConrtoller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('view', SaleInvoice::class);

        $request = request();
        if ($request->ajax()) {
            $saleInvoices = SaleInvoice::query();

            if($request->from_date && $request->to_date){
                $saleInvoices->whereBetween('date', [$request->from_date, $request->to_date]);
            }
            if($request->year){
                $saleInvoices->whereYear('date', $request->year);
            }

            return DataTables::of($saleInvoices)
                ->addIndexColumn()
                ->editColumn('count_items', function ($saleInvoice) {
                    return $saleInvoice->medicines()->count();
                })
                ->editColumn('status', function ($saleInvoice) {
                    return $saleInvoice->status == 'active' ? 'نشط' : 'أرشيف';
                })
                ->addColumn('created_by', function ($saleInvoice) {
                    return $saleInvoice->user->name ?? 'غير محدد';
                })
                ->addColumn('print', function ($saleInvoice) {
                    return $saleInvoice->id;
                })
                ->addColumn('edit', function ($saleInvoice) {
                    return $saleInvoice->id;
                })
                ->addColumn('delete', function ($saleInvoice) {
                    return $saleInvoice->id;
                })
                ->make(true);
        }

        return view('dashboard.saleInvoices.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', SaleInvoice::class);
        $saleInvoice = new SaleInvoice();
        $categories = Category::all();
        $medicines = Medicine::with('sizes')->take(5)->get();

        $saleInvoice->id = SaleInvoice::orderBy('id', 'desc')->first() ? SaleInvoice::orderBy('id', 'desc')->first()->id + 1 : 1;
        $saleInvoice->date = date('Y-m-d');
        $saleInvoice->medicines = collect([]);

        $customer_names = SaleInvoice::select('customer_name')->distinct()->pluck('customer_name')->toArray();
        $suppliers = Supplier::all();

        return view('dashboard.saleInvoices.create', compact('saleInvoice','categories','medicines','customer_names','suppliers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'item_count' => 'required|integer|min:1',
            'customer_name' => 'nullable|string',
            'total_amount' => 'required|numeric',
            'medicine_id*' => 'required|integer|exists:medicines,id',
            'quantity*' => 'required|integer',
            'unit_price*' => 'required|numeric',
            'total_price*' => 'required|numeric',
            'size_id*' => 'required|integer|exists:medicine_sizes,id',
            'size*' => 'required|string',
        ]);
        DB::beginTransaction();
        try{
            $customer_name = $request->customer_name == null ? 'زبون عام' : $request->customer_name;

            $saleInvoice = SaleInvoice::create([
                'date' => $request->date,
                'total_amount' => $request->total_amount,
                'customer_name' => $customer_name,
                'created_by' => Auth::user()->id,
                'created_by_name' => Auth::user()->name,
            ]);
            $items_count = $request->item_count;
            for ($i = 0; $i < $items_count; $i++) {
                $saleInvoiceItem = SaleInvoiceItem::create([
                    'medicine_id' => $request->medicine_id[$i],
                    'sale_invoice_id' => $saleInvoice->id,
                    'unit_price' => $request->unit_price[$i],
                    'quantity' => $request->quantity[$i],
                    'total_price' => $request->total_price[$i],
                    'size' => $request->size[$i],
                    'size_id' => $request->size_id[$i],
                ]);
                $medicine = MedicineSize::find($saleInvoiceItem->size_id);
                $medicine->update([
                    'quantity' => $medicine->quantity - $saleInvoiceItem->quantity
                ]);
            }
            DB::commit();
            return redirect()->route('dashboard.saleInvoices.index')->with('success', __('Item updated successfully'));
        }catch(\Exception $e){
            DB::rollBack();
            // throw $e;
            return redirect()->back()->with('danger', $e->getMessage());
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(SaleInvoice $saleInvoice)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SaleInvoice $saleInvoice)
    {
        $this->authorize('update', SaleInvoice::class);
        $customer_names = SaleInvoice::select('customer_name')->distinct()->pluck('customer_name')->toArray();
        $suppliers = Supplier::all();
        $categories = Category::all();
        $medicines = Medicine::all();

        $btn_label = "تعديل";
        return view('dashboard.saleInvoices.edit', compact('saleInvoice','btn_label', 'categories','medicines','customer_names','suppliers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SaleInvoice $saleInvoice)
    {
        $request->validate([
            'date' => 'required|date',
            'item_count' => 'required|integer|min:1',
            'customer_name' => 'nullable|string',
            'total_amount' => 'required|numeric',
            'medicine_id*' => 'required|integer|exists:medicines,id',
            'quantity*' => 'required|integer',
            'unit_price*' => 'required|numeric',
            'total_price*' => 'required|numeric',
            'size_id*' => 'required|integer|exists:medicine_sizes,id',
            'size*' => 'required|string',
        ]);
        DB::beginTransaction();
        try{
            $customer_name = $request->customer_name == null ? 'زبون عام' : $request->customer_name;
            $saleInvoice->update([
                'date' => $request->date,
                'total_amount' => $request->total_amount,
                'customer_name' => $customer_name,
                'created_by' => Auth::user()->id,
                'created_by_name' => Auth::user()->name,
            ]);
            $items_count = $request->item_count;
            for ($i = 0; $i < $items_count; $i++) {
                $saleInvoiceitems = SaleInvoiceItem::where('sale_invoice_id', $saleInvoice->id)->where('medicine_id', $request->medicine_id[$i])->first();
                if ($saleInvoiceitems) {
                    $medicine = MedicineSize::find($saleInvoiceitems->size_id);
                    $medicine->update([
                        'quantity' => ($medicine->quantity + $saleInvoiceitems->quantity) - $request->quantity[$i]
                    ]);
                    $saleInvoiceitems->update([
                        'unit_price' => $request->unit_price[$i],
                        'quantity' => $request->quantity[$i],
                        'total_price' => $request->total_price[$i],
                        'size' => $request->size[$i],
                        'size_id' => $request->size_id[$i],
                    ]);
                }else{
                    $saleInvoiceitem = SaleInvoiceItem::create([
                        'medicine_id' => $request->medicine_id[$i],
                        'sale_invoice_id' => $saleInvoice->id,
                        'unit_price' => $request->unit_price[$i],
                        'quantity' => $request->quantity[$i],
                        'total_price' => $request->total_price[$i],
                        'size' => $request->size[$i],
                        'size_id' => $request->size_id[$i],
                    ]);
                    $medicine = MedicineSize::find($saleInvoiceitem->size_id);
                    $medicine->update([
                        'quantity' => $medicine->quantity - $saleInvoiceitem->quantity
                    ]);
                }
            }
            DB::commit();
            return redirect()->route('dashboard.saleInvoices.index')->with('success', __('Item updated successfully'));
        }catch(\Exception $e){
            DB::rollBack();
            // throw $e;
            return redirect()->back()->with('danger', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SaleInvoice $saleInvoice)
    {
        $this->authorize('delete', SaleInvoice::class);
        $saleInvoiceitems = SaleInvoiceItem::where('sale_invoice_id', $saleInvoice->id)->get();
        foreach ($saleInvoiceitems as $saleInvoiceitem) {
            $medicine = MedicineSize::find($saleInvoiceitem->size_id);
            $medicine->update([
                'quantity' => $medicine->quantity + $saleInvoiceitem->quantity
            ]);
        }
        $saleInvoice->delete();

        return response()->json(['message' => __('Item deleted successfully.')]);
    }

    public function print(SaleInvoice $saleInvoice)
    {
        $this->authorize('print', SaleInvoice::class);
        $margin_top = 3;
        $pdf = PDF::loadView('dashboard.reports.saleInvoice',['saleInvoice' =>  $saleInvoice,'items' =>  $saleInvoice->medicines],[],[
            'format' => 'A4',
            'margin_left' => 3,
            'margin_right' => 3,
            'margin_top' => $margin_top,
            'margin_bottom' => 10,
        ]);
        return $pdf->stream();
    }
}
