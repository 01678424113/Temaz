<div class="form-group">
    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="{{ $id ?? '' }}">
        {{ $label ?? ''}}
        @if($is_required ?? '') <span class="required">*</span> @endif
    </label>
    <div class="col-md-9 col-sm-9 col-xs-12">
        <img src="" id="{{ $id ?? '' }}" width="{{ $width ?? '200px' }}">
        <br />
        <input type="file"
               @if($readonly ?? '') readonly @endif
               @if($is_required ?? '') required @endif
               id="{{ $id ?? '' }}"
               name="{{ $name ?? '' }}"
               class="form-control">
    </div>
</div>

@push('scripts')
    <script>
        jQuery(document).ready(function ($) {
            //exec src image preview
            let srcDemo = $('img#{{ $id }}').attr('src'); //image demo default
            let allowType = ['image/jpeg', 'image/png', 'image/gif'];

            function readURL(input) {
                if (input.files && input.files[0]) {
                    let fileUpload = input.files[0];
                    if ($.inArray(fileUpload.type, allowType) < 0) {
                        $('img#{{ $id }}').attr('src', srcDemo); //show image default if not image type
                    }
                    else {
                        let reader = new FileReader();
                        reader.onload = function (e) {
                            $('img#{{ $id }}').attr('src', e.target.result);
                        };
                        reader.readAsDataURL(fileUpload);
                    }
                }
            }

            $("input[type=file]").change(function () {
                readURL(this);
            });
        });
    </script>
@endpush
