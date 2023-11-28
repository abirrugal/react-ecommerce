@extends('layouts.app')
@section('title', 'Product Edit')
@section('content')

<div class="container">

    <div class="block-header mt-5 p-5">
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Product</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href=""><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Product Edit</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="row clearfix bg-white">
        <form id="basic-form" method="post" action="{{ route('product.update',$product->id) }}" enctype="multipart/form-data" >
            @csrf
            <input type="hidden" name="id" value="{{ $product->id }}">
            <input type="hidden" name="old_image" value="{{ $product->image }}">

            <div class="row">
                <div class="col-sm-4">
                    <label for="price" class="col-form-label">Category Name :</label>
                    <select name="category_id" class="form-select" id="inputVendor">
                        <option></option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ $category->id == $product->category_id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-sm-4">
                    <label for="inputCollection" class="col-form-label">SubCategory Name :</label>
                    <select name="subcategory_id" class="form-select" id="inputCollection">
                        <option></option>
                        @foreach ($subcategories as $subCat)
                            <option value="{{ $subCat->id }}" {{ $subCat->id == $product->subcategory_id ? 'selected' : '' }}>{{ $subCat->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-sm-4">
                    <label for="brand_id " class="col-form-label">Brand Name :</label>
                    <select name="brand_id" class="form-select" id="inputProductType">
                        <option></option>
                        @foreach($brands as $brand)
                            <option value="{{ $brand->id }}" {{ $brand->id == $product->category_id ? 'selected' : '' }}>{{ $brand->name }}</option>
                        @endforeach
                      </select>
                </div>
            </div>

            <div class="row">

                <div class="col-sm-12">
                    <label for="name" class="col-form-label">Product Name :</label>
                    <div class="form-group">
                        <input type="text" id="name" name="name" minlength="3" class="form-control" placeholder="Product Name" value="{{ $product->name }}"/>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-4">
                    <label for="price" class="col-form-label">Product Price :</label>
                    <div class="form-group">
                        <input type="text" id="price" name="price" class="form-control" placeholder="Product Price" value="{{ $product->price }}"/>
                    </div>
                </div>
                <div class="col-sm-4">
                    <label for="discount" class="col-form-label">Product Discount Price:</label>
                    <div class="form-group">
                        <input type="text" id="discount" name="discount" class="form-control" placeholder="Product discount Price" value="{{ $product->discount }}"/>
                    </div>
                </div>
                <div class="col-sm-4">
                    <label for="stock_in" class="col-form-label">Product Stock_in :</label>
                    <div class="form-group">
                        <input type="text" id="stock_in" name="stock_in" class="form-control" placeholder="Product Stock_in" value="{{ $product->stock_in }}"/>
                    </div>
                </div>
            </div>

            <div class="row">

                <div class="col-sm-12">
                    <label for="description" class="col-form-label">Product Description :</label>
                    <div class="form-group">
                        <textarea class="form-control" id="description" name="description" placeholder="Product Description here" id="description" style="height: 100px">{{ $product->description }}</textarea>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <label for="image" class="col-form-label">Product Image :</label>
                    <div class="form-group">
                        <input class="form-control" type="file" name="image" id="image" onChange="mainImage(this)"> <br>
                        <img src="{{ asset($product->image)   }}"
                        alt="Admin" style="width: 100px" height="100px" id="mainImageShow" alt="">

                    </div><br>
                </div>
            </div>

            <input type="submit" class="btn btn-primary px-4 submit" value="Product Update" />
        </form>
    </div><br><br>



    <h1> Multiple Image Update</h1>
    <div class="row clearfix">
         {{-- Updat Multi Image -------------------------------------------------------------- --}}

         <div class="page-content">
            <hr>
            <div class="card">
                <div class="card-body">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th scope="col">#SI</th>
                                <th scope="col">Image</th>
                                <th scope="col">Chage Image</th>
                                <th scope="col">Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            <form id="myForm"  action="{{ route('product.multiImage.update') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @foreach ($images as $key => $item)

                                <tr>
                                    <th scope="row">{{ $key+1 }}</th>
                                    <td>
                                        <img src="{{ asset($item->image) }}" alt="" style="width: 70px; height:40px;">
                                    </td>
                                    <td>
                                        <input type="file" class="form-group" name="images[{{ $item->id }}]">
                                    </td>
                                    <td>
                                        <input type="submit" class="btn btn-primary px-4" value="Update Image" />
                                        <a href="{{ route('product.multiImage.delete',$item->id) }}" id="delete" class="btn btn-danger btn-sm">
                                            <i data-feather="trash-2" class="nav-icon icon-xs"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </form>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <br><br>
    </div><br><br>
</div>


@push('footer_scripts')

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
@endpush

@endsection





