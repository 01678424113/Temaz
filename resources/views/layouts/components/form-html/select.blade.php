<div class="form-group">
    <label class="control-label col-md-3 col-sm-3 col-xs-12">Select</label>
    <div class="col-md-9 col-sm-9 col-xs-12">
        <select name="{{$name}}" class="form-control"
                @if($readonly ?? '') readonly @endif
        >
            <option value="">{{$label}}</option>
            <option value="1">Admin</option>
            <option value="2">Quản lý</option>
        </select>
    </div>
</div>