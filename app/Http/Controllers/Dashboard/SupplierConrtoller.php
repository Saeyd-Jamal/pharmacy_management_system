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
            'name' => 'required',
            'email' => 'required',
            'phone_number' => 'required',
            'address' => 'required',
            'contact_person' => 'required',
            
        ]);
        Supplier::create($request->all());
        return redirect()->route('dashboard.suppliers.index')->with('success', __('Item updated successfully.'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $this->authorize('edit', Supplier::class);
        $suppliers = Supplier::findOrFail($id);
        return view('dashboard.suppliers.edit', compact('suppliers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->authorize('edit', Supplier::class);

        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'phone_number' => 'required',
            'address' => 'required',
            'contact_person' => 'required',
            
        ]);

        $suppliers = Supplier::findOrFail($id);

        $suppliers->update($request->all());

        return redirect()->route('dashboard.suppliers.index')->with('success', __('Item added successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->authorize('delete', Supplier::class);
        $suppliers = Supplier::findOrFail($id);
        $suppliers->delete();
        return redirect()->route('dashboard.suppliers.index')->with('success', __('Item deleted successfully.'));
    }
}
