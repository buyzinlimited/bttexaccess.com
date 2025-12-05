<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;

use App\Models\SubCategory;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Request;

class SubCategoryController extends Controller
{
    public function index()
    {
        return inertia('Dashboard/Category/SubCategory/Index', [
            'subCategories' => SubCategory::query()->with('category')->latest()->get(),
            'categories' => Category::query()->get(),
        ]);
    }

    
    public function store()
    {
        $data = Request::validate([
            'name' => 'required|unique:sub_categories|max:255',
            'image' => 'required|image',
            'category_id' => 'required|integer',
        ]);

        if(Request::hasFile('image')){
            $path ='/storage/'.Request::file('image')->store('uploads','public');
            $data['image'] = $path;
        }

        SubCategory::create($data);

        return to_route('sub-categories.index');
    }

    public function update(string $id)
    {
        Request::validate([
            'name' => 'required|max:255',
            'category_id' => 'required|integer',
        ]);

        $category = SubCategory::find($id);

        $data = Request::all();

        if(Request::hasFile('image')){
            $path = '/storage/'.Request::file('image')->store('uploads','public');
            $data['image'] = $path;
        }else {
            $data['image'] = $category->image;
        }

        $category->update($data);

        return to_route('sub-categories.index');
    }
    public function destroy(string $id)
    {
        $category = SubCategory::find($id);
        $image = $category->image;
        if($image){
            $imagePath = str_replace('/storage','public',$image);
            Storage::delete($imagePath);
        }
        $category->delete();

        return to_route('sub-categories.index');
    }
}