@extends('layouts.app')
@section('title', 'Brand Add')
@section('content')

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>

<div class="card col-md-8 col-lg-6 my-3">
    <div class="card-header">
        <h4>Add Brand</h4>
    </div>

    <div class="card-body">
        <form id="basic-form" method="post" action="{{ route('brand.store') }}" enctype="multipart/form-data" >
            @csrf
            <div class="mb-3">
                <label for="name" class="col-form-label">Brand Name :</label>
                <div class="form-group">
                    <input type="text" id="name" name="name" class="form-control" placeholder="Brand Name" />
                </div>
            </div>
            <div class="mb-3">
                <label for="description" class="col-form-label">Brand Description :</label>
                <div class="form-group">
                    <textarea class="form-control" id="description" name="description" placeholder="Brand Description here" id="description" style="height: 100px"></textarea>
                </div>
            </div>
            <div class="mb-3">
                <label for="image" class="col-form-label">Brand Image:</label>
                <div class="form-group">
                    <input type="file" name="image" id="image" class="form-control" placeholder="Product image " id="image"/>
                </div><br>
                <div class="mb-3">
                    <div class="col-sm-3">
                        <h6 class="mb-0"></h6>
                        <img src="{{ url('images/default.png') }}"
                            alt="Admin" style="width: 100px" height="100px" id="showImage">
                    </div>
                </div>
            </div>
            <input type="submit" class="btn btn-primary px-4 submit" value="Brand Add" />
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

@endsection





