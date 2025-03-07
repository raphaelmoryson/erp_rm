@extends('base.bg')

@section('content')
    <div class="row justify-content-center align-items-center h-100 position-relative z-2 bg-imglogin">
        <div class="text-light d-flex justify-content-center align-items-center flex-column me-3">
            <img class="logo-login mb-5 me-3" src="/images/logo.png" alt="">
            <form method="POST" action="">
                @csrf
                <div class="form-group">
                    <label class="mb-3" style="font-size: 25.73px" for="email">Email</label>
                    <input type="email" class="form-control input-test text-light" id="email" name="email" required>
                </div>
                <div class="form-group mt-2">
                    <label class="mb-3" for="password" style="font-size: 25.73px">Password</label>
                    <input type="password" class="form-control input-test text-light" id="password" name="password" required>
                </div>
                <button type="submit" class="btn btn-primary btn-block mt-3 w-100 btn-login">Login</button>
            </form>
            @if (session()->has('error'))
                <div class="alert alert-danger mt-3">
                    <p>{{ session('error') }}</p>
                </div>
            @endif
        </div>
    </div>
@endsection
