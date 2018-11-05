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
                                    <h2>Sửa data sms</h2>
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
                                          action="{{route('sms-data.update',['id'=>$model->id])}}" method="post">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <div class="form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="">Số điện thoại
                                                        <span class="red"> *</span></label>
                                                    <div class="col-md-9 col-sm-6 col-xs-12 form-group has-feedback">
                                                        <input type="text" value="{{$model->phone}}" name="phone" required
                                                               class="form-control">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="">Trạng
                                                        thái
                                                        <span class="red"> *</span></label>
                                                    <div class="col-md-9 col-sm-6 col-xs-12 form-group has-feedback">
                                                        <select name="status" id="" class="form-control">
                                                            <option value="{{\App\Models\SmsData::$ACTIVE}}" {{($model->status == \App\Models\SmsData::$ACTIVE) ? 'selected' : ''}}>
                                                                Hoạt động
                                                            </option>
                                                            <option value="{{\App\Models\SmsData::$UNACTIVE}}" {{($model->status == \App\Models\SmsData::$UNACTIVE) ? 'selected' : ''}}>
                                                                Khóa
                                                            </option>
                                                        </select>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="col-md-6 col-sm-6 col-xs-12">

                                            </div>
                                        </div>
                                        <div class="ln_solid"></div>
                                        <div class="form-group">
                                            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                                <a href="{{ route('sms-data.index') }}"
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
