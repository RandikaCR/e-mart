<!DOCTYPE html>
<html lang="en">
<head>
    @include('partials.head')
</head>
<body>
<div class="main-wrapper">
    <div class="page-wrapper full-page">
        <div class="page-content d-flex align-items-center justify-content-center">

            <div class="row w-100 mx-0 auth-page">
                <div class="col-md-4 col-xl-3 mx-auto">
                    <div class="card">
                        <div class="row">
                            <div class="col-md-12 ps-md-0">
                                <div class="auth-form-wrapper px-5 py-5">
                                    <a href="#" class="noble-ui-logo d-block mb-2">E Mart <span>Marketplace</span></a>
                                    <h5 class="text-muted fw-normal mb-4">Welcome back! Log in to your account.</h5>
                                    <div class="row">
                                        <div class="col-12">
                                            @error('email')
                                            <div class="alert alert-danger">
                                                <p class="text-center">{{ $message }}</p>
                                            </div>
                                            @enderror

                                            @error('password')
                                            <div class="alert alert-danger">
                                                <p class="text-center">{{ $message }}</p>
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <form method="POST" class="forms-sample" action="{{ route('login') }}">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="userEmail" class="form-label">Email address</label>
                                            <input type="email" name="email" class="form-control" id="userEmail" placeholder="Email"  value="{{ old('email') }}" required autocomplete="email" autofocus>
                                        </div>
                                        <div class="mb-3">
                                            <label for="userPassword" class="form-label">Password</label>
                                            <input type="password" name="password" class="form-control" id="userPassword" autocomplete="current-password" placeholder="Password">
                                        </div>
                                        <div class="form-check mb-3">
                                            <input type="checkbox" class="form-check-input" id="authCheck" name="remember">
                                            <label class="form-check-label" for="authCheck">
                                                Remember me
                                            </label>
                                        </div>
                                        <div>
                                            <button type="submit" name="login" class="btn btn-primary me-2 mb-2 mb-md-0 text-white">Login</button>
                                        </div>
                                        <a href="{{ route('register') }}" class="d-block mt-3 text-muted">Not a user? Sign up</a>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

@include('partials.script')

</body>
</html>
