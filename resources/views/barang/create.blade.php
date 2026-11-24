<div class="mb-3">
    <label class="form-label">Vendor</label>
    <select name="idvendor" class="form-select @error('idvendor') is-invalid @enderror" required>
        <option value="">-- Pilih Vendor --</option>
        @foreach($vendor as $v)
            <option value="{{ $v->idvendor }}" {{ old('idvendor') == $v->idvendor ? 'selected' : '' }}>
                {{ $v->nama_vendor }}
            </option>
        @endforeach
    </select>
    @error('idvendor') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>
