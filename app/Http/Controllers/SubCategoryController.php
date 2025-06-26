<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{
    //

      public function index()
    {
        $subcategories = Subcategory::with('category')->latest()->paginate(10);
        return view('admin.subcategory_list', compact('subcategories'));
    }

    // Show create form
    public function create()
    {
        $categories = Category::all();
        return view('admin.subcategory_form', compact(var_name: 'categories'));
    }

    // Store new subcategory
   public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'category_id' => 'required|exists:categories,id',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'status' => 'nullable|boolean',
    ]);

    $subcategory = new SubCategory();
    $subcategory->name = $request->name;
    $subcategory->category_id = $request->category_id;

    if ($request->hasFile('image')) {
        $file = $request->file('image');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('uploads'), $filename);
        $imagePath = 'uploads/' . $filename;

        // **Assign image path to subcategory**
        $subcategory->image = $imagePath;
    }

    $subcategory->save();

    return redirect()->route('subcategory.index')->with('success', 'Subcategory added successfully!');
}




 public function getSubcategories($categoryId)
{
    $subcategories = SubCategory::where('category_id', $categoryId)->get();
    return response()->json($subcategories);
}

 

 public function edit($id)
{
    $subcategory = SubCategory::findOrFail($id);
    $categories = Category::all();

    return view('admin.subcategoryedit', compact('subcategory', 'categories'));
}


public function update(Request $request, $id)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'category_id' => 'required|exists:categories,id',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'status' => 'nullable|boolean',
    ]);

    $subcategory = SubCategory::findOrFail($id);
    $subcategory->name = $request->name;
    $subcategory->category_id = $request->category_id;

    // Handle image upload if new image is provided
    if ($request->hasFile('image')) {
        // Delete old image if exists
        if ($subcategory->image && file_exists(public_path($subcategory->image))) {
            unlink(public_path($subcategory->image));
        }

        $file = $request->file('image');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('uploads'), $filename);
        $subcategory->image = 'uploads/' . $filename;
    }

    $subcategory->save();

    return redirect()->route('subcategory.index')->with('success', 'Subcategory updated successfully!');
}





public function destroy($id)
{
    $subcategory = SubCategory::findOrFail($id);
    
    // Optional: Delete the image file from storage
    if ($subcategory->image && file_exists(public_path($subcategory->image))) {
        unlink(public_path($subcategory->image));
    }

    $subcategory->delete();

    return redirect()->route('subcategory.index')->with('success', 'Subcategory deleted successfully!');
}


}
