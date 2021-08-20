<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Auth;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }
    
    public function index() {
        // $categories = DB::table('categories')
        //             ->join('users', 'categories.user_id', 'users.id')
        //             ->select('categories.*', 'users.name')
        //             ->latest()->paginate(5);
        $categories = Category::All();
        $trachCat = Category::onlyTrashed()->latest()->paginate(3);
        return view('admin.category.index', compact('categories', 'trachCat'));
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'category_name' => 'required|unique:categories|max:30',
        ],
        [
            'category_name.required' => 'Please Enter Category Name',
            'category_name.max' => 'Category must be less than 30 characters',
        ]
        );
        $category = new Category();
        $category->category_name = $request->category_name;
        $category->user_id = Auth::user()->id;
        $category->save();
        // $data = array();
        // $data['category_name'] = $request->category_name;
        // $data['user_id'] = Auth::user()->id;
        // $data['created_at'] = Carbon::now();
        // DB::table('categories')->insert($data);
        return Redirect()->back()->with('success', 'New Category added Successfully');
    }

    public function edit($id) {
        // $category = Category::find($id);
        $category = DB::table('categories')->where('id', $id)->first();
        return view('admin.category.edit', compact('category'));
    }

    public function update(Request $request, $id) {
        $category = Category::find($id)->update([
            'category_name' => $request->category_name,
            'user_id' => Auth::user()->id,
        ]);
        // $data = array();
        // $data['category_name'] = $request->category_name;
        // $data['user_id'] = Auth::user()->id;
        // DB::table('categories')->where('id', $id)->update($data);
        return Redirect()->route('all.categories')->with('success', 'Category Updated Successfully');
    }

    public function delete($id) {
        $delete = Category::find($id)->delete();
        return Redirect()->back()->with('success', 'Category Deleted Successfully');
    }

    public function restore($id) {
        $restore = Category::withTrashed()->find($id)->restore();
        return Redirect()->back()->with('success', 'Category Restored Successfully');
    }

    public function fullDelete($id) {
        $force_delete = Category::onlyTrashed()->find($id)->forceDelete();
        return Redirect()->back()->with('success', 'Category Permanently Deleted');
    }

}
