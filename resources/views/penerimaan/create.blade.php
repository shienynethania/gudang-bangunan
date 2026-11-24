@extends('layout')
@section('content')
<h4>Penerimaan Baru - Langkah 1: Pilih Pengadaan (yang masih pending)</h4>
<form action="{{ route('penerimaan.store') }}" method="POST">
  @csrf
  <div class="mb-3">
    <label class="form-label">Pengadaan</label>
    <select name="idpengadaan" class="form-select" required>
      <option value="">-- pilih pengadaan --</option>
      @foreach($pengadaan as $p)
        <option value="{{ $p->idpengadaan }}" @selected(old('idpengadaan') == $p->idpengadaan)>
          #{{ $p->idpengadaan }} - {{ $p->nama_vendor }} - Rp {{ number_format($p->total_nilai, 0, ',', '.') }}
        </option>
      @endforeach
    </select>
  </div>
  <button class="btn btn-primary">Next &rarr;</button>
  <a href="{{ route('penerimaan.index') }}" class="btn btn-secondary">Batal</a>
</form>
@endsection
