@extends('layouts.app')
@section('title', 'Sub-Categories')
@section('content')

<div class="card my-3">
    <div class="card-header d-flex justify-content-between">
        <h4>Sub Categorys</h4>
        <div>
            <a href="{{ route('subcategory.add') }}" class="btn btn-primary">Add Sub Category</a>
        </div>
    </div>
    <div class="card-body p-0">
        <table class="table">
            <thead class="bg-light">
              <tr class="text-white">
                <th scope="col">SI</th>
                <th scope="col">Category Name</th>
                <th scope="col">Sub Category Name</th>
                <th scope="col">Image</th>
                <th scope="col">Status</th>
                <th scope="col">Action</th>
              </tr>
            </thead>
            <tbody>
                @foreach ($subcategories as $key => $subCategory)
                <tr>
                    <td>{{ $key+1 }}</td>
                    <td> {{ $subCategory['category']['name'] }}</td>
                    <td>{{ $subCategory->name }}</td>
                    <td>
                        <img src="{{ asset( $subCategory->image ) }}" style="width: 70px; height:40x;" alt="">
                    </td>
                    <td>{{ $subCategory->status }}</td>
                    <td>
                        <a href="{{ route('subcategory.edit',$subCategory->id) }}" class="btn btn-info text-white btn-sm">
                            <i data-feather="edit" class="nav-icon icon-xs"></i>
                        </a>
                        <a href="{{ route('subcategory.delete',$subCategory->id) }}" id="delete" class="btn btn-danger btn-sm">
                            <i data-feather="trash-2" class="nav-icon icon-xs"></i>
                        </a>
                    </td>
                </tr>
                @endforeach

            </tbody>
        </table>
          {{ $subcategories->links() }}
    </div>
</div>

@endsection
