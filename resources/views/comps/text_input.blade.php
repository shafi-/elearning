<div class="form-group row">
  <label for="{{ $name }}" class="col-md-3 col-form-label text-md-right">{{ __($label ?? $name) }}</label>

  <div class="col-md-8">
      <input 
        id="{{ $name }}"
        type="{{ $name }}"
        class="form-control @error($name) is-invalid @enderror"
        name="{{ $name }}"
        value="{{ old($name, isset($value) ? $value : null) }}"
        required="{{ isset($required) ? $required : false }}"
        placeholder="Enter {{ $name }}">

      @error($name)
        <span class="invalid-feedback" role="alert">
          <strong>{{ $message }}</strong>
        </span>
      @enderror
  </div>
</div>
