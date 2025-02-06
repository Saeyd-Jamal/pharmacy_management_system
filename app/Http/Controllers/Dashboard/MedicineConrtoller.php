<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Category;
use App\Models\Medicine;
use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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
            $medicines = Medicine::with('user','category','supplier')->select(['id', 'name', 'image', 'description', 'status', 'price','unit_price','stock_quantity','explry_date','created_by','supplier_id','category_id',]);

            return DataTables::of($medicines)
                ->addIndexColumn()
                ->editColumn('status', function ($medicine) {
                    return $medicine->status == 'active' ? 'active' : 'archive';
                })
                ->addColumn('created_by', function ($medicine) {
                    return $medicine->user->name ?? 'غير محدد';
                })
                ->addColumn('category_name', function ($medicine) {
                    return $medicine->category ? $medicine->category->name : 'No Category'; // إرجاع اسم الكاتيجوري
                })
                ->addColumn('supplier_name', function ($medicine) {
                    return $medicine->supplier ? $medicine->supplier->name : 'No supplier'; // إرجاع اسم الكاتيجوري
                })
                ->addColumn('action', function ($medicine) {
                    return $medicine->id;
                })
                ->addColumn('edit', function ($medicine) {
                    return $medicine->id;
                })
                ->addColumn('delete', function ($medicine) {
                    return $medicine->id;
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
        $medicines = new Medicine();
        $suppliers = Supplier::all();
        $categories = Category::all();
        
        return view('dashboard.medicines.create', compact('medicines','suppliers','categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Medicine::class);
        $request->validate([
            'name' => 'required',
            'image' => 'required|image',
            'description' => 'required',
            'status' => 'required',
            'price' => 'required',
            'unit_price'=> 'required',
            'stock_quantity' => 'required',
            'explry_date' => 'required',
            'supplier_id' => 'required|integer|exists:suppliers,id',
            'category_id' => 'required|integer|exists:categories,id',
        ]);
        // dd($request->all());
        

        $data = $request->except('image');
        if ($request->hasFile('image')) {
            $file = $request->file('image'); // upload obj
            $path = $file->store('uploads', [
                'disk' => 'public'
            ]);
            $data['image'] = $path;
        }

        $medicines = Medicine::create($data);

        return redirect()->route('dashboard.medicines.index')->with('success', __('Category created successfully.'));
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
        $this->authorize('edit', Medicine::class);
        $medicines = Medicine::findOrFail($id);
        $suppliers = Supplier::select('id', 'name')->get();
        $categories = Category::select('id', 'name')->get();
        return view('dashboard.medicines.edit', compact('medicines','suppliers','categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->authorize('edit', Medicine::class);

        $request->validate([
            'name' => 'required',
            'image' => 'nullable|image',
            'description' => 'required',
            'status' => 'required',
            'price' => 'required',
            'unit_price'=> 'required',
            'stock_quantity' => 'required',
            'explry_date' => 'required',
            'supplier_id' => 'required|integer|exists:suppliers,id',
            'category_id' => 'required|integer|exists:categories,id',
        ]);

        $medicines = Medicine::findOrFail($id);

        $old_image =   $medicines->image; 
    $data = $request->except('image'); 

    if ($request->hasFile('image')) {
      
        $file = $request->file('image');
        $path = $file->store('uploads', [
            'disk' => 'public'
        ]);
        $data['image'] = $path; 
    }

   
    $medicines->update($data);

   
    if ($old_image && isset($data['image'])) {
        Storage::disk('public')->delete($old_image);
    }

    return redirect()->route('dashboard.medicines.index')->with('success', __('Medicines updated successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->authorize('delete', Medicine::class);
        $medicines = Medicine::findOrFail($id);
        $medicines->delete();
        $request = request();
        if($request->ajax()){
            return response()->json(['message' => 'Item deleted successfully.']);
        }
        return redirect()->route('dashboard.medicines.index')->with('success', __('Item deleted successfully.'));
    }
}
