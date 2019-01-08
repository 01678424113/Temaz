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
                            <th>Cơntent</th>
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
                                    <td>{{ $value->content }}</td>
                                    <td>{{ $value->time }}</td>
                                    <td>
                                        @if($value->status == \App\Models\SmsCronjob::$ACTIVE)
                                            <label class="label label-info">Đang chạy</label>
                                        @elseif($value->status == \App\Models\SmsCronjob::$UNACTIVE)
                                            <label class="label label-danger">Không hoạt động</label>
                                        @endif
                                    </td>
                                    <td>{{ $value->created_at }}</td>
                                    <td>
                                        <a href="{{route('sms-data.show',['id'=>$value->id])}}" class="btn btn-xs btn-success"><i
                                                    class="fa fa-eye"></i></a>
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
