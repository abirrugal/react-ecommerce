@extends('layouts.app')
@section('title', 'All Category')
@section('content')

<div class="card my-3">
    <div class="card-header d-flex justify-content-between">
        <h4>Categorys</h4>
        <div>
            <a href="{{ route('category.create') }}" class="btn btn-primary">Add Category</a>
        </div>
    </div>
    <div class="card-body p-0">
        <table class="table">
            <thead class="bg-light">
              <tr class="text-white">
                <th scope="col">SI</th>
                <th scope="col">Category Name</th>
                <th scope="col">Description</th>
                <th scope="col">Image</th>
                <th scope="col">Status</th>
                <th scope="col">Action</th>
              </tr>
            </thead>
            <tbody>
                @foreach ($categories as $key => $category)
                <tr>
                    <td>{{ $key+1 }}</td>
                    <td>{{ $category->name }}</td>
                    <td>{{ Str::limit($category->description, 25) }}</td>
                    <td>
                        <img src="{{ asset( $category->image ) }}" style="width: 70px; height:40x;" alt="Img">
                    </td>
                    <td>{{ $category->status }}</td>
                    <td>
                        <a href="{{ route('category.edit',$category->id) }}" class="btn btn-info text-white btn-sm">
                            <i data-feather="edit" class="nav-icon icon-xs"></i>
                        </a>
                        <a href="{{ route('category.delete',$category->id) }}" id="delete" class="btn btn-danger btn-sm">
                            <i data-feather="trash-2" class="nav-icon icon-xs"></i>
                        </a>
                    </td>
                </tr>
                @endforeach

            </tbody>
        </table>
          {{ $categories->links() }}
    </div>
</div>

@endsection
