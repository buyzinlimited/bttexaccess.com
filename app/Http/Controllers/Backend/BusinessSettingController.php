<?php

namespace App\Http\Controllers\Backend;
use App\Http\Controllers\Controller;
use App\Models\BusinessSetting;
use App\Models\TopBrarItems;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Storage;

use function App\Http\Helpers\overWriteEnv;


class BusinessSettingController extends Controller
{
    public function saveSettings()
    {
        foreach (Request::all() as $type => $value ){
            $business_settings = BusinessSetting::where('type', $type)->first();

            if ($type == 'header_logo' && Request::hasFile('header_logo')){
                $value = Request::file('header_logo')->store('settings', 'public');
            }

            if ($type == 'footer_logo' && Request::hasFile('footer_logo')) {
                $value = Request::file('footer_logo')->store('settings', 'public');
            }

            if ($type == 'fav_icon' && Request::hasFile('fav_icon')) {
                $value = Request::file('fav_icon')->store('settings', 'public');
            }

            if($business_settings != null) {
                if ($value != null){
                    if ($type == 'timezone' && gettype($value) != 'array'){
                        $value = $business_settings->value;
                    }
                    if(gettype($value) == 'array'){
                        $business_settings->value = json_encode($value);
                    }
                    else {
                        $business_settings->value = $value;
                    }
                    $business_settings->save();
                }
            } else{
                if ($value != null){
                    $business_settings = new BusinessSetting;
                    $business_settings->type = $type;
                    if(gettype($value) == 'array'){
                        $business_settings->value = json_encode($value);
                    }
                    else {
                        $business_settings->value = $value;
                    }
                    $business_settings->save();
                }
            }
        }
    }

    public function logoUpdate(){
        if (Request::hasFile('header_logo')){
            $business_settings = BusinessSetting::where('type', 'header_logo')->first();
            if ($business_settings->value != null){
                Storage::disk('public')->delete($business_settings->value);
            }
            $value = Request::file('header_logo')->store('uploads', 'public');
            $business_settings->value = '/storage/' . $value;
            $business_settings->save();
        }
        if (Request::hasFile('footer_logo')){
            $business_settings = BusinessSetting::where('type', 'footer_logo')->first();
            if ($business_settings->value != null){
                Storage::disk('public')->delete($business_settings->value);
            }
            $value = Request::file('footer_logo')->store('uploads', 'public');
            $business_settings->value ='/storage/' . $value;
            $business_settings->save();
        }

        if (Request::hasFile('fav_icon')){
            $business_settings = BusinessSetting::where('type', 'fav_icon')->first();
            if ($business_settings->value != null){
                Storage::disk('public')->delete($business_settings->value);
            }
            $value = Request::file('fav_icon')->store('uploads', 'public');
            $business_settings->value ='/storage/' . $value;
            $business_settings->save();
        }
        return redirect()->route('setting.index');
    }


    public function saveTopBarItems()
    {
        $data = Request::validate([
            'icon' => 'required',
            'text' => 'required'
        ]);
        TopBrarItems::create($data);
    }
    public function updateTopBarItem(Request $request, $id)
    {
        // $validated = $request->validate([
        //     'icon' => 'required|string',
        //     'text' => 'required|string',
        //     'sorting' => 'nullable|numeric',
        // ]);
        $data = Request::validate([
            'icon' => 'required',
            'text' => 'required',
            'sorting' => 'required'
        ]);
    
        try {
            TopBrarItems::where('id', $id)->update($data);
    
            return redirect()->back()->with('success', 'Top bar item updated');
        } catch (\Exception $e) {
            \Log::error('Top bar item update failed: '.$e->getMessage());
            return redirect()->back()->withErrors(['text' => 'Update failed. Please try again.']);
        }
    }

    public function deleteTopItem($id)
    {
        $item = TopBrarItems::findOrFail($id);
        $item->delete();
    }
}
