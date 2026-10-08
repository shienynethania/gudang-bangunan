<div class="mb-3">
  <label class="form-label">Nama Role</label>
  <input type="text" name="nama_role" class="form-control"
         value="{{ old('nama_role', $row->nama_role ?? '') }}">
  @error('nama_role') <small class="text-danger">{{ $message }}</small> @enderror
</div>
