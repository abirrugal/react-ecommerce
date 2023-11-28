@extends('layouts.app')
@section('title', 'All Product')
@section('content')


<div class="container">

    <div class="block-header mt-5">
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Product</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href=""><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Product Add</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="row row-cols-1 row-cols-md-3 g-4">
        @foreach ($products as $item)

            <div class="col">
            <div class="card h-100">
                <img src="{{ asset($item->image) }}"
                alt="" />
                <div class="card-body">
                    <h5 class="card-title">{{ $item['category']['name'] }}</h5>
                    <div class="product_details">
                        <h3>{{ $item->name }}</h3>
                        <div class="row">
                            <div class="col-md-6">

                                <h5>Price : ${{ $item->price }}</h5>
                            </div>
                            <div class="col-md-6">
                                @php
                                    $amount = $item->price - $item->discount;
                                @endphp
                                @if ($item->discount == NULL)
                                    <span class="sale"></span>
                                @else
                                    <h5>Discount: ${{ round($amount) }}</h5>
                                @endif
                            </div>
                        </div>
                        @if ($item->stock_in > 0)
                            <span class="stock-status in-stock"> Available Product </span>
                        @else
                            <span class="stock-status out-stock"> Stock Out </span>
                        @endif
                        <div class="action mt-2">
                            <a href="{{ route('product.show',$item->id) }}" class="btn btn-info text-white btn-sm">
                                <i data-feather="eye" class="nav-icon icon-xs"></i>
                            </a>
                            <a href="{{ route('product.edit',$item->id) }}" class="btn btn-info text-white btn-sm">
                                <i data-feather="edit" class="nav-icon icon-xs"></i>
                            </a>
                            <a href="{{ route('product.inactive',$item->id) }}" id="delete" class="btn btn-danger btn-sm">
                                <i data-feather="trash-2" class="nav-icon icon-xs"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            </div>

        @endforeach
        {{ $products->links() }}
      </div>
</section>

@endsection
