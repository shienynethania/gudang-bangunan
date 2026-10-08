@extends('layout')
@section('content')
<h4>Edit Satuan</h4>
<form action="{{ route('satuan.update', $row->idsatuan) }}" method="POST">
  @csrf @method('PUT')
  @include('satuan._form')
  <button class="btn btn-primary">Update</button>
  <a href="{{ route('satuan.index') }}" class="btn btn-secondary">Batal</a>
</form>
@endsection
