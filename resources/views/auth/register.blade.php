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
                                <div class="auth-form-wrapper px-4 py-5">
                                    <a href="#" class="noble-ui-logo d-block mb-2">E Mart <span>Marketplace</span></a>
                                    <h5 class="text-muted fw-normal mb-4">Create a free account.</h5>
                                    <div class="row">
                                        <div class="col-12">
                                            @error('username')
                                            <div class="alert alert-danger">
                                                <p class="text-center">{{ $message }}</p>
                                            </div>
                                            @enderror

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
                                    <form method="POST" class="forms-sample" action="{{ route('register') }}">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="exampleInputUsername1" class="form-label">Username</label>
                                            <input type="text" name="username" class="form-control" id="exampleInputUsername1" autocomplete="Username" placeholder="Username" value="" required autofocus>
                                        </div>
                                        <div class="mb-3">
                                            <label for="userEmail" class="form-label">Email address</label>
                                            <input type="email" class="form-control" id="userEmail" placeholder="Email" name="email" value="" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="userPassword" class="form-label">Password</label>
                                            <input type="password" class="form-control" id="userPassword" autocomplete="current-password" placeholder="Password" name="password">
                                        </div>
                                        <div class="mb-3">
                                            <label for="userPasswordConfirm" class="form-label">Confirm Password</label>
                                            <input type="password" class="form-control" id="userPasswordConfirm" placeholder="Confirm Password" name="password_confirmation" required>
                                        </div>
                                        <div>
                                            <button type="submit" name="register" class="btn btn-primary me-2 mb-2 mb-md-0 text-white">Sign up</button>
                                        </div>
                                        <a href="{{ route('login') }}" class="d-block mt-3 text-muted">Already a user? Sign in</a>
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
