@extends('layout')
@section('content')
<div class="d-flex justify-content-between mb-3">
  <h4>Data Margin Penjualan</h4>
  <a href="{{ route('margin.create') }}" class="btn btn-primary">+ Tambah</a>
</div>
<table class="table table-bordered bg-white">
  <tr>
    <th>ID</th><th>Persen</th><th>User</th><th>Status</th>
    <th>Dibuat</th><th>Diubah</th><th width="150">Aksi</th>
  </tr>
  @foreach($data as $d)
  <tr>
    <td>{{ $d->idmargin_penjualan }}</td>
    <td>{{ $d->persen }}%</td>
    <td>{{ $d->user->username ?? '-' }}</td>
    <td>{{ $d->status ? 'Aktif' : 'Nonaktif' }}</td>
    <td>{{ $d->created_at }}</td>
    <td>{{ $d->updated_at }}</td>
    <td>
      <a href="{{ route('margin.edit', $d->idmargin_penjualan) }}" class="btn btn-sm btn-warning">Edit</a>
      <form action="{{ route('margin.destroy', $d->idmargin_penjualan) }}" method="POST" class="d-inline"
            onsubmit="return confirm('Hapus data ini?')">
        @csrf @method('DELETE')
        <button class="btn btn-sm btn-danger">Hapus</button>
      </form>
    </td>
  </tr>
  @endforeach
</table>
@endsection
