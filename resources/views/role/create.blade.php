@extends('layout')
@section('content')
<h4>Tambah Role</h4>
<form action="{{ route('role.store') }}" method="POST">
  @csrf
  @include('role._form')
  <button class="btn btn-primary">Simpan</button>
  <a href="{{ route('role.index') }}" class="btn btn-secondary">Batal</a>
</form>
@endsection
