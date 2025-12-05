<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Slider;
use Illuminate\Support\Facades\Storage;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return inertia('Dashboard/Slider/Index', [
            'sliders' => Slider::query()->orderBy('sort')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'url' => 'required|string',
            'sort' => 'required|integer'
        ]);

       // Handle image upload
        if($request->hasFile('image')){
            $path = $request->file('image')->store('uploads', 'public');
            $data['image'] = '/storage/' . $path;
        }
        Slider::create($data);

        return to_route('slider.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $slider = Slider::find($id);
        $image = $slider->image;
        if($image) {
            $imagePath = str_replace('/storage','public',$image);
            Storage::delete($imagePath);
        }
        $slider->delete();

        return to_route('slider.index');
    }
}
