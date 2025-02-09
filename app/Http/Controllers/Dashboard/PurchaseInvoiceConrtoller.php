<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Medicine;
use App\Models\PurchaseInvoice;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

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

            return DataTables::of($purchaseInvoices)
                ->addIndexColumn()
                ->editColumn('status', function ($purchaseInvoice) {
                    return $purchaseInvoice->status == 'active' ? 'نشط' : 'أرشيف';
                })
                ->addColumn('created_by', function ($purchaseInvoice) {
                    return $purchaseInvoice->user->name ?? 'غير محدد';
                })
                ->addColumn('edit', function ($purchaseInvoice) {
                    return $purchaseInvoice->slug;
                })
                ->addColumn('delete', function ($purchaseInvoice) {
                    return $purchaseInvoice->slug;
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
        $medicines = Medicine::all();

        $purchaseInvoice->id = PurchaseInvoice::orderBy('id', 'desc')->first() ? PurchaseInvoice::orderBy('id', 'desc')->first()->id + 1 : 1;
        $purchaseInvoice->date = date('Y-m-d');
        $purchaseInvoice->items = [];

        return view('dashboard.purchaseInvoices.create', compact('purchaseInvoice', 'suppliers', 'categories','medicines'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(PurchaseInvoice $purchaseInvoice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PurchaseInvoice $purchaseInvoice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PurchaseInvoice $purchaseInvoice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PurchaseInvoice $purchaseInvoice)
    {
        //
    }
}
