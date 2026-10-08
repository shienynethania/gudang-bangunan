@extends('layout')
@section('content')
<h4>Tambah Satuan</h4>
<form action="{{ route('satuan.store') }}" method="POST">
  @csrf
  @include('satuan._form')
  <button class="btn btn-primary">Simpan</button>
  <a href="{{ route('satuan.index') }}" class="btn btn-secondary">Batal</a>
</form>
@endsection
