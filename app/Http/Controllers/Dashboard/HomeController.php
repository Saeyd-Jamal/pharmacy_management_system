<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Category;
use App\Models\Medicine;
use App\Models\Supplier;
use App\Models\SaleInvoice;
use App\Models\PurchaseInvoice;
use App\Http\Controllers\Controller;




class HomeController extends Controller
{
    public function index(){
        // $medicines = Medicine::get()->count();
        // $suppliers = Supplier::get()->count();
        // $categories = Category::get()->count();
        $totalsale = SaleInvoice::sum('total_amount');
        $sI  = SaleInvoice::get()->count();
        $totalpurchase = PurchaseInvoice::sum('total_amount');
        $pI = PurchaseInvoice:: get()->count();

        
       

       
        
      
        


        return view('dashboard.index',compact('totalsale','totalpurchase','sI','pI'));
    }

}

