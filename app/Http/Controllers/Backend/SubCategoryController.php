<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\SubCategory;


class SubCategoryController extends Controller
{
    public function allsubcategory(){
        $subcategory= SubCategory::latest()->get();
        return view('backend.subcategory.subcategory_all',compact('subcategory'));
    }
    public function addsubcategory(){
        $category= Category::orderBy('category_name','ASC')->get();
        return view('backend.subcategory.subcategory_add',compact('category'));
    }
    public function StoresubCategory(Request $request){
     
        SubCategory::insert([
            'category_id'=>$request->category_id,
            'subcategory_slug'=>strtolower(str_replace(' ','-',$request->subcategory_name)),
            'subcategory_name'=>$request->subcategory_name,

        ]);
        $notification = array(
            'message' => 'SubCategory Inserted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.subcategory')->with($notification);

    }
    public function Editsubcategory($id){
        $subcategory= SubCategory::findOrFail($id);
        $category= Category::orderBy('category_name','ASC')->get();
        return view('backend.subcategory.subcategory_edit',compact('subcategory','category'));

    }
    public function updatesubcategory(Request $request){
         $id=$request->id;
        SubCategory::findOrFail($id)->update([
            'category_id'=>$request->category_id,
            'subcategory_slug'=>strtolower(str_replace(' ','-',$request->subcategory_name)),
            'subcategory_name'=>$request->subcategory_name,

        ]);
        $notification = array(
            'message' => 'SubCategory Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.subcategory')->with($notification);

    }
    public function deletesubcategory($id){

    
        SubCategory::findOrFail($id)->delete();
        
        $notification = array(
            'message' => 'Delete Subcategory Successfully',
            'alert-type' => 'success'
        );
    
        return redirect()->back()->with($notification);
    }

    public function GetSubCategory($id){
        $subcat =SubCategory::where('category_id',$id)->orderBy('subcategory_id','ASC')->get();
        return json_encode($subcat);
    }
}
