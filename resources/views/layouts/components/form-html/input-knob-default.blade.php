<div class="form-group">
    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="{{ $id ?? '' }}">
        {{ $label ?? ''}}
        @if($is_required ?? '') <span class="required">*</span> @endif
    </label>
    <div class="col-md-9 col-sm-9 col-xs-12">
        <input class="knob"
               data-width="{{ $width ?? 100 }}"
               data-height="{{ $height ?? 120 }}"
               data-min="{{ $min ?? 0 }}"
               data-displayPrevious=true
               data-fgColor="{{ $color ?? '#26B99A' }}"
               @if($readonly ?? '') readonly @endif
               @if($is_required ?? '') required @endif
               id="{{ $id ?? '' }}"
               name="{{ $name ?? '' }}"
               value="{{ $value ?? 1 }}" />
    </div>
</div>

@push('script_default')
    <!-- jQuery Knob -->
    <script src="assets/vendors/jquery-knob/dist/jquery.knob.min.js"></script>
@endpush
