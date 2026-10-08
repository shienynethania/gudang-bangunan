<div class="mb-3">
  <label class="form-label">Persen (%)</label>
  <input type="number" step="0.01" name="persen" class="form-control"
         value="{{ old('persen', $row->persen ?? '') }}">
  @error('persen') <small class="text-danger">{{ $message }}</small> @enderror
</div>
<div class="mb-3">
  <label class="form-label">User</label>
  <select name="iduser" class="form-select">
    @foreach($user as $u)
      <option value="{{ $u->iduser }}" @selected(old('iduser', $row->iduser ?? '') == $u->iduser)>{{ $u->username }}</option>
    @endforeach
  </select>
  @error('iduser') <small class="text-danger">{{ $message }}</small> @enderror
</div>
<div class="mb-3">
  <label class="form-label">Status</label>
  <select name="status" class="form-select">
    <option value="1" @selected(old('status', $row->status ?? 1) == 1)>Aktif</option>
    <option value="0" @selected(old('status', $row->status ?? 1) == 0)>Nonaktif</option>
  </select>
  <small class="text-muted">Kalau diset Aktif, margin lain otomatis jadi Nonaktif.</small>
</div>
