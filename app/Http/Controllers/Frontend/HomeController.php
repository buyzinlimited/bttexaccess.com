<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Client;
use App\Models\Advertise;
use App\Models\Slider;
use Illuminate\Http\Request;
use function App\Http\Helpers\getSetting;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $navCatsIds = json_decode(getSetting('nav_cats'));
        $navCats = [];
        if($navCatsIds !== null && count($navCatsIds) > 0){
            $navCats = Category::whereIn('id', $navCatsIds??[])->with('subCategories')->get();
        }

        $boxOneCatsIds = json_decode(getSetting('box1_cats'));
        $boxOneCats = [];
        if($boxOneCatsIds !== null && count($boxOneCatsIds) > 0){
            $boxOneCats = Category::whereIn('id', $boxOneCatsIds??[])->select('id', 'name','slug','image')->get();
        }

        $boxTwoCatsIds = json_decode(getSetting('box2_cats'));
        $boxTwoCats = [];
        if($boxTwoCatsIds !== null && count($boxTwoCatsIds) > 0){
            $boxTwoCats = Category::whereIn('id', $boxTwoCatsIds??[])->select('id', 'name','slug','image')->get();
        }

        $boxOneBrandsIds = json_decode(getSetting('box1_brands'));
        $boxOneBrands = [];
        if($boxOneBrandsIds !== null && count($boxOneBrandsIds) > 0){
            $boxOneBrands = Brand::whereIn('id', $boxOneBrandsIds??[])->select('id', 'name','slug')->get();
        }

        $boxTwoBrandsIds = json_decode(getSetting('box2_brands'));
        $boxTwoBrands = [];
        if($boxTwoBrandsIds !== null && count($boxTwoBrandsIds) > 0){
            $boxTwoBrands = Brand::whereIn('id', $boxTwoBrandsIds??[])->select('id', 'name','slug')->get();
        }

        $featuredProductIds = json_decode(getSetting('featured_products'));
        $featuredProducts = [];

        if($featuredProductIds !== null && count($featuredProductIds) > 0) {
            $featuredProducts = Product::query()->whereIn('id', $featuredProductIds)->select('id','title','slug','alttag')->with('images')->get();
        }

        $topSellingProductIds = json_decode(getSetting('top_selling_products'));
        $topSellingProducts = [];

        if($topSellingProductIds !== null && count($topSellingProductIds) > 0) {
            $topSellingProducts = Product::query()->whereIn('id', $topSellingProductIds)->select('id','title','slug','alttag')->with('images')->get();
        }


        return inertia('Frontend/Index', [
            'navCats'            =>     $navCats,
            'boxOne'             =>     getSetting('home_box_one'),
            'boxTwo'             =>     getSetting('home_box_two'),
            'boxOneCats'         =>     $boxOneCats,
            'boxTwoCats'         =>     $boxTwoCats,
            'boxOneBrands'       =>     $boxOneBrands,
            'boxTwoBrands'       =>     $boxTwoBrands,
            'featuredProducts'   =>     $featuredProducts,
            'topSellingProducts' =>     $topSellingProducts,
            'brands'             =>     Brand::query()->select('slug', 'name','image')->latest()->get(),
            'categories'         =>     Category::query()->select('slug', 'name','image')->get(),
            'advertises'        =>      Advertise::query()->orderBy('sort')->get(),
            'sliders'           =>      Slider::query()->orderBy('sort')->get(),
            'clients'            =>     Client::all(),
            'bSettings' => [
                'seo_content'    =>     getSetting('seo_content'),
            ],

        ]);
    }

    public function boxOneProducts(Request $request)
    {
        $boxOneCatsIds = json_decode(getSetting('box1_cats'));
        $products = Product::query()
            ->select('id', 'category_id','slug', 'title','brand_id','alttag')
            ->with('images')
            ->whereIn('category_id', $boxOneCatsIds??[])
            ->when($request->input("category_id"), function ($query) use ($request) {
                $query->where('category_id', $request->input('category_id'));
            })
            ->when($request->input("brand_id"), function ($query) use ($request) {
                $query->where('brand_id', $request->input('brand_id'));
            })
            ->paginate(12);
            
        return response()->json($products);
    }

    public function boxTwoProducts(Request $request)
    {
        $smallCatsIds = json_decode(getSetting('box2_cats'));
        $products = Product::query()
            ->select('id', 'category_id', 'brand_id','slug', 'title','alttag')
            ->with('images')
            ->whereIn('category_id', $smallCatsIds)
            ->when($request->input("category_id"), function ($query) use ($request) {
                $query->where('category_id', $request->input('category_id'));
            })
            ->when($request->input("brand_id"), function ($query) use ($request) {
                $query->where('brand_id', $request->input('brand_id'));
            })
            ->paginate(12);

        return response()->json($products);
    }

    public function showContactPage()
    {
        return inertia('Frontend/Contact');
    }

    public function showAboutPage()
    {
        return inertia('Frontend/About',[
            'bSettings' => [
                'about_content' => getSetting('about_content'),
            ]
        ]);
    }

    public function showCalibrationPage()
    {
        return inertia('Frontend/Calibration/Index',[
            'bSettings' => [
                'calibration_content' => getSetting('calibration_content'),
            ]
        ]);
    }
}
