@extends('layouts.app')
@section('title', 'Sub-Category Edit')
@section('content')

<div class="card col-md-8 col-lg-6 my-3">
    <div class="card-header">
        <h4>Edit Sub Category</h4>
    </div>
    <div class="card-body">
        <form id="basic-form" method="post" action="{{ route('subcategory.update',$subcategory->id) }}" enctype="multipart/form-data" >
            @csrf
            <input type="hidden" name="id" value="{{ $subcategory->id }}">
		    <input type="hidden" name="old_image" value="{{ $subcategory->image }}">

            <div class="mb-3">
                <label for="name" class="col-form-label">Select Category :</label>
                <div class="form-group">
                    <select name="category_id" class="form-select mb-3" aria-label="Default select example">
                        <option selected=""> select Category</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ $category->id == $subcategory->category_id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="mb-3">
                <label for="name" class="col-form-label">Sub-Category Name :</label>
                <div class="form-group">
                    <input type="text" id="name" name="name" class="form-control" placeholder="Sub-Category Name" value="{{ $subcategory->name }}"/>
                </div>
            </div>

            <div class="mb-3>
                <label for="image" class="col-form-label">Sub Category Image :</label>
                <div class="form-group">
                    <input type="file" name="image" id="image" class="form-control" placeholder="Product image " id="image"/>
                </div><br>
                <div class="mb-3">
                    <div class="col-sm-3">
                        <h6 class="mb-0"></h6>
                        <img src="{{ asset($subcategory->image)   }}"
                            alt="Admin" style="width: 100px" height="100px" id="showImage">
                    </div>
                </div>
            </div>

            <input type="submit" class="btn btn-primary px-4 submit" value="Sub Category Update" />
        </form>
    </div>
</div>

@push('footer_scripts')

    {{-- Image Show ----------------------------------------------------------------------- --}}
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

    <script type="text/javascript">
        $(document).ready(function(){
            $('select[name="category_id"]').on('change', function(){
                var category_id = $(this).val();
                if (category_id) {
                    $.ajax({
                        url: "{{ url('/subcategory/ajax') }}/"+category_id,
                        type: "GET",
                        dataType:"json",
                        success:function(data){
                            $('select[name="subcategory_id"]').html('');
                            var d =$('select[name="subcategory_id"]').empty();
                            $.each(data, function(key, value){
                                $('select[name="subcategory_id"]').append('<option value="'+ value.id + '">' + value.subcategory_name + '</option>');
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
