<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SupplierConrtoller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('view', Supplier::class);

        $suppliers = Supplier::all();
        return view('dashboard.suppliers.index', compact('suppliers'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Supplier::class);
        $suppliers = new Supplier();
        return view('dashboard.suppliers.create', compact('suppliers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'nullable|email',
            'phone_number' => 'nullable|integer',
            'address' => 'nullable|string',
            'contact_person' => 'nullable|string',
        ]);
        Supplier::create($request->all());
        return redirect()->route('dashboard.suppliers.index')->with('success', __('Item updated successfully'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Supplier $supplier)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Supplier $supplier)
    {
        $this->authorize('edit', Supplier::class);
        $btn_label = "تعديل";
        return view('dashboard.suppliers.edit', compact('supplier', 'btn_label'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Supplier $supplier)
    {
        $this->authorize('edit', Supplier::class);
        $request->validate([
            'name' => 'required|string',
            'email' => 'nullable|email',
            'phone_number' => 'nullable|integer',
            'address' => 'nullable|string',
            'contact_person' => 'nullable|string',
        ]);
        $supplier->update($request->all());
        return redirect()->route('dashboard.suppliers.index')->with('success', __('Item added successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Supplier $supplier)
    {
        $this->authorize('delete', Supplier::class);
        $supplier->delete();

        $request = request();
        if($request->ajax()){
            return response()->json(['message' => __('Item deleted successfully.')]);
        }
        return redirect()->route('dashboard.suppliers.index')->with('success', __('Item deleted successfully.'));
    }
}
