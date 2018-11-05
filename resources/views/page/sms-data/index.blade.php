@extends('layouts.app-2')

@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Danh sách data đã Import </h2>
                    <ul class="nav navbar-right panel_toolbox" style="display: flex;justify-content: flex-end;">
                        <li><a href="{{route('sms-data.create')}}" style="color:#26B99A;"><i class="fa fa-plus"></i></a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <table id="datatable-buttons" class="table table-striped table-bordered">
                        <thead>
                        <tr>
                            <th>STT</th>
                            <th>Số điện thoại</th>
                            <th>Thời gian</th>
                            <th style="max-width: 70px">Trạng thái</th>
                            <th style="max-width: 70px">Hành động</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(!empty($data))
                            @foreach($data as $key => $value)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $value->phone }}</td>
                                    <td>{{ $value->created_at }}</td>
                                    <td>
                                        @if($value->status == \App\Models\SmsData::$ACTIVE)
                                            <label for="" class="label label-success">Hoạt dộng</label>
                                        @else
                                            <label for="" class="label label-default">Khóa</label>
                                        @endif
                                    </td>
                                    <td>
                                        <form action="http://rest.esms.vn/MainService.svc/json/SendMultipleMessage_V4_post/"
                                              id="form-{{$value->id}}" method="post">
                                            <input type="hidden" name="APIKEY" value="EA7C58393611CB9A6C49C9B81BFD71">
                                            <input type="hidden" name="SECRETKEY"
                                                   value="E24422D0EC29026467A5919FDB2B0E">
                                            <input type="hidden" name="CONTENT" value="Hello">
                                            <input type="hidden" name="SMSTYPE" value="2">
                                            <input type="hidden" name="BRANDNAME" value="QCAO_ONLINE">
                                            <input type="hidden" name="PHONE" value="{{ $value->phone }}">
                                            <button type="button" data-id="{{$value->id}}"
                                                    class="btn btn-xs btn-success btn-send"><i
                                                        class="fa fa-send"></i></button>
                                        </form>

                                        <a href="{{route('sms-data.edit',['id'=>$value->id])}}"
                                           class="btn btn-xs btn-info"><i
                                                    class="fa fa-edit"></i></a>
                                        <a href="{{route('sms-data.destroy',['id'=>$value->id])}}"
                                           class="btn btn-xs btn-danger"><i
                                                    class="fa fa-times"></i></a>
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
@section('script')
    <script>
        $('.btn-send').click(function () {
            var id = $(this).attr('data-id');
            var url = $("#form-" + id).attr('action');
            $.ajax({
                url: url,
                method: 'post',
                data: $("#form-" + id).serialize(),
                success: function (data) {
                    if (data.CodeResult == 100) {
                        alert('Gửi tin nhắn thành công');
                    } else {
                        alert('Đã xảy ra lỗi');
                    }
                }
            })
        })
    </script>
@endsection
