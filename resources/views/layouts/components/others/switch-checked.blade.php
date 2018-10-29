<div class="">
    <label>
        <input type="checkbox"
               @if($readonly ?? '') readonly @endif
               class=""
               name="{{$name ?? ''}}"
               @if($is_checked ?? '') checked @endif/>
    </label>
</div>
