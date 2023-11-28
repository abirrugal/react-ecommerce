@extends('layouts.app')
@section('title', 'SubCategory Add')
@section('content')

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>

<div class="card col-md-8 col-lg-6 my-3">
    <div class="card-header">
        <h4>Add Sub Category</h4>
    </div>
    <div class="card-body">
        <form id="basic-form" method="post" action="{{ route('subcategory.store') }}" enctype="multipart/form-data" >
            @csrf
            <div class="mb-3">
                <label for="name" class="col-form-label">Category Name :</label>
                <div class="form-group">
                    <select name="category_id" class="form-select mb-3" aria-label="Default select example">
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="mb-3">
                <label for="name" class="col-form-label">Sub Category Name :</label>
                <div class="form-group">
                    <input type="text" id="name" name="name" class="form-control" placeholder="Sub-Category Name" />
                </div>
            </div>
            <div class="mb-3">
                <label for="image" class="col-form-label">Sub Category Image :</label>
                <div class="form-group">
                    <input type="file" name="image" id="image" class="form-control" placeholder="Product image " id="image"/>
                </div><br>
                <div class="row mb-3">
                    <div class="mb-3">
                        <h6 class="mb-0"></h6>
                        <img src="{{ url('images/default.png') }}"
                            alt="Admin" style="width: 100px" height="100px" id="showImage">
                    </div>
                </div>
            </div>
            <input type="submit" class="btn btn-primary px-4 submit" value="Sub Category Add" />
        </form>
    </div>
</div>


{{-- Form Validation ---------------------------------------------------- --}}
<script>
$(document).ready(function() {
  $("#basic-form").validate({
    rules: {

        category_id : {
        required: true
      },
      name : {
        required: true
      },
      image : {
        required: true
      },

    },
  });
});
</script>


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
@endsection





