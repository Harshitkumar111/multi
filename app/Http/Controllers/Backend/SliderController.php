<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Slider;
use Carbon\Carbon;
use Image;
class SliderController extends Controller
{
    public function allslider(){
        $Sliders= Slider::latest()->get();
        return view('backend.slider.slider_all',compact('Sliders'));
    }

    public function addslider(){
        return view('backend.slider.slider_add');
    }
    
    public function StoreSlider(Request $request){
        $image=$request->file('slider_image');
        $name_gen= hexdec(uniqid()).'.'.$image->getClientOriginalExtension();  
        Image::make($image)->resize(2376,807)->save('upload/slider/'.$name_gen);
        $save_url ='upload/slider/'.$name_gen;
        Slider::insert([
            'slider_title'=>$request->slider_title,
            'short_title'=>$request->short_title,
            'slider_image'=>$save_url,

        ]);
        $notification = array(
            'message' => 'Slider Inserted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.slider')->with($notification);

    }

    public function EditSlider($id){
        $slider= Slider::findOrFail($id);

        return view('backend.slider.slider_edit',compact('slider'));

    }

    public function updateSlider(Request $request){
        $Slider_id=$request->id;
        $old_image=$request->old_image;

        if($request->file('slider_image')){
          $image=$request->file('slider_image');
          $name_gen= hexdec(uniqid()).'.'.$image->getClientOriginalExtension();  
          Image::make($image)->resize(300,300)->save('upload/slider/'.$name_gen);
          $save_url ='upload/slider/'.$name_gen;
  
         if(file_exists($old_image)){
          unlink($old_image);
         }
  
         Slider::findOrFail($Slider_id)->update([
            'slider_title'=>$request->slider_title,
            'short_title'=>$request->short_title,
            'slider_image'=>$save_url,
  
          ]);
          $notification = array(
              'message' => 'Slider Update With image Successfully',
              'alert-type' => 'success'
          );
  
          return redirect()->route('all.slider')->with($notification);
        }else{
            Slider::findOrFail($Slider_id)->update([
                'slider_title'=>$request->slider_title,
                'short_title'=>$request->short_title,
  
          ]);
          $notification = array(
              'message' => 'Slider Update With Out Successfully',
              'alert-type' => 'success'
          );
  
          return redirect()->route('all.slider')->with($notification);
        }
    }

    public function deleteslider($id){
        $slider= Slider::findOrFail($id);
        
        $img= $slider->slider_image;
      
        if(file_exists($img)){
            unlink($img);
           }
    
           Slider::findOrFail($id)->delete();
        
        $notification = array(
            'message' => 'Delete Slider Successfully',
            'alert-type' => 'success'
        );
    
        return redirect()->back()->with($notification);
    }
}

