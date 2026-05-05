<?php

namespace App\Http\Controllers;

use App\Models\category;
use App\Models\teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class categorymangeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $categories=category::all();
        return view('admin.categories',compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $allteacher=teacher::all();
        return view('admin.addcategory',compact('allteacher'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $data = $request->validate([
            'category' => 'required|string|max:255',
            'category_cover' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);


        $file=$request->file('category_cover');

        $filename=time() . '.' . $file->getClientOriginalExtension();

        $file->move(public_path('cover'),$filename);

        $data['category_cover'] = $filename;

        category::create($data);

        return redirect()->route('admin.category.index')->with('msg', 'added successfully')->with('type','success');
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
          $cat = category::findOrFail($id);
            $cat->update([
                'category' => $request->category
            ]);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $categories=category::findOrFail($id);

        $img_path=public_path('cover/'.$categories->category_cover);

        if ($categories->category_cover !=='no-img.png') {
              File::delete($img_path);
        }

        $categories->delete();

        return back()->with('msg','deleted successfully')->with('type','success');
    }


    public function updateImage(Request $request, $id)
    {
        $cat = category::findOrFail($id);

        $file = $request->file('category_cover');
        $name = uniqid().'.'.$file->extension();
        $file->move(public_path('cover'), $name);

        $cat->update([
            'category_cover' => $name
        ]);

        return response()->json(['name' => $name]);
    }
}
