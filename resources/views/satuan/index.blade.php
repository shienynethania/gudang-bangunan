@extends('layout')
@section('content')
<div class="d-flex justify-content-between mb-3">
  <h4>Data Satuan</h4>
  <a href="{{ route('satuan.create') }}" class="btn btn-primary">+ Tambah</a>
</div>
<table class="table table-bordered bg-white">
  <tr><th>ID</th><th>Nama Satuan</th><th>Status</th><th width="150">Aksi</th></tr>
  @foreach($data as $d)
  <tr>
    <td>{{ $d->idsatuan }}</td>
    <td>{{ $d->nama_satuan }}</td>
    <td>{{ $d->status ? 'Aktif' : 'Nonaktif' }}</td>
    <td>
      <a href="{{ route('satuan.edit', $d->idsatuan) }}" class="btn btn-sm btn-warning">Edit</a>
      <form action="{{ route('satuan.destroy', $d->idsatuan) }}" method="POST" class="d-inline"
            onsubmit="return confirm('Hapus data ini?')">
        @csrf @method('DELETE')
        <button class="btn btn-sm btn-danger">Hapus</button>
      </form>
    </td>
  </tr>
  @endforeach
</table>
@endsection
