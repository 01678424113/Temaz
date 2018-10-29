<div class="form-group">
    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="{{ $id ?? '' }}">
        {{ $label ?? ''}}
        @if($is_required ?? '') <span class="required">*</span> @endif
    </label>
    <div class="col-md-9 col-sm-9 col-xs-12">
        <input type="number"
               @if($readonly ?? '') readonly @endif
               @if($disabled ?? '') disabled @endif
               @if($is_required ?? '') required @endif
               id="{{ $id ?? '' }}"
               name="{{ $name ?? '' }}"
               value="{{ $value ?? '' }}"
               placeholder="{{ $placeholder ?? '' }}"
               min="{{ $min ?? 0 }}"
               max="{{ $max ?? 10000000000 }}"
               class="form-control">
    </div>
</div>
