@extends('layout')
@section('content')
<h4>Tambah Margin Penjualan</h4>
<form action="{{ route('margin.store') }}" method="POST">
  @csrf
  @include('margin._form')
  <button class="btn btn-primary">Simpan</button>
  <a href="{{ route('margin.index') }}" class="btn btn-secondary">Batal</a>
</form>
@endsection
