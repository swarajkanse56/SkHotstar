<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{


public function create()
{
    return view('admin.category_form');
}


  public function getSubcategories($categoryId)
{
    $subcategories = \App\Models\Subcategory::where('category_id', $categoryId)->get();
    return response()->json($subcategories);
}


    public function index()
{
    $categories = Category::all();
    return view('admin.category_list', compact('categories'));
}

 public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
    ]);

    $imagePath = null;

    if ($request->hasFile('image')) {
        $file = $request->file('image');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('uploads'), $filename);
        $imagePath = 'uploads/' . $filename;
    }

    Category::create([
        'name'  => $request->name,
        'image' => $imagePath,
    ]);

    return redirect()->route('category.index')->with('success', 'Subcategory added successfully!');
}

public function edit($id)
{
    $category = Category::findOrFail($id);
    return view('admin.categoryedit', compact('category'));
}
public function update(Request $request, $id)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $category = Category::findOrFail($id);
    $category->name = $request->name;

    if ($request->hasFile('image')) {
        // Delete old image if exists
        if ($category->image && file_exists(public_path($category->image))) {
            unlink(public_path($category->image));
        }

        $file = $request->file('image');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('uploads'), $filename);
        $category->image = 'uploads/' . $filename;
    }

    $category->save();

    return redirect()->route('category.index')->with('success', 'Category updated successfully!');
}



public function destroy($id)
{
    $category = Category::findOrFail($id);
    $category->delete();

    return redirect()->route('category.index')->with('success', 'Category deleted successfully!');
}




}
