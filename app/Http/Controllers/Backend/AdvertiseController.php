<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Advertise;
use Illuminate\Support\Facades\Storage;
class AdvertiseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return inertia('Dashboard/Advertise/Index', [
            'advertises' => Advertise::query()->orderBy('sort')->get()
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
        Advertise::create($data);

        return to_route('advertise.index');
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
        
        $advertise = Advertise::findOrFail($id);
        $data = $request->validate([
            'url' => 'required',
            'sort' => 'required',
            'image' => 'nullable'
        ]);
    
        if($request->hasFile('image')){
            $path = $request->file('image')->store('uploads', 'public');
            $data['image'] = '/storage/' . $path;
        }else {
            $data['image'] = $advertise->image;
        }
        $advertise->update($data);

        return to_route('advertise.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $advertise = Advertise::find($id);
        $image = $advertise->image;
        if($image) {
            $imagePath = str_replace('/storage','public',$image);
            Storage::delete($imagePath);
        }
        $advertise->delete();
    }
}
