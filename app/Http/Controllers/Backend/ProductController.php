<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\Category;
use App\Models\subcategory;
use App\Models\MultiImage;
use App\Models\Product;
use App\Models\User;

use Image;

class ProductController extends Controller
{
    public function allproduct(){
        $product= Product::latest()->get();
        return view('backend.product.product_all',compact('product'));
    }
    public function addproduct(){
        $category= Category::latest()->get();
        $subcategory= subcategory::latest()->get();
        $brand= Brand::latest()->get();
        $activevendor=User::where('status','active')->where('role','vendor')->latest()->get();
        return view('backend.product.product_add',compact('category','brand','subcategory','activevendor'));
    }
}
