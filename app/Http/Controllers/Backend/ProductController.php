<?php

namespace App\Http\Controllers\Backend;

use App\Events\LatestProduct;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Category;
use App\Models\Image;
use App\Models\Product;
use App\Models\Brand;
use App\Models\SubCategory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        return inertia('Dashboard/Product/Index', [
            'products' => Product::with('category', 'brand', 'images')
            ->latest()
            ->get()
        ]);
    }
    public function addProduct()
    {
        return inertia('Dashboard/Product/Add', [
                'categories' => Category::query()->select('id', 'name','id')->with('subCategories')->get(),
                'brands' => Brand::query()->select('id', 'name')->get(),
                'sub_categories' => SubCategory::query()->select('id', 'name')->get()
            ]);
    }
    
    public function storeProduct(ProductRequest $req)
    {

        $data = $req->validated();
        $data['user_id'] = Auth::id();
        $product = Product::query()->create($data);
        
        //  save product images
        $images = $data['images'];
        $imageData = [];
        foreach( $images as $image){
            $imageData[] = [
                'url' => '/storage/'.$image['file']->store('uploads', 'public'),
                'product_id' => $product->id
            ];
        }
        Image::insert($imageData);
        // event(new LatestProduct($product));

        return to_route('product.all');
    }
    public function editProduct($slug)
    {
        return inertia('Dashboard/Product/Edit', [
            "product" => Product::where('slug', $slug)->with('category', 'images')->first(),
            "categories" => Category::query()->get(),
            "sub_categories" => SubCategory::query()->get(),
            "brands" => Brand::all(),
        ]);
    }

    public function deleteProductImage($id) {
        $image = Image::where('id', $id)->first();
        $imagePath = str_replace('/storage', 'public', $image->url);
        Storage::delete($imagePath);
        $image->delete();
    }
    public function updateProduct($slug)
{
    $product = Product::where('slug', $slug)->firstOrFail();

    $data = Request::all();
    $data['user_id'] = Auth::id();

    // If slug is provided and it's different from current, check for duplicates
    if (isset($data['slug']) && $data['slug'] !== $product->slug) {
        $exists = Product::where('slug', $data['slug'])
            ->where('id', '!=', $product->id)
            ->exists();

        if ($exists) {
            return back()->withErrors(['slug' => 'This slug is already in use.']);
        }
    } else {
        // If slug is not provided, keep the old slug
        $data['slug'] = $product->slug;
    }

    // Handle image upload
    if (!empty($data['newImage'])) {
        $images = $data['newImage'];
        $imageData = [];
        foreach ($images as $image) {
            $imageData[] = [
                'url' => '/storage/' . $image['file']->store('uploads', 'public'),
                'product_id' => $product->id
            ];
        }
        Image::insert($imageData);
    }

    $product->update($data);
    return to_route('product.all');
}

    public function deleteProduct($id){
        $product = Product::where('id', $id)->first();
        if ($product) {
            $images = $product->images;
            foreach ($images as $image) {
                $imagePath = str_replace('/storage', 'public', $image->url);
                Storage::delete($imagePath);
                $image->delete();
            }
            $product->delete();
        }
    }
}
