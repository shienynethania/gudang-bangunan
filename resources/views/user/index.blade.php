@extends('layout')
@section('content')
<div class="d-flex justify-content-between mb-3">
  <h4>Data User</h4>
  <a href="{{ route('user.create') }}" class="btn btn-primary">+ Tambah</a>
</div>
<table class="table table-bordered bg-white">
  <tr><th>ID</th><th>Username</th><th>Role</th><th width="150">Aksi</th></tr>
  @foreach($data as $d)
  <tr>
    <td>{{ $d->iduser }}</td>
    <td>{{ $d->username }}</td>
    <td>{{ $d->role->nama_role }}</td>
    <td>
      <a href="{{ route('user.edit', $d->iduser) }}" class="btn btn-sm btn-warning">Edit</a>
      <form action="{{ route('user.destroy', $d->iduser) }}" method="POST" class="d-inline"
            onsubmit="return confirm('Hapus data ini?')">
        @csrf @method('DELETE')
        <button class="btn btn-sm btn-danger">Hapus</button>
      </form>
    </td>
  </tr>
  @endforeach
</table>
@endsection
