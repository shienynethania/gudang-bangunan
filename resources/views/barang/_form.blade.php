<div class="mb-3">
  <label class="form-label">Jenis</label>
  <select name="jenis" class="form-select">
    @foreach(['S' => 'S - Material dasar', 'B' => 'B - Besi & pipa', 'C' => 'C - Cat & pelapis', 'P' => 'P - Perlengkapan', 'K' => 'K - Keramik & papan'] as $kode => $label)
      <option value="{{ $kode }}" @selected(old('jenis', $row->jenis ?? 'S') == $kode)>{{ $label }}</option>
    @endforeach
  </select>
  @error('jenis') <small class="text-danger">{{ $message }}</small> @enderror
</div>

<div class="mb-3">
  <label class="form-label">Nama Barang</label>
  <input type="text" name="nama" class="form-control"
         value="{{ old('nama', $row->nama ?? '') }}">
  @error('nama') <small class="text-danger">{{ $message }}</small> @enderror
</div>

<div class="mb-3">
  <label class="form-label">Satuan</label>
  <select name="idsatuan" class="form-select">
    @foreach($satuan as $s)
      <option value="{{ $s->idsatuan }}" @selected(old('idsatuan', $row->idsatuan ?? '') == $s->idsatuan)>
        {{ $s->nama_satuan }}
      </option>
    @endforeach
  </select>
  @error('idsatuan') <small class="text-danger">{{ $message }}</small> @enderror
</div>

<div class="mb-3">
  <label class="form-label">Harga (Rp)</label>
  <input type="number" name="harga" class="form-control" min="0"
         value="{{ old('harga', $row->harga ?? '') }}">
  @error('harga') <small class="text-danger">{{ $message }}</small> @enderror
</div>

<div class="mb-3">
  <label class="form-label">Status</label>
  <select name="status" class="form-select">
    <option value="1" @selected(old('status', $row->status ?? 1) == 1)>Aktif</option>
    <option value="0" @selected(old('status', $row->status ?? 1) == 0)>Nonaktif</option>
  </select>
  @error('status') <small class="text-danger">{{ $message }}</small> @enderror
</div>
