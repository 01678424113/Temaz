@extends('layouts.app-2')

@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_content">
                    <div class="clearfix"></div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="x_panel">
                                <div class="x_title">
                                    <h2>Sửa số điện thoại</h2>
                                    <ul class="nav navbar-right panel_toolbox">
                                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                        </li>
                                        <li><a class="close-link"><i class="fa fa-close"></i></a>
                                        </li>
                                    </ul>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
                                    <br/>
                                    <form class="form-horizontal form-label-left"
                                          action="{{route('phone.update',['id'=>$model->id])}}" method="post">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <div class="form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="">Số
                                                        điện thoại <span class="red"> *</span></label>
                                                    <div class="col-md-9 col-sm-6 col-xs-12 form-group has-feedback">
                                                        <input type="text" value="{{$model->phone}}"
                                                               class="form-control" disabled>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="">IP
                                                        <span class="red"> *</span></label>
                                                    <div class="col-md-9 col-sm-6 col-xs-12 form-group has-feedback">
                                                        <input type="text" value="{{$model->ip}}" class="form-control"
                                                               disabled>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="">Nguồn
                                                        <span class="red"> *</span></label>
                                                    <div class="col-md-9 col-sm-6 col-xs-12 form-group has-feedback">
                                                        <input type="text" value="{{$model->source}}"
                                                               class="form-control" disabled>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="">Thời
                                                        gian nhập <span class="red"> *</span></label>
                                                    <div class="col-md-9 col-sm-6 col-xs-12 form-group has-feedback">
                                                        <input type="text" value="{{$model->time}}" class="form-control"
                                                               disabled>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="">Đường
                                                        dẫn <span class="red"> *</span></label>
                                                    <div class="col-md-9 col-sm-6 col-xs-12 form-group has-feedback">
                                                        <input type="text" value="{{$model->link}}" class="form-control"
                                                               disabled>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <div class="form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="">Chọn
                                                        danh mục <span class="red"> *</span></label>
                                                    <div class="col-md-9 col-sm-6 col-xs-12 form-group has-feedback">
                                                        <select name="category_id"
                                                                class="form-control select2"
                                                                id="">
                                                            @if(!empty($categories))
                                                                @foreach($categories as $key=>$category)
                                                                    <option value="{{$key}}" {{($key == $model->category_id) ? 'selected' : ''}}>{{$category}}</option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="ln_solid"></div>
                                        <div class="form-group">
                                            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">

                                                <a href="{{ route('phone.index') }}"
                                                   class="btn btn-primary">Quay lại</a>
                                                <button type="submit"
                                                        class="btn btn-success">Update
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
