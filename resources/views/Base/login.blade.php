@extends('base.bg')

@section('content')
    <div class="row justify-content-center align-items-center h-100 position-relative z-2">
        <div class="col-md-3 text-light">
            <h2 class="text-center mt-3">Login</h2>
            <form method="POST" action="">
                @csrf
                <div class="form-group">
                    <label for="email">Email address</label>
                    <input type="email" class="form-control input-test text-light" id="email" name="email" required>
                </div>
                <div class="form-group mt-2">
                    <label for="password">Password</label>
                    <input type="password" class="form-control input-test text-light" id="password" name="password" required>
                </div>
                <button type="submit" class="btn btn-primary btn-block mt-3">Login</button>
            </form>
            @if (session()->has('error'))
                <div class="alert alert-danger mt-3">
                    <p>{{ session('error') }}</p>
                </div>
            @endif
        </div>
    </div>
@endsection
