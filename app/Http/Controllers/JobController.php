<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs\CategoryJob;
use Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\CategoryImport;

class JobController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function index() {
        return view('admin.job.index');
    }

    public function category(Request $request) {
        Excel::import(new CategoryImport, $request->category_upload);
        return Redirect()->back()->with('success', 'Category uploaded Successfully');
    }
}
