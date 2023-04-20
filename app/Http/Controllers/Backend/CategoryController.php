<?php

namespace App\Http\Controllers\Backend;
use Image;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
class CategoryController extends Controller
{
    public function allcategory(){
        $category= Category::latest()->get();
        return view('backend.category.category_all',compact('category'));
    }
    public function addcategory(){
        return view('backend.category.category_add');
    }
    public function StoreCategory(Request $request){
        $image=$request->file('category_image');
        $name_gen= hexdec(uniqid()).'.'.$image->getClientOriginalExtension();  
        Image::make($image)->resize(120,120)->save('upload/category/'.$name_gen);
        $save_url ='upload/category/'.$name_gen;
        Category::insert([
            'category_name'=>$request->category_name,
            'category_slug'=>strtolower(str_replace(' ','-',$request->category_name)),
            'category_image'=>$save_url,

        ]);
        $notification = array(
            'message' => 'Category Inserted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.category')->with($notification);

    }
    public function Editcategory($id){
        $category= Category::findOrFail($id);

        return view('backend.category.category_edit',compact('category'));

    }
    public function updatecategory(Request $request){
        $brand_id=$request->id;
        $old_image=$request->old_image;
        if($request->file('category_image')){
          $image=$request->file('category_image');
          $name_gen= hexdec(uniqid()).'.'.$image->getClientOriginalExtension();  
          Image::make($image)->resize(300,300)->save('upload/category/'.$name_gen);
          $save_url ='upload/category/'.$name_gen;
  
         if(file_exists($old_image)){
          unlink($old_image);
         }
  
         Category::findOrFail($brand_id)->update([
            'category_name'=>$request->category_name,
            'category_slug'=>strtolower(str_replace(' ','-',$request->category_name)),
            'category_image'=>$save_url,
  
          ]);
          $notification = array(
              'message' => 'category Update With image Successfully',
              'alert-type' => 'success'
          );
  
          return redirect()->route('all.category')->with($notification);
        }else{
            Category::findOrFail($brand_id)->update([
            'category_name'=>$request->category_name,
            'category_slug'=>strtolower(str_replace(' ','-',$request->category_name)),
  
          ]);
          $notification = array(
              'message' => 'category Update With Out Successfully',
              'alert-type' => 'success'
          );
  
          return redirect()->route('all.category')->with($notification);
        }
    }
    public function deletecategory($id){
        $category= Category::findOrFail($id);
        
        $img= $category->category_image;
      


        if(file_exists($img)){
            unlink($img);
           }
    
        Category::findOrFail($id)->delete();
        
        $notification = array(
            'message' => 'Delete Category Successfully',
            'alert-type' => 'success'
        );
    
        return redirect()->back()->with($notification);
    }
}
