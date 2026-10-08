@extends('layout')

@section('content')
<h4>Edit Barang</h4>
<form action="{{ route('barang.update', $row->idbarang) }}" method="POST">
  @csrf
  @method('PUT')
  @include('barang._form')
  <button class="btn btn-primary">Update</button>
  <a href="{{ route('barang.index') }}" class="btn btn-secondary">Batal</a>
</form>
@endsection
