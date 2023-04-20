<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
class AdminController extends Controller
{
    public function AdminDashboard(){
        return view('admin.index');
    }
    public function AdminDestroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/admin/login');
    }
    public function AdminLoging(){
        return view('admin.admin_login');
    }
    public function AdminProfile(){
        $id = Auth::user()->id;
        $adminData = User::find($id);
        return view('admin.admin_profile_view', compact('adminData'));
    }
    public function AdminProfileStore(Request $request)
    {
        $id = Auth::user()->id;
        $data = User::find($id);
        $data->name=$request->name;
        $data->email=$request->email;
        $data->phone=$request->phone;
        $data->address=$request->address;

        if ($request->file('photo')) {
            $file = $request->file('photo');
            @unlink(public_path('upload/admin_images/'.$data->photo));
            $filename = date('YmdHi').$file->getClientOriginalName();
            $file->move(public_path('upload/admin_images'),$filename);
            $data['photo'] = $filename;
        }

        $data->save();

        $notification = array(
            'message' => 'Admin Profile Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }
    public function AdminChangePassword(){
        return view('admin.admin_change_passowrd');
    }
    public function AdminUpdatepassword(Request $request){
            
        $request->validate([
            'old_password'=>'required',
            'new_password'=>'required | confirmed',

        ]);

        if(!Hash::check($request->old_password,auth::user()->password)){
            return back()->with("error","Old Password Dose Not Match");
        }
        User::whereId(Auth::user()->id)->update([
            'password'=>Hash::make($request->password)
        ]);
        return back()->with("status"," Password Change Successfully");
    }
    public function inactivevendor(){
        $inactivevendor=User::where('status','inactive')->where('role','vendor')->latest()->get();
        return view('backend.vendor.inactive_vendor',compact('inactivevendor'));

    }
    public function activevendor(){
        $activevendor=User::where('status','active')->where('role','vendor')->latest()->get();
        return view('backend.vendor.active_vendor',compact('activevendor'));

    }
    public function inactivevendordetails($id){
        $inactivevendordetails= User::findOrFail($id);
        return view('backend.vendor.inactive_vendor_details',compact('inactivevendordetails'));

    }
    public function activevendorapprove(Request $request){
       $vender_id=$request->id;
       $user =User::findOrFail($vender_id)->update([
         'status'=>'active',
       ]);

       $notification = array(
        'message' => 'Vendor Active Successfully',
        'alert-type' => 'success'
    );

    return redirect()->route('active.vendor')->with($notification);
    }
    public function activevendordetails($id){
        $activevendordetails= User::findOrFail($id);
        return view('backend.vendor.active_vendor_details',compact('activevendordetails'));

    }
    public function inactivevendorapprove(Request $request){
        $vender_id=$request->id;
        $user =User::findOrFail($vender_id)->update([
          'status'=>'inactive',
        ]);
 
        $notification = array(
         'message' => 'Vendor Inactive Successfully',
         'alert-type' => 'success'
     );
     return redirect()->route('inactive.vendor')->with($notification);

    }
}
