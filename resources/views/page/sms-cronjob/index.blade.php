@extends('layouts.app-2')

@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Danh sách cron job </h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>
                        <li class="dropdown">
                            <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" role="button"
                               aria-expanded="false"><i class="fa fa-wrench"></i></a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="#">Page 1</a>
                                </li>
                                <li><a href="#">Page 2</a>
                                </li>
                            </ul>
                        </li>
                        <li><a class="close-link"><i class="fa fa-close"></i></a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <table id="datatable-buttons" class="table table-striped table-bordered">
                        <thead>
                        <tr>
                            <th>STT</th>
                            <th>Name</th>
                            <th>Thời gian</th>
                            <th>Trạng thái</th>
                            <th>Ngày tạo</th>
                            <th>Hành động</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(!empty($data))
                            @foreach($data as $key => $value)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $value->name }}</td>
                                    <td>{{ $value->time }}</td>
                                    <td>
                                        @if($value->status == \App\Models\SmsCronjob::$ACTIVE)
                                            <a href="{{route('sms-cronjob.activeCronjobSMS',['id'=>$value->id])}}">
                                                <label
                                                        style="cursor: pointer" class="label label-info">Đang
                                                    chạy</label>
                                            </a>
                                        @elseif($value->status == \App\Models\SmsCronjob::$UNACTIVE)
                                            <a href="{{route('sms-cronjob.activeCronjobSMS',['id'=>$value->id])}}">
                                                <label
                                                        style="cursor: pointer" class="label label-danger">Không hoạt
                                                    động</label>
                                            </a>
                                        @endif
                                    </td>
                                    <td>{{ $value->created_at }}</td>
                                    <td>
                                        <a href="{{route('sms-cronjob.show',['id'=>$value->id])}}"
                                           class="btn btn-xs btn-success"><i
                                                    class="fa fa-eye"></i></a>
                                        <button type="button" data-toggle="modal" data-target="#myModal-{{$value->id}}"
                                                class="btn btn-xs btn-danger"><i
                                                    class="fa fa-times"></i></button>
                                        <div id="myModal-{{$value->id}}" class="modal fade" role="dialog">
                                            <div class="modal-dialog">
                                                <form action="{{route('sms-cronjob.destroy',['id'=>$value->id])}}"
                                                      method="get">
                                                    <!-- Modal content-->
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal">
                                                                &times;
                                                            </button>
                                                            <h4 class="modal-title">Xóa</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>Bạn muốn xóa vai trò này?</p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-default"
                                                                    data-dismiss="modal">Hủy
                                                            </button>
                                                            <button type="submit" class="btn btn-danger">Tiếp tục
                                                            </button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
