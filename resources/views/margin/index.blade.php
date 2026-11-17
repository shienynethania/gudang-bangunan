@extends('layout')

@section('content')
<div class="d-flex justify-content-between mb-3">
  <h4>Data Margin Penjualan</h4>
  <a href="{{ route('margin.create') }}" class="btn btn-primary">+ Tambah</a>
</div>

<table class="table table-bordered bg-white">
  <tr>
    <th>ID</th>
    <th>Persen</th>
    <th>Status</th>
    <th>Dibuat Oleh</th>
    <th>Dibuat</th>
    <th>Diubah</th>
    <th width="230">Aksi</th>
  </tr>
  @foreach($data as $d)
  <tr>
    <td>{{ $d->idmargin_penjualan }}</td>
    <td>{{ $d->persen }}%</td>
    <td>{{ $d->status_text }}</td>
    <td>{{ $d->dibuat_oleh }}</td>
    <td>{{ $d->created_at }}</td>
    <td>{{ $d->updated_at }}</td>
    <td>
      @if($d->status_angka != 1)
      <form action="{{ route('margin.aktif', $d->idmargin_penjualan) }}" method="POST" class="d-inline">
        @csrf
        <button class="btn btn-sm btn-success">Aktifkan</button>
      </form>
      @endif
      <a href="{{ route('margin.edit', $d->idmargin_penjualan) }}" class="btn btn-sm btn-warning">Edit</a>
      <form action="{{ route('margin.destroy', $d->idmargin_penjualan) }}" method="POST" class="d-inline"
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
