<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\MultiPicture;
use Illuminate\Support\Carbon;
use Image;
use Auth;

class BrandController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

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

        /** Store Image */
        // $nam_gen = hexdec(uniqid());
        // $img_ext = strtolower($brand_image->getClientOriginalExtension());
        // $img_name = $nam_gen.'.'.$img_ext;
        // $up_location = 'image/brand/';
        // $last_img = $up_location.$img_name;
        // $brand_image->move($up_location,$img_name);

        /** Resize and Store Image */
        $name_gen = hexdec(uniqid()).'.'.$brand_image->getClientOriginalExtension();
        Image::make($brand_image)->resize(300,200)->save('image/brand/'.$name_gen);
        $last_img = 'image/brand/'.$name_gen;

        $brand = new Brand();
        $brand->brand_name = $request->brand_name;
        $brand->brand_image = $last_img;
        $brand->save();
        return Redirect()->back()->with('success', 'New Brand added Successfully');
    }

    public function edit($id) {
        $brand = Brand::find($id);
        return view('admin.brand.edit', compact('brand'));
    }

    public function update(Request $request, $id) {
        $validated = $request->validate([
            'brand_name' => 'required|unique:brands|min:4',
            'brand_image' => 'nullable|mimes:jpg.jpeg,png',
        ],
        [
            'brand_name.required' => 'Please Enter Brand name',
            'brand_name.min' => 'Brand name must be longer than 4 characters',
        ]
        );
        $old_image = $request->old_image;
        $brand_image = $request->file('brand_image');
        if($brand_image) {

            /** Store Image */
            // $nam_gen = hexdec(uniqid());
            // $img_ext = strtolower($brand_image->getClientOriginalExtension());
            // $img_name = $nam_gen.'.'.$img_ext;
            // $up_location = 'image/brand/';
            // $last_img = $up_location.$img_name;
            // $brand_image->move($up_location,$img_name);

            /** Resize and Store Image */
            $name_gen = hexdec(uniqid()).'.'.$brand_image->getClientOriginalExtension();
            Image::make($brand_image)->resize(300,200)->save('image/brand/'.$name_gen);
            $last_img = 'image/brand/'.$name_gen;

            $brand = Brand::find($id)->update([
                'brand_name' => $request->brand_name,
                'brand_image' => $last_img,
            ]);
            unlink($old_image);
        } else {
            $brand = Brand::find($id)->update([
                'brand_name' => $request->brand_name,
            ]);
        }
        return Redirect()->route('all.brands')->with('success', 'Brand Updated Successfully');
    }

    public function delete($id) {
        $brand = Brand::find($id);
        $old_image = $brand->brand_image;
        $brand->delete();
        return Redirect()->back()->with('success', 'Brand Deleted Successfully');
    }

    public function multiPicture() {
        $images = MultiPicture::All();
        return view('admin.multipictures.index', compact('images'));
    }

    public function storeMultiplePictures(Request $request) {
        $image = $request->file('image');
        foreach($image as $multi_img) {
            $name_gen = hexdec(uniqid()).'.'.$multi_img->getClientOriginalExtension();
            Image::make($multi_img)->resize(300,200)->save('image/multiple/'.$name_gen);
            $last_img = 'image/multiple/'.$name_gen;
    
            $multiple = new MultiPicture();
            $multiple->image = $last_img;
            $multiple->save();
        }
        return Redirect()->back()->with('success', 'New Images added Successfully');
    }

    public function logout() {
        Auth::logout();
        return Redirect()->route('login')->with('status', 'Logout Successfully');
    }
}
