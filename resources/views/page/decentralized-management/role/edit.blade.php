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
                                    <h2>Sửa vai trò</h2>
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
                                    <form action="{{ route('role.update',['id'=>$role->id]) }}" method="post"
                                          class="form-horizontal form-label-left">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                @include('layouts.components.form-html.input-text', [
                                                    'label' => 'Tên vai trò',
                                                    'name' => 'name',
                                                    'is_required' => true,
                                                    'value' =>$role->name,
                                                ])
                                                <div class="form-group">
                                                    <label class="col-md-3 col-sm-3 col-xs-12 control-label">Chọn
                                                        quyền</label>
                                                    <div class="col-md-9 col-sm-9 col-xs-12">
                                                        <div class="row">
                                                            @if(!empty($permissions))
                                                                @foreach($permissions as $permission)
                                                                    <div class="col-md-4">
                                                                        <div class="checkbox">
                                                                            <label class="">
                                                                                <div class="icheckbox_flat-green checked"
                                                                                     style="position: relative;"><input
                                                                                            name="permissions[]"
                                                                                            type="checkbox" class="flat"
                                                                                            {{($role->hasPermissionTo($permission->name)) ? 'checked' : ''}} value="{{$permission->id}}"
                                                                                            style="position: absolute; opacity: 0;">
                                                                                    <ins class="iCheck-helper"
                                                                                         style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins>
                                                                                </div> {{$permission->name}}
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="ln_solid"></div>
                                        <div class="form-group">
                                            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                                <a href="{{ route('role.index') }}" class="btn btn-primary">Quay
                                                    lại</a>
                                                <button type="submit" name="btnSubmit" class="btn btn-success">Lưu thay
                                                    đổi
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
