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
                                    <form action="{{ route('permission.update',['id'=>$model->id]) }}" method="post"
                                          class="form-horizontal form-label-left">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-6 col-sm-12 col-xs-12">
                                                @include('layouts.components.form-html.input-text', [
                                                    'label' => 'Tên quyền',
                                                    'name' => 'name',
                                                    'is_required' => true,
                                                    'value' =>$model->name,
                                                ])
                                            </div>
                                            <div class="col-md-6 col-sm-12 col-xs-12">
                                                @include('layouts.components.form-html.input-text', [
                                                    'label' => 'Tên chức năng',
                                                    'name' => 'note',
                                                    'is_required' => true,
                                                    'value' =>$model->note,
                                                ])
                                            </div>
                                        </div>
                                        <div class="ln_solid"></div>
                                        <div class="form-group">
                                            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                                <a href="{{ route('permission.index') }}" class="btn btn-primary">Quay
                                                    lại</a>
                                                <button type="submit" name="btnSubmit" class="btn btn-success">Lưu thay đổi
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
