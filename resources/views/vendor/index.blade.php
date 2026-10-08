@extends('layout')

@section('content')
<div class="d-flex justify-content-between mb-3">
  <h4>Data Vendor</h4>
  <a href="{{ route('vendor.create') }}" class="btn btn-primary">+ Tambah</a>
</div>

<table class="table table-bordered bg-white">
  <tr>
    <th>ID</th>
    <th>Nama Vendor</th>
    <th>Badan Hukum</th>
    <th>Status</th>
    <th width="150">Aksi</th>
  </tr>
  @foreach($data as $d)
  <tr>
    <td>{{ $d->idvendor }}</td>
    <td>{{ $d->nama_vendor }}</td>
    <td>{{ $d->badan_hukum == 'Y' ? 'Berbadan hukum' : 'Tidak berbadan hukum' }}</td>
    <td>{{ $d->status == 'A' ? 'Aktif' : 'Nonaktif' }}</td>
    <td>
      <a href="{{ route('vendor.edit', $d->idvendor) }}" class="btn btn-sm btn-warning">Edit</a>
      <form action="{{ route('vendor.destroy', $d->idvendor) }}" method="POST" class="d-inline"
            onsubmit="return confirm('Hapus data ini?')">
        @csrf
        @method('DELETE')
        <button class="btn btn-sm btn-danger">Hapus</button>
      </form>
    </td>
  </tr>
  @endforeach
</table>
@endsection
