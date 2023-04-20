@extends('admin.admin_dashboard')
@section('admin')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>


<div class="page-content"> 
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Active Vendor Details</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Active Vendor Details</li>
                </ol>
            </nav>
        </div>
      
    </div>
    <!--end breadcrumb-->
    <div class="container">
        <div class="main-body">
            <div class="row">
            
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('inactive.vendor.approve',$activevendordetails->id)}}" method="post" enctype="multipart/form-data" >
                                @csrf
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">User Name</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <input type="text" class="form-control" value="{{ $activevendordetails->username}}" />
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Vendor Name</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <input type="text" name="name" class="form-control" value="{{ $activevendordetails->name}}" />
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Vendor Shop Name</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <input type="text" name="vendor_shop_name" class="form-control" value="{{ $activevendordetails->vendor_shop_name}}" />
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Vendor Email</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <input type="email" name="email" class="form-control" value="{{ $activevendordetails->email}}" />
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Vendor Phone</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <input type="text" name="phone" class="form-control" value="{{ $activevendordetails->phone}}" />
                                </div>
                            </div>
                      
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Vendor Address</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <input type="text" class="form-control" name="address" value="{{ $activevendordetails->address}}" />
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Vendor Join</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <input type="tex" name="vendor_join" class="form-control" value="{{ $activevendordetails->vendor_join}}" />
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Vendor Info</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <textarea class="form-control" id="inputAddress2"  name="vendor_short_info" placeholder="Address" rows="3">{{ $activevendordetails->vendor_short_info }}</textarea>                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Vendor Photo</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <input type="file" class="form-control"  name="photo" id="image"/>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <h6 class="mb-0"></h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <img id="showImage" src="{{ (!empty($activevendordetails->photo)) ? url('upload/vendor_images/'.$activevendordetails->photo):url('upload/no_image.jpg') }}" alt="Vendor" style="width:100px; height: 100px;"  >
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-3"></div>
                                <div class="col-sm-9 text-secondary">
                                    <input type="submit" class="btn btn-danger px-4" value="Inactive Vendor" />
                                </div>
                            </div>
                        </form>
                        </div>
                    </div>
         
                </div>
            </div>
        </div>
    </div>
</div>

<script  type="text/javascript">
	$(document).ready(function(){
		$('#image').change(function(e){
			var reader = new FileReader();
			reader.onload = function(e){
				$('#showImage').attr('src',e.target.result);
			}
			reader.readAsDataURL(e.target.files['0']);
		});
	});

</script>



@endsection