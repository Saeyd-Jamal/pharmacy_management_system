<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Category;
use App\Models\Medicine;
use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class MedicineConrtoller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('view', Medicine::class);

        $request = request();
        if ($request->ajax()) {
            $medicines = Medicine::query();

            return DataTables::of($medicines)
                ->addIndexColumn()
                ->editColumn('status', function ($medicine) {
                    return $medicine->status == 'active' ? 'نشط' : 'أرشيف';
                })
                ->addColumn('created_by', function ($medicine) {
                    return $medicine->user->name ?? 'غير محدد';
                })
                ->addColumn('category_name', function ($medicine) {
                    return $medicine->category->name ?? $medicine->category_name;
                })
                ->addColumn('supplier_name', function ($medicine) {
                    return $medicine->supplier->name ?? $medicine->supplier_name;
                })
                ->addColumn('edit', function ($medicine) {
                    return $medicine->slug;
                })
                ->addColumn('delete', function ($medicine) {
                    return $medicine->slug;
                })
                ->make(true);
        }

        return view('dashboard.medicines.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Medicine::class);
        $medicine = new Medicine();
        $suppliers = Supplier::all();
        $categories = Category::all();

        return view('dashboard.medicines.create', compact('medicine', 'suppliers', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Medicine::class);
        $request->validate([
            'name' => 'required|string',
            'imageFile' => 'nullable|image',
            'description' => 'nullable|string',
            'status' => 'required|in:نشط,موقوف',
            'unit_price' => 'required|numeric|min:0',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'production_date' => 'required|date',
            'explry_date' => 'required|date|after:production_date',
            'supplier_id' => 'required|integer|exists:suppliers,id',
            'category_id' => 'required|integer|exists:categories,id',
        ]);

        if ($request->hasFile('imageFile')) {
            $file = $request->file('imageFile'); // upload obj
            $path = $file->store('images/medicines', [
                'disk' => 'public'
            ]);
            $request->merge(['image' => $path]);
        }

        $status = $request->status == 'نشط' ? 'active' : 'archive';
        $request->merge([
            'status' => $status,
            'created_by' => Auth::user()->id,
            'supplier_name' => Supplier::find($request->supplier_id)->name ?? 'غير محدد',
            'category_name' => Category::find($request->category_id)->name ?? 'غير محدد',
        ]);

        $medicine = Medicine::create($request->all());

        return redirect()->route('dashboard.medicines.index')->with('success', __('Category created successfully.'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Medicine $medicine)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Medicine $medicine)
    {
        $this->authorize('edit', Medicine::class);
        $suppliers = Supplier::get();
        $categories = Category::get();
        $btn_label = 'تعديل';
        $medicine->status = $medicine->status == 'active' ? 'نشط' : 'موقوف';
        

        return view('dashboard.medicines.edit', compact('medicine', 'suppliers', 'categories', 'btn_label'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Medicine $medicine)
    {
        $this->authorize('edit', Medicine::class);

        $request->validate([
            'name' => 'required|string',
            'imageFile' => 'nullable|image',
            'description' => 'nullable|string',
            'status' => 'required|in:نشط,موقوف',
            'unit_price' => 'required|numeric|min:0',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'production_date' => 'required|date',
            'explry_date' => 'required|date|after:production_date',
            'supplier_id' => 'required|integer|exists:suppliers,id',
            'category_id' => 'required|integer|exists:categories,id',
        ]);

        $old_image =   $medicine->image;
        if ($request->hasFile('imageFile')) {
            $file = $request->file('imageFile'); // upload obj
            $path = $file->store('images/medicines', [
                'disk' => 'public'
            ]);
            $request->merge(['image' => $path]);
        }

        $status = $request->status == 'نشط' ? 'active' : 'archive';
        $request->merge([
            'status' => $status,
            'supplier_name' => Supplier::find($request->supplier_id)->name ?? 'غير محدد',
            'category_name' => Category::find($request->category_id)->name ?? 'غير محدد',
        ]);

        $medicine->update($request->all());


        if ($old_image && $request->hasFile('imageFile')) {
            Storage::disk('public')->delete($old_image);
        }

        return redirect()->route('dashboard.medicines.index')->with('success', __('Medicines updated successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Medicine $medicine)
    {
        $this->authorize('delete', Medicine::class);

        $old_image =   $medicine->image;
        $medicine->delete();
        if ($old_image) {
            Storage::disk('public')->delete($old_image);
        }
        $request = request();
        if ($request->ajax()) {
            return response()->json(['message' => 'Item deleted successfully.']);
        }
        return redirect()->route('dashboard.medicines.index')->with('success', __('Item deleted successfully.'));
    }

    public function search(Request $request)
    {
        $name = $request->name;
        $category_id = $request->category_id;
        $supplier_id = $request->supplier_id;

        $medicines = Medicine::with('category', 'supplier');

        if ($name) {
            $medicines->where('name', 'like', '%' . $name . '%');
        }

        if ($category_id) {
            $medicines->where('category_id', $category_id);
        }

        if ($supplier_id) {
            $medicines->where('supplier_id', $supplier_id);
        }
        
        return response()->json($medicines->get());
    }
}
