@extends('layout')

@section('content')
<div class="row justify-content-center">
  <div class="col-md-4">
    <h4 class="mb-3">Registrasi</h4>
    <form action="{{ route('register.proses') }}" method="POST">
      @csrf
      <div class="mb-3">
        <label class="form-label">Username</label>
        <input type="text" name="username" class="form-control" value="{{ old('username') }}">
      </div>
      <div class="mb-3">
        <label class="form-label">Password</label>
        <input type="password" name="password" class="form-control">
      </div>
      <div class="mb-3">
        <label class="form-label">Ulangi Password</label>
        <input type="password" name="password_confirmation" class="form-control">
      </div>
      <div class="mb-3">
        <label class="form-label">Daftar sebagai</label>
        <select name="idrole" class="form-select">
          @foreach($role as $r)
            <option value="{{ $r->idrole }}" @selected(old('idrole') == $r->idrole)>{{ $r->nama_role }}</option>
          @endforeach
        </select>
      </div>
      <button class="btn btn-primary w-100">Daftar</button>
    </form>
    <p class="mt-3 text-center">Sudah punya akun? <a href="{{ route('login') }}">Login</a></p>
  </div>
</div>
@endsection
