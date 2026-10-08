@extends('layout')

@section('content')
<h4>Edit Vendor</h4>
<form action="{{ route('vendor.update', $row->idvendor) }}" method="POST">
  @csrf
  @method('PUT')
  @include('vendor._form')
  <button class="btn btn-primary">Update</button>
  <a href="{{ route('vendor.index') }}" class="btn btn-secondary">Batal</a>
</form>
@endsection
