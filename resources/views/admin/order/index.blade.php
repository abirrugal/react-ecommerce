@extends('layouts.app')
@section('title', 'All Order')
@section('content')

<div class="card my-3">
    <div class="card-header d-flex justify-content-between">
        <h4>Orders</h4>

    </div>
    <div class="card-body p-0">
        <table class="table">
            <thead class="bg-light">
              <tr class="text-white">
                  <th scope="col">User Name</th>
                <th scope="col">Order Id</th>
                <th scope="col">Total Price</th>
                <th scope="col">Status</th>
                <th scope="col">Action</th>
              </tr>
            </thead>
            <tbody>

                @foreach ($orders as $key => $item)
                <tr>
                    <td>{{ $item->user->username }}</td>
                    <td>{{ $item->order_id }}</td>
                    <td>{{ $item->total_price }}</td>
                    <td>{{ $item->status }}</td>
                    <td>
                        <a href="{{ route('order.details',$item->id) }}" class="btn btn-info text-white btn-sm">
                            <i data-feather="eye" class="nav-icon icon-xs"></i>
                        </a>
                        <a href="{{ route('order.invoice',$item->id) }}" target="_blank" class="btn btn-info text-white btn-sm">Invoice</a>
                    </td>
                </tr>
                @endforeach

            </tbody>
        </table>
          {{ $orders->links() }}
    </div>
</div>

@endsection
