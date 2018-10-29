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
                                    <h2>Cập nhật tài khoản</h2>
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
                                    <form class="form-horizontal form-label-left">
                                        <div class="row">
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                @include('layouts.components.form-html.input-text', [
                                                    'label' => 'Tên người dùng',
                                                    'name' => 'name',
                                                    'is_required' => true,
                                                    'value' => $model->name
                                                ])
                                                @include('layouts.components.form-html.input-email', [
                                                   'label' => 'Email',
                                                   'name' => 'email',
                                                   'is_required' => true,
                                                   'value' => $model->email
                                               ])
                                                @include('layouts.components.form-html.input-password', [
                                                  'label' => 'Mật khẩu mới',
                                                  'name' => 'password',
                                                  'is_required' => false,
                                                  'value' => ''
                                              ])
                                                @include('layouts.components.form-html.input-password', [
                                                    'label' => 'Nhập lại mật khẩu',
                                                    'name' => 'password_confirmation',
                                                    'is_required' => false,
                                                    'value' => ''
                                                ])
                                            </div>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                @include('layouts.components.form-html.switch-checked', [
                                               'label' => 'Trạng thái',
                                               'name' => 'status',
                                               'is_required' => true,
                                               'is_checked' => $model->status
                                           ])
                                                <div class="form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="">
                                                        Chọn vai trò:
                                                    </label>
                                                    <div class=" col-md-3 col-sm-6 col-xs-12">
                                                        {!! Form::select('roles[]', $roles, old('roles')??$model->getRoleNames(), ['class' => 'form-control select2','multiple']) !!}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="ln_solid"></div>
                                        <div class="form-group">
                                            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                                <a href="{{ route('user-admin.index') }}" class="btn btn-primary">Quay
                                                    lại</a>
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
