<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Brand;
use Illuminate\Support\Carbon;

class BrandController extends Controller
{
    public function index() {
        $brands = Brand::latest()->paginate(5);
        return view('admin.brand.index', compact('brands'));
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'brand_name' => 'required|unique:brands|min:4',
            'brand_image' => 'required|mimes:jpg.jpeg,png',
        ],
        [
            'brand_name.required' => 'Please Enter Brand name',
            'brand_name.min' => 'Brand name must be longer than 4 characters',
        ]
        );
        $brand_image = $request->file('brand_image');
        $nam_gen = hexdec(uniqid());
        $img_ext = strtolower($brand_image->getClientOriginalExtension());
        $img_name = $nam_gen.'.'.$img_ext;
        $up_location = 'image/brand/';
        $last_img = $up_location.$img_name;
        $brand_image->move($up_location,$img_name);

        $brand = new Brand();
        $brand->brand_name = $request->brand_name;
        $brand->brand_image = $last_img;
        $brand->save();
        return Redirect()->back()->with('success', 'New Brand added Successfully');
    }
}
