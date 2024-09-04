<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use App\Models\complement;
use Illuminate\Http\Request;

class ComplementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $complement = complement::all();
        return view('complement.index', compact('complement'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('complement.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:50',
            'category' => 'required',
            'description' => 'required',
            'price' => 'required',
            'stok' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        $complement = new complement();
        $complement->name = $request->name;
        $complement->category = $request->category;
        $complement->description = $request->description;
        $complement->price = $request->price;
        $complement->stok = $request->stok;
        if ($request->hasFile('image')) {
            $complement->image = $request->file('image')->store('complement');
        }
        $complement->save();
    
        return redirect()->route('complement.index')->with([
            'status' => 'simpan',
            'pesan' => 'data complement dengan nama "' . $request->name . '" has been created ',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(complement $complement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $complement = complement::findOrFail($id);
        return view('complement.edit', compact('complement'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|max:50',
            'category' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'stok' => 'required|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        $complement = Complement::findOrFail($id);
        $complement->name = $request->name;
        $complement->category = $request->category;
        $complement->description = $request->description;
        $complement->price = $request->price;
        $complement->stok = $request->stok;
    
        if ($request->hasFile('image')) {
            if (Storage::exists($complement->image)) {
                Storage::delete($complement->image);
            }
            $complement->image = $request->file('image')->store('complement');
        }
    
        $complement->save();
    
        return redirect()->route('complement.index')->with([
            'status' => 'update',
            'pesan' => 'Data complement dengan nama "' . $request->name . '" has been updated',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $complement = complement::findOrFail($id);
        if (Storage::exists($complement->image)) {
            Storage::delete($complement->image);
        }
        $complement->delete();
        return redirect()->route('complement.index')->with('success', 'complement berhasil dihapus.');
    }
}