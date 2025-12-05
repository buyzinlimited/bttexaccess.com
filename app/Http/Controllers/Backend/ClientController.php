<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Request;

class ClientController extends Controller
{
    public function index()
    {
        return inertia('Dashboard/Client/Index', [
            'clients' => Client::all(),
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
    public function store()
    {
        Request::validate([
            'name' => 'required',
            'image' => 'required'
        ]);
        $data = Request::all();
        if(Request::hasFile('image')){
            $path ='/storage/'. Request::file('image')->store('uploads','public');
            $data ['image'] = $path;
        }
        Client::create($data);
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



        $client = Client::find($id);

        $data = Request::all();
        if(Request::hasFile('image')){
            $path = '/storage/'. Request::file('image')->store('uploads','public');
            $data['image'] = $path;
        }

        $client->update($data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $client = client::find($id);
        $image = $client->image;
        if($image){
            $imagePath = str_replace('/storage','public',$image);
            Storage::delete($imagePath);
        }
        $client->delete();
    }
}
