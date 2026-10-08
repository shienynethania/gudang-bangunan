<div class="mb-3">
  <label class="form-label">Nama Satuan</label>
  <input type="text" name="nama_satuan" class="form-control"
         value="{{ old('nama_satuan', $row->nama_satuan ?? '') }}">
  @error('nama_satuan') <small class="text-danger">{{ $message }}</small> @enderror
</div>
<div class="mb-3">
  <label class="form-label">Status</label>
  <select name="status" class="form-select">
    <option value="1" @selected(old('status', $row->status ?? 1) == 1)>Aktif</option>
    <option value="0" @selected(old('status', $row->status ?? 1) == 0)>Nonaktif</option>
  </select>
</div>
