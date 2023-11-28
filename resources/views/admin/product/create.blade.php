@extends('layouts.app')
@section('title', 'Product Add')
@section('content')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script> --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>

<div class="container">

    <div class="block-header mt-5">
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Product</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href=""><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Product Add</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="row clearfix bg-white p-5 ">
        <form id="basic-form" method="post" action="{{ route('product.store') }}" enctype="multipart/form-data" >
            @csrf

            <div class="row">
                <div class="col-sm-4 mb-3">
                    <label for="category_id" class="col-form-label">Category Name :</label>
                    <select name="category_id" class="form-select" id="category_id">
                        <option></option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                      </select>
                </div>

                <div class="col-sm-4 mb-3">
                    <label for="subcategory_id" class="col-form-label">Sub Category Name :</label>
                    <select name="subcategory_id" class="form-select" id="subcategory_id">
                        <option></option>

                      </select>
                </div>
                <div class="col-sm-4 mb-3">
                    <label for="brand_id " class="col-form-label">Brand Name :</label>
                    <select name="brand_id" class="form-select" id="inputProductType">
                        <option></option>
                        @foreach($brands as $brand)
                        <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                         @endforeach
                      </select>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12 mb-3">
                    <label for="name" class="col-form-label">Product Name :</label>
                    <div class="form-group">
                        <input type="text" id="name" name="name" minlength="3" class="form-control" placeholder="Product Name" />
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-4 mb-3">
                    <label for="price" class="col-form-label">Product Price :</label>
                    <div class="form-group">
                        <input type="text" id="price" name="price" class="form-control" placeholder="Product Price" />
                    </div>
                </div>
                <div class="col-sm-4 mb-3">
                    <label for="discount" class="col-form-label">Product Discount Price:</label>
                    <div class="form-group">
                        <input type="text" id="discount" name="discount" class="form-control" placeholder="Product discount Price" />
                    </div>
                </div>
                <div class="col-sm-4 mb-3">
                    <label for="stock_in" class="col-form-label">Product Current Stock :</label>
                    <div class="form-group">
                        <input type="text" id="stock_in" name="stock_in" class="form-control" placeholder="Product Current Stock" />
                    </div>
                </div>
            </div>

            <div class="row">

                <div class="col-sm-12 mb-3">
                    <label for="description" class="col-form-label">Product Description :</label>
                    <div class="form-group">
                        <textarea class="form-control" id="description" name="description" placeholder="Product Description here" id="description" style="height: 100px"></textarea>
                    </div>
                </div>
            </div>

            <div class="row">
                <table class="table" id="table">
                    <tr>
                        <th>Size : </th>
                        <th>Value : </th>
                        <th>Price : </th>
                        <th>Action : </th>
                    </tr>
                    <tr>
                        <td>
                            <select name="attribute_names[]" class="form-select" id="inputProductType">
                                <option value="0"></option>
                                <option value="White">White</option>
                                <option value="Black">Black</option>
                                <option value="Blue">Blue</option>
                                <option value="Green">Green</option>
                            </select>
                        </td>

                        <td>
                            <select name="attribute_values[]" class="form-select" id="inputProductType">
                                <option value="0"></option>
                                <option value="S">S</option>
                                <option value="M">M</option>
                                <option value="L">L</option>
                                <option value="XL">XL</option>
                            </select>
                        </td>

                        <td>
                            <div class="form-group">
                                <input type="text" id="" name="additional_prices[]" class="form-control" placeholder="Additional Price" />
                            </div>
                        </td>
                        <td>
                            <button type="button" name="add" id="add" class="btn btn-info text-prymary btn-sm">
                                <i data-feather="plus-circle" class="nav-icon icon-xs"></i>
                        </button>
                    </td>
                    </tr>
                </table>
            </div>

            <div class="row">
                <div class="col-sm-6">
                    <label for="image" class="col-form-label">Product Image :</label>
                    <div class="form-group">
                        <input class="form-control" type="file" name="image" id="image" onChange="mainImage(this)"> <br>
                        <img src="{{ url('images/default.png') }}"
                        alt="Admin" style="width: 100px" height="100px" id="mainImageShow" alt="">

                    </div><br>
                </div>

                <div class="col-sm-6">
                    <label for="image" class="col-form-label">Product Multiple Image :</label>
                    <div class="form-group">
                        <input class="form-control" name="images[]" type="file" id="multiImg" multiple=""><br>

                        <div class="row" id="preview_img"></div>
                    </div><br>

                </div>
            </div>


            <input type="submit" class="btn btn-primary px-4 submit" value="Add Product" />
        </form>
    </div><br><br>



{{-- Form Validation ---------------------------------------------------- --}}
<script>
$(document).ready(function() {
  $("#basic-form").validate({
    rules: {

      category_id : {
        required: true
      },
      subcategory_id : {
        required: true
      },
      name : {
        required: true
      },
      price : {
        required: true
      },
      description : {
        required: true
      },
      stock_in : {
        required: true
      },

      image : {
        required: true
      },

    },
  });
});
</script>


{{-- Single Image Show script ----------------------------------- --}}
<script type="text/javascript">
    function mainImage(input){
        if (input.files && input.files[0]){
            var reader = new FileReader();
            reader.onload = function(e){
                $('#mainImageShow').attr('src',e.target.result).width(80).height(80);
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>


{{-- Multi Image Show script code --------------------------------------------------- --}}
<script>

    $(document).ready(function(){
     $('#multiImg').on('change', function(){ //on file input change
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



    {{-- Sub Category Show script code --------------------------------------------------- --}}

    <script type="text/javascript">

        $(document).ready(function(){
            $('select[name="category_id"]').on('change', function(){
                var category_id = $(this).val();
                if (category_id) {
                    $.ajax({
                        url: "{{ url('admin/subcategory/ajax') }}/"+category_id,
                        type: "GET",
                        dataType:"json",
                        success:function(data){
                            $('select[name="subcategory_id"]').html('');
                            var d =$('select[name="subcategory_id"]').empty();
                            $.each(data, function(key, value){
                                $('select[name="subcategory_id"]').append('<option value="'+ value.id + '">' + value.name + '</option>');
                            });
                        },

                    });
                } else {
                    alert('danger');
                }
            });
        });

</script>


<script>
    var i = 0;
    $('#add').click(function(){
        ++i;
        $('#table').append(
            `<tr>
                <td>
                    <select name="attribute_names[]" class="form-select" id="inputProductType">
                        <option value="0"></option>
                        <option value="White">White</option>
                        <option value="Black">Black</option>
                        <option value="Blue">Blue</option>
                        <option value="Green">Green</option>
                    </select>
                </td>
                <td>
                    <select name="attribute_values[]" class="form-select" id="inputProductType">
                        <option value="0"></option>
                        <option value="S">S</option>
                        <option value="M">M</option>
                        <option value="L">L</option>
                        <option value="XL">XL</option>
                    </select>
                </td>
                <td>
                    <div class="form-group">
                        <input type="text" id="" name="additional_prices[]" class="form-control" placeholder="Additional Price" />
                    </div>
                </td>
                <td>
                    <button type="button" class="btn btn-danger btn-sm remove-table-row">
                        Remove
                    </button>
                </td>
            </tr>`
        )
    });
    $(document).on('click','.remove-table-row',function(){
        $(this).parents('tr').remove();
    });
</script>
@endsection





