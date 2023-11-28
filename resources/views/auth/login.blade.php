@extends('layouts.auth')
@section('title', 'Login')
@section('content')

<div class="container d-flex flex-column">
    <div class="row align-items-center justify-content-center g-0
        min-vh-100">
        <div class="col-12 col-md-8 col-lg-6 col-xxl-4 py-8 py-xl-0">
            <!-- Card -->
            <div class="card smooth-shadow-md">
                <!-- Card body -->
                <div class="card-body p-6">
                    <div class="mb-4">
                        <a href="/"><img src="{{ asset('images/logo/logo.png') }}" class="mb-2" alt=""></a>
                        <p class="mb-6">Please enter your login information.</p>
                    </div>
                    <!-- Form -->
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <!-- Username -->
                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone Number</label>
                            <input type="text" id="phone" class="form-control" name="phone" required value="{{ old('phone') }}">
                        @error('phone')
                            <strong class="text-danger">{{ $message }}</strong>
                        @enderror
                        </div>
                        <!-- Password -->
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" id="password" class="form-control" name="password" required>
                            @error('password')
                            <strong class="text-danger">{{ $message }}</strong>
                        @enderror
                        </div>
                        <!-- Checkbox -->
                        <div class="d-lg-flex justify-content-between align-items-center
                            mb-4">
                            <div class="form-check custom-checkbox">
                                <input type="checkbox" class="form-check-input" id="rememberme">
                                <label class="form-check-label" for="rememberme">Remember
                                me</label>
                            </div>
                        </div>
                        <div>
                            <!-- Button -->
                            <div class="d-grid">
                                <button type="submit" class="btn btn-dark">Sign
                                in</button>
                            </div>
                            <div class="d-md-flex justify-content-between mt-4">
                                <div class="mb-2 mb-md-0">
                                    <a href="sign-up.html" class="fs-5">Create An
                                    Account </a>
                                </div>
                                <div>
                                    <a href="forget-password.html" class="text-inherit
                                        fs-5">Forgot your password?</a>
                                </div>
                            </div>
                        </div>
                        @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                            <strong>Error!</strong> {{ session('error') }}<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
