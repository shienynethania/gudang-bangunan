@extends('layout')

@section('content')
<div class="row justify-content-center">
  <div class="col-md-4">
    <h4 class="mb-3">Login</h4>
    <form action="{{ route('login.proses') }}" method="POST">
      @csrf
      <div class="mb-3">
        <label class="form-label">Username</label>
        <input type="text" name="username" class="form-control" value="{{ old('username') }}" autofocus>
      </div>
      <div class="mb-3">
        <label class="form-label">Password</label>
        <input type="password" name="password" class="form-control">
      </div>
      <button class="btn btn-primary w-100">Masuk</button>
    </form>
    <p class="mt-3 text-center">Belum punya akun? <a href="{{ route('register') }}">Daftar</a></p>
  </div>
</div>
@endsection
