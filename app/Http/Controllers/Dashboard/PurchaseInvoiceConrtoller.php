<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Medicine;
use App\Models\MedicineSize;
use App\Models\PurchaseInvoice;
use App\Models\PurchaseInvoiceItem;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Mccarlosen\LaravelMpdf\Facades\LaravelMpdf as PDF;

class PurchaseInvoiceConrtoller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('view', PurchaseInvoice::class);

        $request = request();
        if ($request->ajax()) {
            $purchaseInvoices = PurchaseInvoice::query();

            if($request->from_date && $request->to_date){
                $purchaseInvoices->whereBetween('date', [$request->from_date, $request->to_date]);
            }
            if($request->year){
                $purchaseInvoices->whereYear('date', $request->year);
            }

            return DataTables::of($purchaseInvoices)
                ->addIndexColumn()
                ->editColumn('count_items', function ($purchaseInvoice) {
                    return $purchaseInvoice->medicines()->count();
                })
                ->editColumn('status', function ($purchaseInvoice) {
                    return $purchaseInvoice->status == 'active' ? 'نشط' : 'أرشيف';
                })
                ->addColumn('created_by', function ($purchaseInvoice) {
                    return $purchaseInvoice->user->name ?? 'غير محدد';
                })
                ->addColumn('print', function ($purchaseInvoice) {
                    return $purchaseInvoice->id;
                })
                ->addColumn('edit', function ($purchaseInvoice) {
                    return $purchaseInvoice->id;
                })
                ->addColumn('delete', function ($purchaseInvoice) {
                    return $purchaseInvoice->id;
                })
                ->make(true);
        }

        return view('dashboard.purchaseInvoices.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', PurchaseInvoice::class);
        $purchaseInvoice = new PurchaseInvoice();
        $suppliers = Supplier::all();
        $categories = Category::all();
        $medicines = Medicine::with('sizes')->take(5)->get();

        $purchaseInvoice->id = PurchaseInvoice::orderBy('id', 'desc')->first() ? PurchaseInvoice::orderBy('id', 'desc')->first()->id + 1 : 1;
        $purchaseInvoice->date = date('Y-m-d');
        $purchaseInvoice->medicines = collect([]);

        return view('dashboard.purchaseInvoices.create', compact('purchaseInvoice', 'suppliers', 'categories','medicines'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'item_count' => 'required|integer|min:1',
            'supplier_id' => 'required|integer|exists:suppliers,id',
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
            $purchaseInvoice = PurchaseInvoice::create([
                'date' => $request->date,
                'total_amount' => $request->total_amount,
                'supplier_id' => $request->supplier_id,
                'supplier_name' => Supplier::find($request->supplier_id)->name,
                'created_by' => Auth::user()->id,
                'created_by_name' => Auth::user()->name,
            ]);
            $items_count = $request->item_count;
            for ($i = 0; $i < $items_count; $i++) {
                $purchaseInvoiceItem = PurchaseInvoiceItem::create([
                    'medicine_id' => $request->medicine_id[$i],
                    'purchase_invoice_id' => $purchaseInvoice->id,
                    'unit_price' => $request->unit_price[$i],
                    'quantity' => $request->quantity[$i],
                    'total_price' => $request->total_price[$i],
                    'size' => $request->size[$i],
                    'size_id' => $request->size_id[$i],
                ]);
                $medicine = MedicineSize::find($purchaseInvoiceItem->size_id);
                $medicine->update([
                    'quantity' => $medicine->quantity + $purchaseInvoiceItem->quantity
                ]);
            }
            DB::commit();
            return redirect()->route('dashboard.purchaseInvoices.index')->with('success', __('Item updated successfully'));
        }catch(\Exception $e){
            DB::rollBack();
            // throw $e;
            return redirect()->back()->with('danger', $e->getMessage());
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(PurchaseInvoice $purchaseInvoice)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PurchaseInvoice $purchaseInvoice)
    {
        $this->authorize('update', PurchaseInvoice::class);
        $suppliers = Supplier::all();
        $categories = Category::all();
        $medicines = Medicine::all();
        $btn_label = "تعديل";
        return view('dashboard.purchaseInvoices.edit', compact('purchaseInvoice','btn_label', 'suppliers', 'categories','medicines'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PurchaseInvoice $purchaseInvoice)
    {
        $request->validate([
            'date' => 'required|date',
            'item_count' => 'required|integer|min:1',
            'supplier_id' => 'required|integer|exists:suppliers,id',
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
            $purchaseInvoice->update([
                'date' => $request->date,
                'total_amount' => $request->total_amount,
                'supplier_id' => $request->supplier_id,
                'supplier_name' => Supplier::find($request->supplier_id)->name,
                'created_by' => Auth::user()->id,
                'created_by_name' => Auth::user()->name,
            ]);
            $items_count = $request->item_count;
            for ($i = 0; $i < $items_count; $i++) {
                $purchaseInvoiceitems = PurchaseInvoiceItem::where('purchase_invoice_id', $purchaseInvoice->id)->where('medicine_id', $request->medicine_id[$i])->first();
                if ($purchaseInvoiceitems) {
                    $medicine = MedicineSize::find($purchaseInvoiceitems->size_id);
                    $medicine->update([
                        'quantity' => ($medicine->quantity - $purchaseInvoiceitems->quantity) + $request->quantity[$i]
                    ]);
                    $purchaseInvoiceitems->update([
                        'unit_price' => $request->unit_price[$i],
                        'quantity' => $request->quantity[$i],
                        'total_price' => $request->total_price[$i],
                        'size' => $request->size[$i],
                        'size_id' => $request->size_id[$i],
                    ]);
                }else{
                    $purchaseInvoiceitem = PurchaseInvoiceItem::create([
                        'medicine_id' => $request->medicine_id[$i],
                        'purchase_invoice_id' => $purchaseInvoice->id,
                        'unit_price' => $request->unit_price[$i],
                        'quantity' => $request->quantity[$i],
                        'total_price' => $request->total_price[$i],
                        'size' => $request->size[$i],
                        'size_id' => $request->size_id[$i],
                    ]);
                    $medicine = MedicineSize::find($purchaseInvoiceitem->size_id);
                    $medicine->update([
                        'quantity' => $medicine->quantity + $purchaseInvoiceitem->quantity
                    ]);
                }
            }
            DB::commit();
            return redirect()->route('dashboard.purchaseInvoices.index')->with('success', __('Item updated successfully'));
        }catch(\Exception $e){
            DB::rollBack();
            // throw $e;
            return redirect()->back()->with('danger', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PurchaseInvoice $purchaseInvoice)
    {
        $this->authorize('delete', PurchaseInvoice::class);
        $purchaseInvoiceitems = PurchaseInvoiceItem::where('purchase_invoice_id', $purchaseInvoice->id)->get();
        foreach ($purchaseInvoiceitems as $purchaseInvoiceitem) {
            $medicine = MedicineSize::find($purchaseInvoiceitem->size_id);
            $medicine->update([
                'quantity' => $medicine->quantity - $purchaseInvoiceitem->quantity
            ]);
        }
        $purchaseInvoice->delete();

        return response()->json(['message' => __('Item deleted successfully.')]);
    }

    public function print(PurchaseInvoice $purchaseInvoice)
    {
        $this->authorize('print', PurchaseInvoice::class);
        $margin_top = 3;
        $pdf = PDF::loadView('dashboard.reports.purchaseInvoice',['purchaseInvoice' =>  $purchaseInvoice,'items' =>  $purchaseInvoice->medicines],[],[
            'format' => 'A4',
            'margin_left' => 3,
            'margin_right' => 3,
            'margin_top' => $margin_top,
            'margin_bottom' => 10,
        ]);
        return $pdf->stream();
    }
}
