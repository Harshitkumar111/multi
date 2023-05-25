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
use Auth;

class VendorProductController extends Controller
{
    public function VendorAllProduct(){
        $id = Auth::user()->id;
        $product= Product::where('vendor_id',$id)->latest()->get();
        return view('vendor.backend.product.vendor_product_all',compact('product'));
    }
    public function vendoraddproduct(){
        $category= Category::latest()->get();
        $subcategory= subcategory::latest()->get();

        $brand= Brand::latest()->get();
        return view('vendor.backend.product.vendor_product_add',compact('category','brand','subcategory'));
    }



    public function store(Request $request){
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
            'vendor_id' => Auth::user()->id,
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
            'message' => 'Vendor Product Inserted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('vendor.all.product')->with($notification); 
    }

    public function vendoreditproduct($id){
        $multiImages= MultiImage::where('product_id',$id)->get();
        $product= Product::findOrFail($id);
        $category= Category::latest()->get();
        $subcategory= subcategory::latest()->get();
        $brand= Brand::latest()->get();
        return view('vendor.backend.product.vendor_product_edit',compact('category','brand','subcategory','product','multiImages'));
    }

    public function vendorupdateproduct(Request $request){
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
            // 'vendor_id' => $request->vendor_id,
            'status' => 1,
            'updated_at' => Carbon::now(), 

        ]);
        $notification = array(
            'message' => 'Vendor Product Updated Without Images Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('vendor.all.product')->with($notification); 
        
    }

    public function vendorupdateproductthambnail(Request $request){
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
            'message' => 'Vendor Product Image Thanbnmail Updated  Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification); 
    }
    public function vendorupdateproductmultiImage(Request $request){

        $image = $request->multi_img;

        foreach($image as $id => $imgs){
              $imgDel = MultiImage::findOrFail($id);

              if(file_exists($imgDel)){
                unlink($imgDel->photo_name);
               }
               $make_name = hexdec(uniqid()).'.'.$imgs->getClientOriginalExtension();
               Image::make($imgs)->resize(800,800)->save('upload/products/multi-image/'.$make_name);
               $uploadPath = 'upload/products/multi-image/'.$make_name;
               MultiImage::where('id',$id)->update([
                'photo_name'=>$uploadPath,
                'updated_at'=>Carbon::now(),

               ]);            
        }
        $notification = array(
            'message' => 'Vendor Product Multi Image Updated  Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification); 

    }

    public function  vendorMultiImageDelete($id){
        $old_image= MultiImage::findOrFail($id);
        if(file_exists($old_image)){
            unlink($old_image->photo_name);
           }
        MultiImage::findOrFail($id)->delete();
        $notification = array(
            'message' => 'Vendor Product Multi Image Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification); 
        
     }
     public function  vendorproductinactive($id){
        Product::findOrFail($id)->update(['status'=>0]);
         $notification = array(
             'message' => 'Vendor Product Inactive',
             'alert-type' => 'success'
         );
 
         return redirect()->back()->with($notification); 
         
      }
 
      public function  vendorproductactive($id){
         Product::findOrFail($id)->update(['status'=>1]);
          $notification = array(
              'message' => 'Vendor Product Active',
              'alert-type' => 'success'
          );
  
          return redirect()->back()->with($notification); 
          
       }
 
       public function  vendordeleteproduct($id){
        $product = Product::findOrFail($id);

        if(file_exists($product->product_thambnail)){
            unlink($product->product_thambnail);
           }
        Product::findOrFail($id)->delete($id);
         $image = MultiImage::where('product_id',$id)->get();
        foreach ($image as  $value) {
            if(file_exists($value->photo_name)){
                unlink($value->photo_name);
               }
            MultiImage::where('product_id',$id)->delete();
            
        }
        $notification = array(
            'message' => 'Vendor Product Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification); 

       }

}
