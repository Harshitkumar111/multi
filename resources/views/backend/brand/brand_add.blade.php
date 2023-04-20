@extends('admin.admin_dashboard')
@section('admin')
    

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>


<div class="page-content"> 
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Add Brand</li>
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
                            <form action="{{ route('brand.store')}}" method="post" id="myForm" enctype="multipart/form-data" >
                                @csrf
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Brand Name</h6>
                                </div>
                                <div class="col-sm-9 text-secondary form-group">
                                    <input type="text" class="form-control"   name="brand_name"/>
                                </div>
                            </div>
                           
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Brand Photo</h6>
                                </div>
                                <div class="col-sm-9 text-secondary form-group">
                                    <input type="file" class="form-control"  name="brand_image" id="image"/>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <h6 class="mb-0"></h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <img id="showImage" src="{{ url('upload/no_image.jpg') }}" alt="Brand" style="width:100px; height: 100px;"  >
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-3"></div>
                                <div class="col-sm-9 text-secondary">
                                    <input type="submit" class="btn btn-primary px-4" value="Save Changes" />
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
<script type="text/javascript">
    $(document).ready(function (){
        $('#myForm').validate({
            rules: {
                brand_name: {
                    required : true,
                }, 
                brand_image: {
                    required : true,
                },
            },
            messages :{
                brand_name: {
                    required : 'Please Enter Brand Name',
                },
                brand_image: {
                    required : 'Please Enter Brand Image',
                },
            },
            errorElement : 'span', 
            errorPlacement: function (error,element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight : function(element, errorClass, validClass){
                $(element).addClass('is-invalid');
            },
            unhighlight : function(element, errorClass, validClass){
                $(element).removeClass('is-invalid');
            },
        });
    });
    
</script>
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