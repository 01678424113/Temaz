@extends('layouts.app-2')

@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Danh sách giao dịch </h2>
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
                            <th>Mã giao dịch</th>
                            <th>Tên user</th>
                            <th>Loại giao dịch</th>
                            <th>Số tiền</th>
                            <th>Thời gian giao dịch</th>
                            <th>Trạng thái</th>
                            <th>Hành động</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(!empty($data))
                            @foreach($data as $key => $value)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $value->transaction_id }}</td>
                                    <td>{{ $value->user_name }}</td>
                                    <td>
                                        @if($value->type == \App\Models\Transaction::$TYPE_PLUS)
                                            <label class="label label-success">Cộng tiền</label>
                                        @elseif($value->type == \App\Models\Transaction::$TYPE_MINUS)
                                            <label class="label label-danger">Trừ tiền</label>
                                        @endif
                                    </td>
                                    <td>{{ number_format($value->amount) }}</td>
                                    <td>{{ date('H:i:s d/m/Y', strtotime($value->created_at)) }}</td>
                                    <td>
                                        @if($value->status == \App\Models\Transaction::$STATUS_SUCCESS)
                                            <label class="label label-success">Thành công</label>
                                        @elseif($value->status == \App\Models\Transaction::$STATUS_PENDING)
                                            <label class="label label-warning">Đang xử lý</label>
                                        @elseif($value->status == \App\Models\Transaction::$STATUS_FAILURE)
                                            <label class="label label-danger">Thất bại</label>
                                        @elseif($value->status == \App\Models\Transaction::$STATUS_CANCEL)
                                            <label class="label label-default">Hủy bỏ</label>
                                        @elseif($value->status == \App\Models\Transaction::$STATUS_INIT)
                                            <label class="label label-default">Mới tạo</label>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{route('transaction-manager.show',['id'=>$value->id])}}" class="btn btn-xs btn-success"><i
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
