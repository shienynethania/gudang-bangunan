@extends('layout')
@section('content')
<h4>Edit Margin Penjualan</h4>
<form action="{{ route('margin.update', $row->idmargin_penjualan) }}" method="POST">
  @csrf @method('PUT')
  @include('margin._form')
  <button class="btn btn-primary">Update</button>
  <a href="{{ route('margin.index') }}" class="btn btn-secondary">Batal</a>
</form>
@endsection
