<div class="form-group">
    <label class="control-label col-md-3 col-sm-3 col-xs-12">
        {{ $label ?? ''}}
        @if($is_required ?? '') <span class="required">*</span> @endif
    </label>
    <div class="col-md-9 col-sm-9 col-xs-12">
        <select class="select2_single form-control"
                @if($readonly ?? '') readonly @endif
                @if($disabled ?? '') disabled @endif
                @if($is_required ?? '') required @endif
                id="{{ $id ?? '' }}"
                name="{{ $name ?? '' }}"
                tabindex="-1">
            <option value="">...</option>
            @if(!empty($data))
                @foreach($data as $key => $item)
                    <option @if(isset($value) && ($value === $key)) selected @endif value="{{ $key }}">{{ $item }}</option>
                @endforeach
            @endif
        </select>
    </div>
</div>
