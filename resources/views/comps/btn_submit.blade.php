<div class="form-group row mb-0">
  <div class="col-md-8 offset-md-4">
    <button type="submit" class="btn btn-outline-primary">
      {{ __($btn_submit_txt ?? 'Save') }}
    </button>
    <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">
      {{ __($btn_cancel_txt ?? 'Cancel') }}
    </a>
  </div>
</div>
