<div class="mb-3">
  <label class="form-label">Username</label>
  <input type="text" name="username" class="form-control"
         value="{{ old('username', $row->username ?? '') }}">
  @error('username') <small class="text-danger">{{ $message }}</small> @enderror
</div>
<div class="mb-3">
  <label class="form-label">Password</label>
  <input type="password" name="password" class="form-control">
  @isset($row) <small class="text-muted">Kosongkan jika tidak diubah</small> @endisset
  @error('password') <br><small class="text-danger">{{ $message }}</small> @enderror
</div>
<div class="mb-3">
  <label class="form-label">Role</label>
  <select name="idrole" class="form-select">
    @foreach($role as $r)
      <option value="{{ $r->idrole }}" @selected(old('idrole', $row->idrole ?? '') == $r->idrole)>{{ $r->nama_role }}</option>
    @endforeach
  </select>
</div>
