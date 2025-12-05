<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Request;
class CategoryController extends Controller
{
    public function index()
    {
        return inertia('Dashboard/Category/Index', [
            'categories' => Category::query()->get(),
        ]);
    }

    
    public function store()
    {
        Request::validate([
            'name' => 'required|unique:categories|max:255',
            'image' => 'required|image',
        ]);
        $data = Request::all();
        if(Request::hasFile('image')){
            $path ='/storage/'.Request::file('image')->store('uploads','public');
            $data['image'] = $path;
        }

        Category::create($data);
    }

    public function update(string $id)
    {
        Request::validate([
            'name' => 'required',
        ]);

        $category = Category::find($id);

        $data = Request::all();

        if(Request::hasFile('image')){
            $path = '/storage/'.Request::file('image')->store('uploads','public');
            $data['image'] = $path;
        }

        if(Request::hasFile('banner')){
            $path = '/storage/'.Request::file('banner')->store('uploads','public');
            $data['banner'] = $path;
        }

        $category->update($data);
    }
    public function destroy(string $id)
    {
        $category = Category::find($id);
        $image = $category->image;
        if($image){
            $imagePath = str_replace('/storage','public',$image);
            Storage::delete($imagePath);
        }
        $category->delete();
    }
}
