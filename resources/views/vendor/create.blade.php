@extends('layout')

@section('content')
<h4>Tambah Vendor</h4>
<form action="{{ route('vendor.store') }}" method="POST">
  @csrf
  @include('vendor._form')
  <button class="btn btn-primary">Simpan</button>
  <a href="{{ route('vendor.index') }}" class="btn btn-secondary">Batal</a>
</form>
@endsection
