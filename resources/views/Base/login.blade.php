@extends('Base.bg')

@section('content')
    <div class="container-fluid bg-imglogin">
        <div class="d-flex flex-column w-100">
            <img class="logo-login mb-4" src="/images/logo.png" alt="Logo" style="max-width: 150px; height: auto;">
            <form method="POST" action="" class="w-100">
                @csrf
                <div class="form-group mb-4">
                    <label for="email" class="form-label" style="font-size: 1.3rem;">Email</label>
                    <input type="email" class="form-control input-test text-light" id="email" name="email" required>
                </div>

                <div class="form-group mb-4">
                    <label for="password" class="form-label" style="font-size: 1.3rem;">Password</label>
                    <input type="password" class="form-control input-test text-light" id="password" name="password"
                        required>
                </div>

                <button type="submit" class="btn btn-primary w-100 btn-login">Login</button>
            </form>

            @if (session()->has('error'))
                <div class="alert alert-danger mt-3 w-100 text-center">
                    <p class="mb-0">{{ session('error') }}</p>
                </div>
            @endif
        </div>
    </div>
@endsection