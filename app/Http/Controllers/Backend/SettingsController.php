<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\TopBrarItems;
use function App\Http\Helpers\getSetting;


class SettingsController extends Controller
{
    public function index()
    {


        return inertia('Dashboard/Setting/Index', [
            'products' => Product::query()->with('images')->get(),
            'categories' => Category::query()->get(),
            'brands' => Brand::query()->get(),
            'topItems' => TopBrarItems::query()->orderBy('sorting','asc')->get(),
            'bSettings' => [
                'app_name' => getSetting('app_name'),
                'inquiry_mail' => getSetting('inquiry_mail'),
                'contact_mail' => getSetting('contact_mail'),
                'chat_script' => getSetting('chat_script'),
                'header_logo' => getSetting('header_logo'),
                'footer_logo' => getSetting('footer_logo'),
                'fav_icon' => getSetting('fav_icon'),
                'footer_text' => getSetting('footer_text'),
                'search_text' => getSetting('search_text'),
                'featured_products' => json_decode(getSetting('featured_products')),
                'top_selling_products' => json_decode(getSetting('top_selling_products')),
                'nav_cats' => json_decode(getSetting('nav_cats')),
                'box1_cats' => json_decode(getSetting('box1_cats')),
                'box2_cats' => json_decode(getSetting('box2_cats')),
                'box1_brands' => json_decode(getSetting('box1_brands')),
                'box2_brands' => json_decode(getSetting('box2_brands')),
                'home_box_one' => getSetting('home_box_one'),
                'home_box_two' => getSetting('home_box_two'),

                'footer_help_number' => getSetting('footer_help_number'),
                'footer_number' => getSetting('footer_number'),
                'footer_email' => getSetting('footer_email'),
                'footer_whatsapp_number' => getSetting('footer_whatsapp_number'),
                'working_day' => getSetting('working_day'),
                'office_time' => getSetting('office_time'),
                'footer_address' => getSetting('footer_address'),
                'footer_working_text' => getSetting('footer_working_text'),
                'facebook_link' => getSetting('facebook_link'),
                'youtube_link' => getSetting('youtube_link'),
                'instagram_link' => getSetting('instagram_link'),
                'linkedin_link' => getSetting('linkedin_link'),
                'metatitle' => getSetting('metatitle'),
                'metakeyword' => getSetting('metakeyword'),
                'metadescription' => getSetting('metadescription'),
            ]
        ]);
    }
    
}
