@extends('layouts.app-2')
@section('title', !empty($pageTitle) ? $pageTitle : 'Thêm nhóm quyền')
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
                                    <h2>Thêm nhóm quyền</h2>
                                    <ul class="nav navbar-right panel_toolbox">
                                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                                        <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                                    </ul>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
                                    <br/>
                                    <form name="frm_add_role" method="post" action="">
                                        {{ csrf_field() }}
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <?php if(!empty($error)){ ?>
                                                <div class="alert alert-danger alert-dismissible">
                                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                                    <h4>Cảnh báo!</h4> <?php echo $error; ?>
                                                </div>
                                                <?php } ?>
                                                <div class="form-group">
                                                    <label>Tên nhóm hành động</label>
                                                    <input type="text" name="name" class="form-control"
                                                           placeholder="{{ trans('messages.name') }}"
                                                           value="{{ !empty($post['name']) ? $post['name'] : '' }}"/>
                                                </div>
                                                <div class="form-group">
                                                    <label>Mô tả</label>
                                                    <textarea name="description" id="" cols="30" rows="3"
                                                              class="form-control">{{ !empty($post['description']) ? $post['description'] : '' }}</textarea>
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label style="width: 100%;">GÁN ACTION</label>
                                                    <div class="table-responsive">
                                                        <table class="table table-responsive table-striped">
                                                            <tr>
                                                                <td colspan="4"></td>
                                                            </tr>
                                                            @if(!empty($listPermission))
                                                                @foreach($listPermission as $module => $controllers)
                                                                    <tr>
                                                                        <th colspan="4" class="text-center text-uppercase"
                                                                            style="background: #e2e2e2">{{ $module }}</th>
                                                                    </tr>
                                                                    @php
                                                                        $count = 0;
                                                                    @endphp
                                                                    @foreach($controllers as $controller => $value)
                                                                        @php
                                                                            $controllerName = str_slug($controller, '_');
                                                                            $count ++;
                                                                            $numberValue = count($value);
                                                                            $numberRepeat = $numberValue % 3;
                                                                            $numberRow = $numberValue % 3 == 0 ? $numberValue / 3 : (int)($numberValue / 3) + 1;
                                                                            if($numberRow > 1){
                                                                                $numberRow = 'rowspan="'.$numberRow.'"';
                                                                            }
                                                                            $bg = $count % 2 == 0 ? 'style="background: #f9f9f9;"' : '';
                                                                        @endphp
                                                                        <tr {!! $bg !!}>
                                                                            <th {!! $numberRow !!}>
                                                                                <label style="cursor: pointer;">
                                                                                    <input type="checkbox" class="check_all"
                                                                                           data-class="check_{{ $controllerName }}"/>
                                                                                    {{ $controller }}
                                                                                </label>
                                                                            </th>
                                                                            @if(!empty($value))
                                                                                @php
                                                                                    $countKey = 0;
                                                                                @endphp
                                                                                @foreach($value as $action)
                                                                                    @php
                                                                                        $countKey ++;
                                                                                    @endphp
                                                                                    <td {!! $bg !!}>
                                                                                        <div class="checkbox no-margin">
                                                                                            <label>
                                                                                                <input class="check_{{ $controllerName }}"
                                                                                                       type="checkbox"
                                                                                                       {{ !empty($post['action'][$action->controller][$action->action]) ? 'checked' : '' }}
                                                                                                       name="action[{{ $action->controller }}][{{ $action->action }}]"/> {{ $action->action_name }}
                                                                                            </label>
                                                                                        </div>
                                                                                    </td>
                                                                                    @if($countKey % 3 == 0)
                                                                        </tr>
                                                                        <tr>
                                                                            @endif
                                                                            @endforeach
                                                                            @endif
                                                                            @if($numberRepeat > 0)
                                                                                {!! str_repeat('<td '.$bg.'></td>', 3 - $numberRepeat) !!}
                                                                            @endif
                                                                        </tr>
                                                                    @endforeach
                                                                @endforeach
                                                            @endif
                                                        </table>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <button class="btn btn-primary"><i
                                                                class="fa fa-check"></i> {{ trans('messages.submit') }}</button>
                                                </div>
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