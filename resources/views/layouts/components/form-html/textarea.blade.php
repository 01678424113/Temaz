<div class="form-group">
    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="{{ $id ?? '' }}">
        {{ $label ?? ''}}
        @if($is_required ?? '') <span class="required">*</span> @endif
    </label>
    <div class="col-md-9 col-sm-9 col-xs-12">
        <textarea class="resizable_textarea form-control"
                  rows="5"
                  @if($readonly ?? '') readonly @endif
                  @if($is_required ?? '') required @endif
                  id="{{ $id ?? '' }}"
                  name="{{ $name ?? '' }}"
                  placeholder="{{ $placeholder ?? '' }}"
        >{{ $value ?? '' }}</textarea>
    </div>
</div>
