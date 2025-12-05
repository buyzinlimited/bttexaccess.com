<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\TopBrarItems;
use Illuminate\Http\Request;
use function App\Http\Helpers\getSetting;

class SettingController extends Controller
{
    public function getGlobalSetting()
    {

        $navCatsIds = json_decode(getSetting('nav_cats'));
        $navCats = [];
        if($navCatsIds !== null && count($navCatsIds) > 0){
            $navCats = Category::whereIn('id', $navCatsIds??[])->with('subCategories')->get();
        }

        $setting = array();
        $setting['topBarItems']= TopBrarItems::query()->select('icon','text')->orderBy('sorting','asc')->get();
        $setting['products'] = Product::query()->select('slug','title')->get();
        $setting['nav_cats'] = $navCats;
        $setting['brands'] = Brand::query()->select('slug', 'name', 'image')->get();
        $setting['app_name'] = getSetting('app_name');
        $setting['app_url'] = config('app.url');
        $setting['footer_text'] = getSetting('footer_text');
        $setting['search_text'] = getSetting('search_text');
        $setting['chat_script'] = getSetting('chat_setting');
        $setting['header_logo'] = getSetting('header_logo');
        $setting['footer_logo'] = getSetting('footer_logo');
        $setting['footer_help_number'] = getSetting('footer_help_number');
        $setting['footer_number'] = getSetting('footer_number');
        $setting['footer_email'] = getSetting('footer_email');
        $setting['footer_whatsapp_number'] = getSetting('footer_whatsapp_number');
        $setting['working_day'] = getSetting('working_day');
        $setting['office_time'] = getSetting('office_time');
        $setting['footer_address'] = getSetting('footer_address');
        $setting['footer_working_text'] = getSetting('footer_working_text');
        $setting['facebook_link'] = getSetting('facebook_link');
        $setting['youtube_link'] = getSetting('youtube_link');
        $setting['instagram_link'] = getSetting('instagram_link');
        $setting['linkedin_link'] = getSetting('linkedin_link');

        return response()->json([
            'setting' => $setting
        ]);
    }

    public function getFooterSetting()
    {
        return 'get footer setting';
    }
}


