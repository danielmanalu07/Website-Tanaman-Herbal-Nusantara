<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="{{ asset('assets/css/login.css') }}">
    <link rel="icon" type="image/jpg" href="{{ asset('images/logo.jpg') }}">

</head>

<body>
    <section class="h-100 gradient-form" style="background-color: #eee;">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-xl-10">
                    <div class="card rounded-3 text-black">
                        <div class="row g-0">
                            <div class="col-lg-6">
                                <div class="card-body p-md-5 mx-md-4">

                                    <div class="text-center">
                                        <img src="{{ asset('images/logo.jpg') }}" style="width: 100%;" height="20%"
                                            alt="logo">
                                    </div>
                                    @if (Session::has('error'))
                                        <div class="alert alert-danger" role="alert">
                                            {{ Session::get('error') }}
                                        </div>
                                    @endif
                                    @if (Session::has('success'))
                                        <div class="alert alert-success" role="alert">
                                            {{ Session::get('success') }}
                                        </div>
                                    @endif
                                    <form action="{{ route('admin.login') }}" method="POST">
                                        @csrf
                                        <p>Please login to your account</p>

                                        <div data-mdb-input-init class="form-outline mb-2">
                                            <label class="form-label" for="username">Username</label><span
                                                class="text-danger">*</span>
                                            <input type="text" class="form-control" name="username"
                                                placeholder="Enter your Username" />
                                        </div>
                                        @error('username')
                                            {{-- <div class="alert alert-danger" role="alert">
                                                {{ $message }}
                                            </div> --}}
                                            <span class="text-danger p-0 m-0">{{ $message }}</span>
                                        @enderror

                                        <div data-mdb-input-init class="form-outline mb-2 mt-2">
                                            <label class="form-label" for="passwords">Password</label><span
                                                class="text-danger">*</span>
                                            <input type="password" placeholder="Enter your Password" name="password"
                                                class="form-control" />
                                        </div>
                                        @error('password')
                                            {{-- <div class="alert alert-danger" role="alert">
                                                {{ $message }}
                                            </div> --}}
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror

                                        <div class="text-center pt-1 mb-5 pb-1 mt-3">
                                            <button data-mdb-button-init data-mdb-ripple-init
                                                class="btn btn-primary btn-block fa-lg gradient-custom-2 mb-3 w-50"
                                                type="submit">Log
                                                in</button>
                                        </div>

                                    </form>

                                </div>
                            </div>
                            <div class="col-lg-6 d-flex align-items-center gradient-custom-2">
                                <div class="text-white px-3 py-4 p-md-5 mx-md-4">
                                    <h4 class="mb-4">Welcome to Our Platform</h4>
                                    <p class="small mb-0">Join a growing community where innovation meets simplicity. We
                                        believe in empowering people through technology and providing solutions that
                                        truly make a difference. Log in now and take the next step toward a smarter and
                                        more connected experience.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>

</html>
