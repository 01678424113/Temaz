<div class="form-group">
    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="{{ $id ?? '' }}">
        {{ $label ?? ''}}
        @if($is_required ?? '') <span class="required">*</span> @endif
    </label>
    <div class="col-md-9 col-sm-9 col-xs-12">
        @if(isset($data) && !empty($data))
            @foreach($data as $key => $item)
                <div class="radio">
                    <label>
                        <input type="radio"
                               @if($readonly ?? '') readonly @endif
                               @if($is_required ?? '') required @endif
                               id="{{ $id ?? '' }}"
                               value="{{ $key ?? '' }}"
                               name="{{ $name }}"
                               @if(isset($value) && ($value == $key)) checked @endif
                               class="flat" /> {{ $item }}
                    </label>
                </div>
            @endforeach
        @endif
    </div>
</div>
