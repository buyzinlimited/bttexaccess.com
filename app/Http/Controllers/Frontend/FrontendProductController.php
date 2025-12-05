<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use App\Models\Product;
use function App\Http\Helpers\getSetting;

class FrontendProductController extends Controller
{

    public function searchProduct(Request $request)
    {
        $data = Product::query()
            ->select('id', 'title', 'slug', 'short_description')
            ->with('images')
            ->when($request->input('query'), function ($query) use ($request) {
                $searchTerm = '%' . $request->input('query') . '%';
                $query->where(function ($subQuery) use ($searchTerm) {
                    $subQuery->where('title', 'like', $searchTerm)
                        ->orWhere('short_description', 'like', $searchTerm)
                        ->orWhere('description', 'like', $searchTerm);
                });
            })
            ->get();

        return response()->json($data);
    }
    public function allProducts(Request $request)
    {
        $products = Product::query()
            ->with('images')
            ->when($request->input('name'), function ($query) use ($request) {
                $query->where('title', 'like', '%' . $request->input('name') . '%')
                    ->orderBy('title');
            })
            ->when($request->input("category"), function ($query) use ($request) {
                $query->whereHas('category', function ($query) use ($request) {
                    $query->where('slug', $request->input('category'));
                });
            })
            ->when($request->input("sub_category"), function ($query) use ($request) {
                $query->whereHas('subCategory', function ($query) use ($request) {
                    $query->where('slug', $request->input('sub_category'));
                });
            })

            ->paginate(40);

        return inertia('Frontend/Products', [
            'categories' => Category::query()->with('subCategories')->get(),
            'products' => $products,
        ]);
    }


    public function getTitle()
    {
        $products = Product::query()->select('title', 'slug')->get();
        return response()->json($products);
    }

    public function getBrands()
    {
        $brands = Brand::query()->select('slug', 'name', 'image')->get();
        return response()->json($brands);
    }

    public function getCategories()
    {
        $navCatsIds = json_decode(getSetting('nav_cats'));
        $navCats = [];
        if ($navCatsIds !== null && count($navCatsIds) > 0) {
            $navCats = Category::whereIn('id', $navCatsIds ?? [])->with('subCategories')->get();
        }

        return response()->json($navCats);
    }

    public function productDetail($slug)
    {
        $product = Product::where('slug', $slug)
            ->withCount('reviews')
            ->withSum('reviews', 'rating')
            ->first();

        $relatedProducts  = Product::query()->where('category_id', $product->category_id)->whereNot('slug', $slug)->with('images')->get();

        $totalReviews = $product->reviews_count;
        $totalRatings = $product->reviews_sum_rating;
        $averageRating = $totalReviews > 0 ? $totalRatings / $totalReviews : 0;

        return inertia('Frontend/ProductDetail', [
            'product' => Product::where('slug', $slug)->with('images', 'category', 'brand', 'questions', 'questions.user', 'reviews', 'reviews.user')->first(),
            'ProductAverageRating' => $averageRating,
            'relatedProducts' => $relatedProducts,
        ]);
    }

    public function categoryProduct($slug)
    {

        $category = Category::query()->where('slug', $slug)->firstOrFail();
        $products = $category->products()->with(['images', 'category', 'brand'])->paginate(40);
        return inertia('Frontend/CategoryProduct/Index', [
            'categories' => Category::query()->with('subCategories')->get(),
            'category' => $category,
            'products' => $products
        ]);
    }

    public function subCategoryProduct($mainCats, $slug)
    {
        $category = SubCategory::query()->where('slug', $slug)->firstOrFail();
        $products = $category->products()->with(['images'])->paginate(40);
        return inertia('Frontend/SubCategoryProduct/Index', [
            'categories' => Category::query()->with('subCategories')->get(),
            'category' => $category,
            'products' => $products
        ]);
    }

    public function brandProduct($slug)
    {
        $brand = Brand::query()->where('slug', $slug)->firstOrFail();
        $products = $brand->products()->with(['images',])->paginate(40);
        return inertia('Frontend/BrandProduct/Index', [
            'brands' => Brand::query()->get(),
            'brand' => $brand,
            'products' => $products
        ]);
    }
}
