@extends('layout')
@section('content')
<h4>Tambah User</h4>
<form action="{{ route('user.store') }}" method="POST">
  @csrf
  @include('user._form')
  <button class="btn btn-primary">Simpan</button>
  <a href="{{ route('user.index') }}" class="btn btn-secondary">Batal</a>
</form>
@endsection
