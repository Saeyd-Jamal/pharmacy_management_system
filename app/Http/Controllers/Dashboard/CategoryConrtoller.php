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
        $categories = new Category();
        return view('dashboard.categories.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'image' => 'required',
            'description' => 'required',
           
        ]);
        $request->merge([
            'slug' => Str::slug($request->post('name')),
        ]);

        $data = $request->except('image');
        if ($request->hasFile('image')) {
            $file = $request->file('image'); // upload obj
            $path = $file->store('uploads', [
                'disk' => 'public'
            ]);
            $data['image'] = $path;
        }

        Category::create($data);
        return redirect()->route('dashboard.categories.index')->with('success', __('Item updated successfully.'));
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
        $this->authorize('edit', Category::class);
        $categories = Category::findOrFail($id);
        return view('dashboard.categories.edit', compact('categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->authorize('edit', Category::class);

        $request->validate([
            'name' => 'required',
            'image' => 'required',
            'description' => 'required',
            
        ]);

        $categories = Category::findOrFail($id);

        $old_image =  $categories->image;
        $data = $request->except('image');

        if ($request->hasFile('image')) {

            $file = $request->file('image');
            $path = $file->store('uploads', [
                'disk' => 'public'
            ]);
            $data['image'] = $path;
        }


        $categories->update($data);


        if ($old_image && isset($data['image'])) {
            Storage::disk('public')->delete($old_image);
        }


        return redirect()->route('dashboard.categories.index')->with('success', __('Item added successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->authorize('delete', Category::class);
        $categories = Category::findOrFail($id);
        $categories->delete();
        return redirect()->route('dashboard.categories.index')->with('success', __('Item deleted successfully.'));
    }
}
