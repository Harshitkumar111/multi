<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Banner;
use Image;
class BannerController extends Controller
{
    public function allbanner(){
        $banners= Banner::latest()->get();
        return view('backend.banner.banner_all',compact('banners'));
    }

    public function addbanner(){
        return view('backend.banner.banner_add');
    }

    public function StoreBanner(Request $request){
        $image=$request->file('banner_image');
        $name_gen= hexdec(uniqid()).'.'.$image->getClientOriginalExtension();  
        Image::make($image)->resize(768,450)->save('upload/banner/'.$name_gen);
        $save_url ='upload/banner/'.$name_gen;
        Banner::insert([
            'banner_title'=>$request->banner_title,
            'banner_url'=>$request->banner_url,
            'banner_image'=>$save_url,

        ]);
        $notification = array(
            'message' => 'Banner Inserted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.banner')->with($notification);

    }


    public function Editbanner($id){
        $banner= Banner::findOrFail($id);

        return view('backend.banner.banner_edit',compact('banner'));

    }


    public function updatebanner(Request $request){
        $Slider_id=$request->id;
        $old_image=$request->old_image;

        if($request->file('banner_image')){
          $image=$request->file('banner_image');
          $name_gen= hexdec(uniqid()).'.'.$image->getClientOriginalExtension();  
          Image::make($image)->resize(300,300)->save('upload/banner/'.$name_gen);
          $save_url ='upload/banner/'.$name_gen;
  
         if(file_exists($old_image)){
          unlink($old_image);
         }
  
         Banner::findOrFail($Slider_id)->update([
            'banner_title'=>$request->banner_title,
            'banner_url'=>$request->banner_url,
            'banner_image'=>$save_url,
  
          ]);
          $notification = array(
              'message' => 'Banner Update With image Successfully',
              'alert-type' => 'success'
          );
  
          return redirect()->route('all.banner')->with($notification);
        }else{
            Banner::findOrFail($Slider_id)->update([
                'banner_title'=>$request->banner_title,
                'banner_url'=>$request->banner_url,      
              ]);
          $notification = array(
              'message' => 'Banner Update With Out Successfully',
              'alert-type' => 'success'
          );
  
          return redirect()->route('all.banner')->with($notification);
        }
    }

    public function deletebanner($id){
        $slider= Banner::findOrFail($id);
        
        $img= $slider->banner_image;
      
        if(file_exists($img)){
            unlink($img);
           }
    
           Banner::findOrFail($id)->delete();
        
        $notification = array(
            'message' => 'Delete Banner Successfully',
            'alert-type' => 'success'
        );
    
        return redirect()->back()->with($notification);
    }
}
