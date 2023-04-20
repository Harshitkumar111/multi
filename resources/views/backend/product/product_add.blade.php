@extends('admin.admin_dashboard')
@section('admin')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<div class="page-content">

    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">eCommerce</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Add New Product</li>
                </ol>
            </nav>
        </div>
   
    </div>
    <!--end breadcrumb-->

  <div class="card">
      <div class="card-body p-4">
          <h5 class="card-title">Add New Product</h5>
          <hr/>

          <form action="{{ route('category.store')}}" method="post" id="myForm" enctype="multipart/form-data" >
            @csrf

           <div class="form-body mt-4">

            <div class="row">
               <div class="col-lg-8">
               <div class="border border-1 p-4 rounded">
                <div class="mb-3 form-group">
                    <label for="inputProductTitle" class="form-label">Product Name</label>
                    <input type="text" name="product_name" class="form-control" id="inputProductTitle" placeholder="Enter product title">
                  </div>

                  <div class="mb-3 form-group">
                    <label for="inputProductTitle" class="form-label">Product Tags</label>
                    <input type="text" name="product_tag" class="form-control visually-hidden" data-role="tagsinput" value="New Product,Top Product ">
                  </div>
                  <div class="mb-3 form-group">
                    <label for="inputProductTitle" class="form-label">Product Size</label>
                    <input type="text" name="product_size" class="form-control visually-hidden" data-role="tagsinput" value="Smail, Midium,Large ">
                  </div>
                  <div class="mb-3 form-group">
                    <label for="inputProductTitle" class="form-label">Product Color</label>
                    <input type="text" name="product_color" class="form-control visually-hidden" data-role="tagsinput" value="Red,Blue,Black,White ">
                  </div>


                  <div class="mb-3 form-group">
                    <label for="inputProductDescription" class="form-label">Short Description</label>
                    <textarea class="form-control" name="short_descp" id="inputProductDescription" rows="3"></textarea>
                  </div>
                  <div class="mb-3 form-group">
                    <label for="inputProductDescription" class="form-label">Long Description</label>
                    <textarea id="mytextarea" name="long_descp">Hello, World!</textarea>
                </div>

                <div class="mb-3 form-group">
                    <label for="inputProductDescription" class="form-label">Main Thambnail</label>
                    <input class="form-control" name="product_thambnail" type="file" id="formFile" onChange="mailThumUrl(this)">
                     <img src="" alt="" id="mailThumb">

                  </div>

                  <div class="mb-3 form-group">
                    <label for="inputProductDescription" class="form-label">Multiple Thambnail</label>
                    <input class="form-control" type="file" id="multiImage" multiple="" name="multi_image[]" > 
                    <div class="row" id="preview_img">

                    </div>
                </div>
       
              
                </div>
               </div>
               <div class="col-lg-4">
                <div class="border border-1 p-4 rounded">
                  <div class="row g-3">
                    <div class="col-md-6 form-group">
                        <label for="inputPrice" class="form-label">Product Price</label>
                        <input type="text" name="selling_price"  class="form-control" id="inputPrice" placeholder="00.00">
                      </div>
                      <div class="col-md-6 form-group">
                        <label for="inputPrice" class="form-label">Discount Price</label>
                        <input type="text" name="discount_price"  class="form-control" id="inputPrice" placeholder="00%">
                      </div>
                      <div class="col-md-6 form-group">
                        <label for="inputCompareatprice" class="form-label">Product Code</label>
                        <input type="text" name="product_code" class="form-control" id="inputCompareatprice" placeholder="00">
                      </div>
                      <div class="col-md-6 form-group">
                        <label for="inputCompareatprice" class="form-label">Product-Quantity</label>
                        <input type="text" name="product_qty" class="form-control" id="inputCompareatprice" placeholder="00">
                      </div>
                  
                     
                      <div class="col-12 form-group">
                        <label for="inputProductType" class="form-label">Product Brand</label>
                        <select  name="brand_id" class="form-select" id="inputProductType">
                            <option></option>
                            @foreach ($brand as $item)
                               <option value="{{ $item->id}}">{{ $item->brand_name}}</option>

                            @endforeach
                            {{-- <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option> --}}
                          </select>
                      </div>
                      <div class="col-12 form-group">
                        <label for="inputVendor" class="form-label">Product Category</label>
                        <select name="category_id" class="form-select" id="inputVendor">
                            <option></option>
                            @foreach ($category as $item)
                            <option value="{{ $item->id}}">{{ $item->category_name}}</option>

                         @endforeach
                          </select>
                      </div>
                      <div class="col-12 form-group">
                        <label for="inputCollection" class="form-label">Product Subcategory</label>
                        <select  name="subcategory_id" class="form-select" id="inputCollection">
                            <option></option>
                            
                            @foreach ($subcategory as $item)
                               <option value="{{ $item->id}}">{{ $item->subcategory_name}}</option>

                           @endforeach
                          </select>
                      </div>
                      <div class="col-12 form-group">
                        <label for="inputCollection" class="form-label"> Select_vandor</label>
                        <select  name="vendor_id" class="form-select" id="inputCollection">
                            <option></option>
                            @foreach ($activevendor as $item)
                            <option value="{{ $item->id}}">{{ $item->name}}</option>

                         @endforeach
                          </select>
                      </div>

                    <div class="row g-3">
                      <div class="col-md-6">
                     
                        <div class="form-check">
                            <input class="form-check-input" name="hot_deals" type="checkbox" value="1" id="flexCheckDefault">
                            <label class="form-check-label" for="flexCheckDefault">Hot Deals</label>
                        </div>
                    
                      </div>
                        <div class="col-md-6">
                       
                          <div class="form-check">
                              <input class="form-check-input" name="featured" type="checkbox" value="1" id="flexCheckDefault">
                              <label class="form-check-label" for="flexCheckDefault">Featured</label>
                          </div>
                      
                      </div>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6">
                       
                          <div class="form-check">
                              <input class="form-check-input" name="special_offer" type="checkbox" value="1" id="flexCheckDefault">
                              <label class="form-check-label" for="flexCheckDefault">Special Offer</label>
                          </div>
                      
                        </div>
                          <div class="col-md-6">
                         
                            <div class="form-check">
                                <input class="form-check-input" name="special_deals" type="checkbox" value="1" id="flexCheckDefault">
                                <label class="form-check-label" for="flexCheckDefault">Special Deals</label>
                            </div>
                        
                        </div>
                      </div>
                      <hr>
                      <div class="col-12">
                          <div class="d-grid">
                             <button type="submit" class="btn btn-primary">Save Product</button>
                          </div>
                      </div>
                  </div> 
              </div>
              </div>
           </div><!--end row-->
        </div>
        </form>
      </div>
  </div>

</div>


<script type="text/javascript">
    $(document).ready(function (){
        $('#myForm').validate({
            rules: {
                product_name: {
                    required : true,
                }, 
                short_descp: {
                    required : true,
                },
                long_descp: {
                    required : true,
                },
                product_thambnail: {
                    required : true,
                },
                selling_price: {
                    required : true,
                },
                discount_price: {
                    required : true,
                },
                product_code: {
                    required : true,
                },
                brand_id: {
                    required : true,
                },
                product_qty: {
                    required : true,
                },
                category_id: {
                    required : true,
                },
                subcategory_id: {
                    required : true,
                },
                multi_image: {
                    required : true,
                },
                vendor_id: {
                    required : true,
                },
                product_color: {
                    required : true,
                },
                product_size: {
                    required : true,
                },
                product_tag: {
                    required : true,
                },
            },
            messages :{
                product_name: {
                    required : 'Please Enter Product Name',
                },
                short_desc: {
                    required : 'Please Enter Short Description',
                },
                long_descp: {
                    required : 'Please Enter Long Description',
                },
                product_thambnail: {
                    required : 'Please Select Product Thambnail Image',
                },
                selling_price: {
                    required : 'Please Enter Selling Price',
                },
                discount_price: {
                    required : 'Please Enter Discount Price',
                },
                product_code: {
                    required : 'Please Enter Product Code',
                },
                multi_image: {
                    required : 'Please Select Multi Image ',
                },
                subcategory_id: {
                    required : 'Please Enter Please Enter Subcategory',
                },
                category_id: {
                    required : 'Please Enter Please Enter Category',
                },
                product_qty: {
                    required : 'Please Enter Product Product Quantity',
                },
                brand_id: {
                    required : 'Please Enter Brand Name',
                },
                vendor_id: {
                    required : 'Please Enter Vendor Name',
                },
                product_color: {
                    required : 'Please Enter Product Color',
                },
                product_tag: {
                    required : 'Please Enter Product Tag',
                },
                product_size: {
                    required : 'Please Enter Product Size',
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

<script type="text/javascript">

function  mailThumUrl(input){
    if(input.files && input.files[0])
    {
        var reader = new FileReader();
        reader.onload = function(e){
            $('#mailThumb').attr('src',e.target.result).width(80).height(80);
        };
        reader.readAsDataURL(input.files[0]);
    }


}

$(document).ready(function(){
     $('#multiImage').on('change', function(){ //on file input change
        if (window.File && window.FileReader && window.FileList && window.Blob) //check File API supported browser
        {
            var data = $(this)[0].files; //this file data
             
            $.each(data, function(index, file){ //loop though each file
                if(/(\.|\/)(gif|jpe?g|png)$/i.test(file.type)){ //check supported file type
                    var fRead = new FileReader(); //new filereader
                    fRead.onload = (function(file){ //trigger function on successful read
                    return function(e) {
                        var img = $('<img/>').addClass('thumb').attr('src', e.target.result) .width(100)
                    .height(80); //create image element 
                        $('#preview_img').append(img); //append image to output element
                    };
                    })(file);
                    fRead.readAsDataURL(file); //URL representing the file's data.
                }
            });
             
        }else{
            alert("Your browser doesn't support File API!"); //if File API is absent
        }
     });
    });
     
</script>



{{-- <script type="text/javascript">

$(document).ready(function()){
    $('select[name="category_id"]').on(change,function(){
        var category_id = $(this).val();
        if(category_id){
            url:"{{url('/subcategory/ajax')}}/"+category_id,
            type :"get",
            datatype:"json",
            success::function(data){
                $('select[name="subcategory_id"]').html('');
                var d=$('select[name="subcategory_id"]').empty();
                $.each(data,function(key,value){
                    $('select[name="subcategory_id"]').append('<option value="[name="subcategory_id"]"</option>')
                })
            }
        }
    })
}

</script> --}}


@endsection
