@extends('layouts.app')
@section('title', 'Product')
@section('content')

<div class="container mb-5">
    <h3 class="mt-4 mb-3">Products Details</h3>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-xl-6 ">
                    <div class="border" style="min-height:400px;">
                        <img src="{{ asset($product->image) }}" id="thumbnail" class="mw-100 mh-100 galleryImage">
                    </div>
                    <div class="mt-1 row g-3">
                        <div class="col-3">
                            <div class="border" style="min-height: 70px; min-width:70px;">
                                <img src="{{ asset($product->image) }}" class="mw-100 mh-100 galleryImage" alt="Image" role="button">
                            </div>
                        </div>
                        @foreach ($product->images as $image)
                            <div class="col-3">
                                <div class="border" style="min-height: 70px; min-width:70px;">
                                    <img src="{{ asset($image->image) }}" class="mw-100 mh-100 galleryImage" alt="Image" role="button">
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="col-xl-6 col-12">
                    <div class="my-5 mx-xl-10">
                        <div>
                            <h1>{{ $product->name }}</h1>
                            <div>
                                <span>
                                    <span class="me-2 text-dark align-items-center">
                                        {{ $average }}
                                        <i data-feather="star" class="text-warning pb-1"></i>
                                    </span>
                                    {{ $review_count }} Customer Reviews
                                </span>
                            </div>
                        </div>
                        <hr class="my-3">
                        <div class="mb-5">
                            @if ($product->discount == null)
                                <h4 class="mb-1">${{ $product->price }}</h4>
                            @else
                                <h4 class="mb-1">${{ $product->discount }}
                                    <span class="text-muted text-decoration-line-through">
                                        ${{ $product->price }}
                                    </span>
                                    <span class="text-warning">
                                        ({{ $product->discount_percentage }}% Off)
                                    </span>
                                </h4>
                                <span>inclusive of all taxes</span>
                            @endif
                        </div>
                        @if(isset($product_attributes['color']))
                        <div class="mb-4 d-md-flex justify-content-between align-items-center">
                            <h4 class="mb-2 mb-md-0">Color</h4>
                            <div>
                                <select class="form-control">
                                    @foreach ($product_attributes['color'] as $color)
                                        <option value="">{{ $color['value'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        @endif

                        @if(isset($product_attributes['size']))
                        <div class="mb-4 d-md-flex justify-content-between align-items-center">
                            <h4 class="mb-2 mb-md-0">Size</h4>
                            <div>
                                <select class="form-control">
                                    @foreach ($product_attributes['size'] as $color)
                                        <option value="">{{ $color['value'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        @endif
                        <hr class="mt-4 mb-2">
                        <div class=" mb-4" id="ecommerceAccordion">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item px-0">
                                    <a class="d-flex align-items-center text-inherit text-decoration-none h4 mb-0"
                                        data-bs-toggle="collapse" href="#productDetails" role="button"
                                        aria-expanded="false" aria-controls="productDetails">
                                        <div class="me-auto">
                                            Product Details
                                        </div>
                                    </a>
                                    <div class="collapse show" id="productDetails"
                                        data-bs-parent="#ecommerceAccordion">
                                        <div class="py-3 ">
                                            <p>{{ $product->description	}}</p>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="mb-4">
                            <h3 class="mb-4">Ratings &amp; Reviews</h3>
                            <div class="row align-items-center mb-4">
                                <div class="col-md-4 mb-4 mb-md-0">
                                    <h3 class="display-2">{{ $average }}</h3>
                                    <p class="mb-0">{{ $review_count }} Verified Buyers</p>
                                </div>
                            </div>
                            <div>
                                <div class="border-top py-4 mt-4">
                                    @foreach ($reviews as $review)
                                        <div class="border d-inline-block px-2 py-1 rounded-pill mb-3">
                                            <span class="text-dark">
                                                </span>{{ $review->rating }}</span>
                                                <i data-feather="star" class="text-warning nav-icon icon-xs pb-1"></i>
                                            </span>
                                        </div>
                                        <p>{{ $review->review }}</p>
                                        <div>
                                            <span>{{ $review->user->full_name }}</span>
                                            <span class="ms-4">{{ $review->created_at->diffForHumans() }}</span>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="my-3">
                                    <a href="javascript:void()" class="btn-link fw-semi-bold ">View all {{ $review_count }} reviews</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('footer_scripts')
<script>
    $('.galleryImage').click(function() {
        $('#thumbnail').attr('src', $(this).attr('src'));
    });
</script>
@endpush
@endsection
