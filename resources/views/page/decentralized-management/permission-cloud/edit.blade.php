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
                                    <h2>Tạo quyền</h2>
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
                                    <form action="{{ route('permission-cloud.update',['id'=>$model->id]) }}" method="post"
                                          class="form-horizontal form-label-left">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                @include('layouts.components.form-html.input-text', [
                                                    'label' => 'Tên',
                                                    'name' => 'name',
                                                    'is_required' => true,
                                                    'value' =>$model->name,
                                                ])
                                                @include('layouts.components.form-html.input-text', [
                                                    'label' => 'Tên module',
                                                    'name' => 'module_name',
                                                    'is_required' => true,
                                                    'value' =>$model->module_name,
                                                ])
                                                @include('layouts.components.form-html.input-text', [
                                                   'label' => 'Controller',
                                                   'name' => 'controller',
                                                   'is_required' => true,
                                                   'value' =>$model->controller,
                                               ])
                                                @include('layouts.components.form-html.input-text', [
                                                   'label' => 'Controller name',
                                                   'name' => 'controller_name',
                                                   'is_required' => true,
                                                   'value' =>$model->controller,
                                               ])
                                            </div>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                @include('layouts.components.form-html.input-text', [
                                                    'label' => 'Action',
                                                    'name' => 'action',
                                                    'is_required' => true,
                                                    'value' =>$model->action,
                                                ])
                                                @include('layouts.components.form-html.input-text', [
                                                   'label' => 'Action name',
                                                   'name' => 'action_name',
                                                   'is_required' => true,
                                                   'value' =>$model->action_name,
                                               ])
                                                @include('layouts.components.form-html.input-text', [
                                                  'label' => 'Route',
                                                  'name' => 'route',
                                                  'is_required' => true,
                                                  'value' =>$model->route,
                                              ])
                                                @include('layouts.components.form-html.input-text', [
                                                  'label' => 'Order',
                                                  'name' => 'order',
                                                  'is_required' => true,
                                                  'value' =>$model->order,
                                              ])
                                            </div>
                                        </div>
                                        <div class="ln_solid"></div>
                                        <div class="form-group">
                                            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                                <a href="{{ route('permission-cloud.index') }}" class="btn btn-primary">Quay
                                                    lại</a>
                                                <button type="submit" name="btnSubmit" class="btn btn-success">Sửa
                                                    quyền
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
