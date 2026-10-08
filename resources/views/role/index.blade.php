@extends('layout')
@section('content')
<div class="d-flex justify-content-between mb-3">
  <h4>Data Role</h4>
  <a href="{{ route('role.create') }}" class="btn btn-primary">+ Tambah</a>
</div>
<table class="table table-bordered bg-white">
  <tr><th>ID</th><th>Nama Role</th><th width="150">Aksi</th></tr>
  @foreach($data as $d)
  <tr>
    <td>{{ $d->idrole }}</td>
    <td>{{ $d->nama_role }}</td>
    <td>
      <a href="{{ route('role.edit', $d->idrole) }}" class="btn btn-sm btn-warning">Edit</a>
      <form action="{{ route('role.destroy', $d->idrole) }}" method="POST" class="d-inline"
            onsubmit="return confirm('Hapus data ini?')">
        @csrf @method('DELETE')
        <button class="btn btn-sm btn-danger">Hapus</button>
      </form>
    </td>
  </tr>
  @endforeach
</table>
@endsection
