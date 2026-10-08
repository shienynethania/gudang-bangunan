@extends('layout')
@section('content')
<h4>Edit User</h4>
<form action="{{ route('user.update', $row->iduser) }}" method="POST">
  @csrf @method('PUT')
  @include('user._form')
  <button class="btn btn-primary">Update</button>
  <a href="{{ route('user.index') }}" class="btn btn-secondary">Batal</a>
</form>
@endsection
