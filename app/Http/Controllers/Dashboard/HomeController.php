<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Medicine;
use App\Models\Supplier;

class HomeController extends Controller
{
    public function index(){
        $medicines = Medicine::get()->count();
        $suppliers = Supplier::get()->count();
        $categories = Category::get()->count();
        return view('dashboard.index',compact('medicines','suppliers','categories'));
    }

}

