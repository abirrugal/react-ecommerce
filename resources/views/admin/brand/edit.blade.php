@extends('layouts.app')
@section('title', 'Brand Edit')
@section('content')

<div class="card col-md-8 col-lg-6 my-3">
    <div class="card-header">
        <h4>Edit Brand</h4>
    </div>
    <div class="card-body">
        <form id="basic-form" method="post" action="{{ route('brand.update',$brand->id) }}" enctype="multipart/form-data" >
            @csrf

            <input type="hidden" name="id" value="{{ $brand->id }}">
		    <input type="hidden" name="old_image" value="{{ $brand->image }}">

            <div class="mb-3">
                <label for="name" class="col-form-label">Brand Name :</label>
                <div class="form-group">
                    <input type="text" id="name" name="name" class="form-control" placeholder="Brand Name" value="{{ $brand->name }}"/>
                </div>
            </div>

            <div class="mb-3">
                <label for="description" class="col-form-label">Brand Description :</label>
                <div class="form-group">
                    <textarea class="form-control" id="description" name="description" placeholder="Brand Description here" id="description" style="height: 100px">{{ $brand->description }}</textarea>
                </div>
            </div>

            <div class="mb-3">
                <label for="image" class="col-form-label">Brand Image :</label>
                <div class="form-group">
                    <input type="file" name="image" id="image" class="form-control" placeholder="Product image " id="image"/>
                </div><br>
                <div class="mb-3">
                    <div class="col-sm-3">
                        <h6 class="mb-0"></h6>
                        <img src="{{ asset($brand->image)   }}"
                            alt="Admin" style="width: 100px" height="100px" id="showImage">
                    </div>
                </div>
            </div>
            <input type="submit" class="btn btn-primary px-4 submit" value="Brand Update" />
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





