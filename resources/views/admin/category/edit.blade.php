@extends('layouts.app')
@section('title', 'Category Edit')
@section('content')

<div class="card col-md-8 col-lg-6 my-3">
    <div class="card-header">
        <h4>Edit Category</h4>
    </div>

    <div class="card-body">
        <form id="basic-form" method="post" action="{{ route('category.update',$category->id) }}" enctype="multipart/form-data" >
            @csrf

            <input type="hidden" name="id" value="{{ $category->id }}">
		    <input type="hidden" name="old_image" value="{{ $category->image }}">

            <div class="mb-3">
                <label for="name" class="col-form-label">Category Name :</label>
                <div class="form-group">
                    <input type="text" id="name" name="name" class="form-control" placeholder="Category Name" value="{{ $category->name }}"/>
                </div>
            </div>

            <div class="mb-3">
                <label for="description" class="col-form-label">Category Description :</label>
                <div class="form-group">
                    <textarea class="form-control" id="description" name="description" placeholder="Category Description here" id="description" style="height: 100px">{{ $category->description }}</textarea>
                </div>
            </div>

            <div class="mb-3">
                <label for="image" class="col-form-label">Product Discount :</label>
                <div class="form-group">
                    <input type="file" name="image" id="image" class="form-control" placeholder="Product image " id="image"/>
                </div><br>
                <div class="mb-3">
                    <div class="col-sm-3">
                        <h6 class="mb-0"></h6>
                        <img src="{{ asset($category->image)   }}"
                            alt="Admin" style="width: 100px" height="100px" id="showImage">
                    </div>
                </div>
            </div>

            <input type="submit" class="btn btn-primary px-4 submit" value="Category Update" />
        </form>
    </div>
</div>

{{-- Image Show ----------------------------------------------------------------------- --}}

@push('footer_scripts')

<script type="text/javascript">
    $(document).ready(function() {
        $('#image').change(function(e) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#showImage').attr('src', e.target.result);
            }
            reader.readAsDataURL(e.target.files['0']);
        });
    });
</script>
@endpush

@endsection
