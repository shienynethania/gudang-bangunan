@extends('layout')

@section('content')
<div class="d-flex justify-content-between mb-3">
  <h4>Data Barang</h4>
  <a href="{{ route('barang.create') }}" class="btn btn-primary">+ Tambah</a>
</div>

<table class="table table-bordered bg-white">
  <tr>
    <th>ID</th>
    <th>Jenis</th>
    <th>Nama Barang</th>
    <th>Satuan</th>
    <th>Harga</th>
    <th>Status</th>
    <th width="150">Aksi</th>
  </tr>
  @foreach($data as $d)
  <tr>
    <td>{{ $d->idbarang }}</td>
    <td>{{ $d->jenis }}</td>
    <td>{{ $d->nama }}</td>
    <td>{{ $d->satuan->nama_satuan ?? '-' }}</td>
    <td>Rp {{ number_format($d->harga, 0, ',', '.') }}</td>
    <td>{{ $d->status ? 'Aktif' : 'Nonaktif' }}</td>
    <td>
      <a href="{{ route('barang.edit', $d->idbarang) }}" class="btn btn-sm btn-warning">Edit</a>
      <form action="{{ route('barang.destroy', $d->idbarang) }}" method="POST" class="d-inline"
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
