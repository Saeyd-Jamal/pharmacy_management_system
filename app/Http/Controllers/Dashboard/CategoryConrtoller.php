<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class CategoryConrtoller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('view', Category::class);
        $categories = Category::all();
        return view('dashboard.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Category::class);
        $category = new Category();
        return view('dashboard.categories.create', compact('category'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'imageFile' => 'nullable|file',
            'description' => 'nullable|string',
        ]);
        if ($request->hasFile('imageFile')) {
            $file = $request->file('imageFile'); // upload obj
            $path = $file->store('categories', [
                'disk' => 'public'
            ]);
            $request->merge(['image' => $path]);
        }

        Category::create($request->all());
        return redirect()->route('dashboard.categories.index')->with('success', __('Item updated successfully.'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        $this->authorize('edit', Category::class);
        $btn_label = "تعديل";
        return view('dashboard.categories.edit', compact('category', 'btn_label'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $this->authorize('edit', Category::class);

        $request->validate([
            'name' => 'required|string',
            'image' => 'nullable|file',
            'description' => 'nullable|string',
        ]);
        
        $old_image =  $category->image;

        if ($request->hasFile('imageFile')) {
            $file = $request->file('imageFile');
            $path = $file->store('uploads', [
                'disk' => 'public'
            ]);
            $request->merge(['image' => $path]);
        }

        $category->update($request->all());

        if ($old_image && $request->hasFile('imageFile')) {
            Storage::disk('public')->delete($old_image);
        }
        return redirect()->route('dashboard.categories.index')->with('success', __('Item added successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $this->authorize('delete', Category::class);
        $img_old = $category->image;
        $category->delete();
        if ($img_old) {
            Storage::disk('public')->delete($img_old);
        }
        $request = request();
        if($request->ajax()){
            return response()->json(['message' => __('Item deleted successfully.')]);
        }
        return redirect()->route('dashboard.categories.index')->with('success', __('Item deleted successfully.'));
    }
}
