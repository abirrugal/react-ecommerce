@extends('layouts.app')
@section('title', 'Add Category')
@section('content')



<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>


<div class="card col-md-8 col-lg-6 my-3">
    <div class="card-header">
        <h4>Add Category</h4>
    </div>
    <div class="card-body">
        <form id="basic-form" method="post" action="{{ route('category.store') }}" enctype="multipart/form-data" >
            @csrf

            <div class="mb-3">
                <label for="name" class="col-form-label">Name</label>
                <div class="form-group">
                    <input type="text" id="name" name="name" class="form-control" placeholder="Name" />
                </div>
            </div>

            <div class="mb-3">
                <label for="description" class="col-form-label">Description</label>
                <div class="form-group">
                    <textarea class="form-control" id="description" name="description" placeholder="Description here" id="description" style="height: 100px"></textarea>
                </div>
            </div>

            <div class="mb-3">
                <label for="image" class="col-form-label">Image</label>
                <div class="form-group">
                    <input type="file" name="image" id="image" class="form-control" placeholder="Product image " id="image"/>
                </div><br>
                <div class="row mb-3">
                    <div class="col-sm-3">
                        <h6 class="mb-0"></h6>
                        <img src="{{ url('images/default.png') }}"
                            alt="Admin" style="width: 120px" height="100px" id="showImage">
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary px-4">Add Category</button>
        </form>
    </div>
</div>


{{-- Form Validation ---------------------------------------------------- --}}
<script>
$(document).ready(function() {
  $("#basic-form").validate({
    rules: {

        name : {
        required: true
      },
      description : {
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





