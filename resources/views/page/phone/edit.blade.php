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
                                    <h2>Sửa data</h2>
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
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="">Chiến
                                                        dịch<span class="required">*</span></label>
                                                    <div class="col-md-9 col-sm-9 col-xs-12">
                                                        {!! Form::select('campaign_id',$campaigns, old('campaign_id'), ['class' => 'form-control select2']) !!}
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="">Tên
                                                        <span class="red"> *</span></label>
                                                    <div class="col-md-9 col-sm-6 col-xs-12 form-group has-feedback">
                                                        <input type="text" value="{{$model->name}}" name="name" required
                                                               class="form-control">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="">Email
                                                        <span class="red"> *</span></label>
                                                    <div class="col-md-9 col-sm-6 col-xs-12 form-group has-feedback">
                                                        <input type="email" value="{{$model->email}}" name="email"
                                                               required
                                                               class="form-control">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="">Điện
                                                        thoại <span class="red"> *</span></label>
                                                    <div class="col-md-9 col-sm-6 col-xs-12 form-group has-feedback">
                                                        <input type="text" value="{{$model->phone}}" name="phone"
                                                               required
                                                               class="form-control">
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="">IP
                                                    </label>
                                                    <div class="col-md-9 col-sm-6 col-xs-12 form-group has-feedback">
                                                        <input type="text" value="{{$model->ip}}" class="form-control"
                                                               name="ip"
                                                        >
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="">Nguồn
                                                        <span class="red"> *</span></label>
                                                    <div class="col-md-9 col-sm-6 col-xs-12 form-group has-feedback">
                                                        <input type="text" value="{{$model->source}}" name="source"
                                                               required
                                                               class="form-control">
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <div class="form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="">Sale
                                                        <span class="red"> *</span></label>
                                                    <div class="col-md-9 col-sm-6 col-xs-12 form-group has-feedback">
                                                        <input type="text" value="{{$model->sale}}" class="form-control"
                                                               name="sale" required
                                                        >
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="">Thời
                                                        gian nhập </label>
                                                    <div class="col-md-9 col-sm-6 col-xs-12 form-group has-feedback">
                                                        <input type="text" value="{{$model->time}}" class="form-control"
                                                               name="time"
                                                        >
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="">Trạng
                                                        thái
                                                        <span class="red"> *</span></label>
                                                    <div class="col-md-9 col-sm-6 col-xs-12 form-group has-feedback">
                                                        <select name="status" id="" class="form-control">
                                                            <option value="{{\App\Models\Phone::$FAIL}}" {{($model->status == \App\Models\Phone::$FAIL) ? 'selected' : ''}}>
                                                                Thất bại
                                                            </option>
                                                            <option value="{{\App\Models\Phone::$NOT_PROCESS}}" {{($model->status == \App\Models\Phone::$NOT_PROCESS) ? 'selected' : ''}}>
                                                                Chưa hỗ trợ
                                                            </option>
                                                            <option value="{{\App\Models\Phone::$PROCESS}}" {{($model->status == \App\Models\Phone::$PROCESS) ? 'selected' : ''}}>
                                                                Chờ phản hồi
                                                            </option>
                                                            <option value="{{\App\Models\Phone::$SUCCESS}}" {{($model->status == \App\Models\Phone::$SUCCESS) ? 'selected' : ''}}>
                                                                Thành công
                                                            </option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="">Note
                                                    </label>
                                                    <div class="col-md-9 col-sm-6 col-xs-12 form-group has-feedback">
                                                        <textarea name="note" id="" cols="30" rows="10"
                                                                  class="form-control">{{$model->note}}</textarea>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="ln_solid"></div>
                                        <div class="form-group">
                                            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                                <a href="{{ route('campaign.show',['id'=>$model->campaign_id]) }}"
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
