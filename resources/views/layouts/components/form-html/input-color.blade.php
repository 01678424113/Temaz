<div class="form-group">
    @if(isset($type) && $type == 'default')
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="{{ $id ?? '' }}">
            {{ $label ?? ''}}
            @if($is_required ?? '') <span class="required">*</span> @endif
        </label>
        <div class="col-md-9 col-sm-9 col-xs-12">
            <input type="text"
                   @if($readonly ?? '') readonly @endif
                   @if($is_required ?? '') required @endif
                   id="{{ $id ?? '' }}"
                   name="{{ $name ?? '' }}"
                   value="{{ $value ?? '' }}"
                   placeholder="{{ $placeholder ?? '' }}"
                   class="demo1 form-control"/>
        </div>
    @else
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="demo_forceformat">
                {{ $label ?? ''}}
                @if($is_required ?? '') <span class="required">*</span> @endif
            </label>
            <div class="col-md-9 col-sm-9 col-xs-12">
                <input type="text"
                       @if($readonly ?? '') readonly @endif
                       @if($is_required ?? '') required @endif
                       id="demo_forceformat"
                       name="{{ $name ?? '' }}"
                       value="{{ $value ?? '' }}"
                       placeholder="{{ $placeholder ?? '' }}"
                       class="form-control colorpicker-element"
                       data-horizontal="true">
            </div>
        </div>
    @endif
</div>
@push('style_default')
    <!-- Bootstrap Colorpicker -->
    <link href="assets/vendors/mjolnic-bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css" rel="stylesheet">
@endpush

@push('script_default')
    <!-- Bootstrap Colorpicker -->
    <script src="assets/vendors/mjolnic-bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>
@endpush
