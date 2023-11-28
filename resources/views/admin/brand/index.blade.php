@extends('layouts.app')
@section('title', 'All Brand')
@section('content')

<div class="card my-3">
    <div class="card-header d-flex justify-content-between">
        <h4>Brands</h4>
        <div>
            <a href="{{ route('brand.add') }}" class="btn btn-primary">Add Brand</a>
        </div>
    </div>
    <div class="card-body p-0">
        <table class="table">
            <thead class="bg-light">
                <tr class="text-white">
                    <th scope="col">SI</th>
                    <th scope="col">Brand Name</th>
                    <th scope="col">Description</th>
                    <th scope="col">Image</th>
                    <th scope="col">Status</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($brands as $key => $brand)
                <tr>
                    <td>{{ $key+1 }}</td>
                    <td>{{ $brand->name }}</td>
                    <td>{{ Str::limit($brand->description, 25) }}</td>
                    <td>
                        <img src="{{ asset( $brand->image ) }}" style="width: 70px; height:40x;" alt="image">
                    </td>
                    <td>{{ $brand->status }}</td>
                    <td>
                        <a href="{{ route('brand.edit',$brand->id) }}" class="btn btn-info text-white btn-sm">
                            <i data-feather="edit" class="nav-icon icon-xs"></i>
                        </a>
                        <a href="{{ route('brand.delete',$brand->id) }}" id="delete" class="btn btn-danger btn-sm">
                            <i data-feather="trash-2" class="nav-icon icon-xs"></i>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{ $brands->links() }}

@endsection
