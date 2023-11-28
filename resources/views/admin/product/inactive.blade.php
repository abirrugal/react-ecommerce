@extends('layouts.app')
@section('title', 'All Inactive Products')
@section('content')


<div class="card my-3">
    <div class="card-header d-flex justify-content-between">
        <h4>All Inactive Product</h4>
    </div>
    <div class="card-body p-0">
        <table class="table">
            <thead class="bg-light">
              <tr class="text-white">
                <th scope="col">SI</th>
                <th scope="col">Name</th>
                <th scope="col">Price</th>
                <th scope="col">Rating</th>
                <th scope="col">Stock_in</th>
                <th scope="col">Image</th>
                <th scope="col">Status</th>
              </tr>
            </thead>
            <tbody>
                @foreach ($products as $key => $item)
                <tr>
                    <td>{{ $key+1 }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->price }}</td>
                    <td>{{ $item->rating }}</td>
                    <td>{{ $item->stock_in }}</td>
                    <td>
                        <img src="{{ asset( $item->image ) }}" style="width: 100px; height:40x;" alt="Image">
                    </td>
                    <td>{{ $item->status }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
          {{ $products->links() }}
    </div>
</div>
@endsection
