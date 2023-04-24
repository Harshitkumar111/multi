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
use Carbon\Carbon;
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

    public function storeProduct(Request $request){
        
        $image = $request->file('product_thambnail');
        $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
        Image::make($image)->resize(800,800)->save('upload/products/thambnail/'.$name_gen);
        $save_url = 'upload/products/thambnail/'.$name_gen;

        $product_id = Product::insertGetId([
            'brand_id' => $request->brand_id,
            'category_id' => $request->category_id,
            'subcategory_id' => $request->subcategory_id,
            'product_name' => $request->product_name,
            'product_slug' => strtolower(str_replace(' ','-',$request->product_name)),

            'product_code' => $request->product_code,
            'product_qty' => $request->product_qty,
            'product_tags' => $request->product_tags,
            'product_size' => $request->product_size,
            'product_color' => $request->product_color,

            'selling_price' => $request->selling_price,
            'discount_price' => $request->discount_price,
            'short_descp' => $request->short_descp,
            'long_descp' => $request->long_descp, 

            'hot_deals' => $request->hot_deals,
            'featured' => $request->featured,
            'special_offer' => $request->special_offer,
            'special_deals' => $request->special_deals, 

            'product_thambnail' => $save_url,
            'vendor_id' => $request->vendor_id,
            'status' => 1,
            'created_at' => Carbon::now(), 

        ]);

        $images = $request->file('multi_image');
        foreach($images as $img){
        $make_name = hexdec(uniqid()).'.'.$img->getClientOriginalExtension();
        Image::make($img)->resize(800,800)->save('upload/products/multi-image/'.$make_name);
        $uploadPath = 'upload/products/multi-image/'.$make_name;
        MultiImage::insert([

            'product_id' => $product_id,
            'photo_name' => $uploadPath,
            'created_at' => Carbon::now(), 
    
        ]); 
       }
  
        $notification = array(
            'message' => 'Product Inserted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.product')->with($notification); 
    }    

    public function Editproduct($id){
        $product= Product::findOrFail($id);
        $category= Category::latest()->get();
        $subcategory= subcategory::latest()->get();
        $brand= Brand::latest()->get();
        $activevendor=User::where('status','active')->where('role','vendor')->latest()->get();
        return view('backend.product.product_edit',compact('category','brand','subcategory','activevendor','product'));
    }

    public function updateproduct(Request $request){
        $product_id = $request->id;

        
         Product::findOrFail($product_id)->update([
            'brand_id' => $request->brand_id,
            'category_id' => $request->category_id,
            'subcategory_id' => $request->subcategory_id,
            'product_name' => $request->product_name,
            'product_slug' => strtolower(str_replace(' ','-',$request->product_name)),

            'product_code' => $request->product_code,
            'product_qty' => $request->product_qty,
            'product_tags' => $request->product_tags,
            'product_size' => $request->product_size,
            'product_color' => $request->product_color,

            'selling_price' => $request->selling_price,
            'discount_price' => $request->discount_price,
            'short_descp' => $request->short_descp,
            'long_descp' => $request->long_descp, 

            'hot_deals' => $request->hot_deals,
            'featured' => $request->featured,
            'special_offer' => $request->special_offer,
            'special_deals' => $request->special_deals, 

            // 'product_thambnail' => $save_url,
            'vendor_id' => $request->vendor_id,
            'status' => 1,
            'updated_at' => Carbon::now(), 

        ]);
        $notification = array(
            'message' => 'Product Updated Without Images Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.product')->with($notification); 
        
    }
    public function updateproductthambnail(Request $request){
        $prod_id=$request->id;
        $oldImage = Product::find($prod_id)->product_thambnail;
        $image = $request->file('product_thambnail');
        $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
        Image::make($image)->resize(800,800)->save('upload/products/thambnail/'.$name_gen);
        $save_url = 'upload/products/thambnail/'.$name_gen;
        if(file_exists($oldImage)){
            unlink($oldImage);
        }
        Product::findOrFail($prod_id)->update([
            'product_thambnail' => $save_url,
            'updated_at' => Carbon::now(), 
        ]);
        $notification = array(
            'message' => 'Product Image Thanbnmail Updated  Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification); 
    }
} 

  

  

