@extends('layout')
@section('content')
<h4>Edit Role</h4>
<form action="{{ route('role.update', $row->idrole) }}" method="POST">
  @csrf @method('PUT')
  @include('role._form')
  <button class="btn btn-primary">Update</button>
  <a href="{{ route('role.index') }}" class="btn btn-secondary">Batal</a>
</form>
@endsection
