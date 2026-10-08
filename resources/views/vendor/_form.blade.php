<div class="mb-3">
  <label class="form-label">Nama Vendor</label>
  <input type="text" name="nama_vendor" class="form-control"
         value="{{ old('nama_vendor', $row->nama_vendor ?? '') }}">
  @error('nama_vendor') <small class="text-danger">{{ $message }}</small> @enderror
</div>

<div class="mb-3">
  <label class="form-label">Badan Hukum</label>
  <select name="badan_hukum" class="form-select">
    <option value="Y" @selected(old('badan_hukum', $row->badan_hukum ?? 'Y') == 'Y')>Berbadan hukum</option>
    <option value="T" @selected(old('badan_hukum', $row->badan_hukum ?? 'Y') == 'T')>Tidak berbadan hukum</option>
  </select>
  @error('badan_hukum') <small class="text-danger">{{ $message }}</small> @enderror
</div>

<div class="mb-3">
  <label class="form-label">Status</label>
  <select name="status" class="form-select">
    <option value="A" @selected(old('status', $row->status ?? 'A') == 'A')>Aktif</option>
    <option value="N" @selected(old('status', $row->status ?? 'A') == 'N')>Nonaktif</option>
  </select>
  @error('status') <small class="text-danger">{{ $message }}</small> @enderror
</div>
