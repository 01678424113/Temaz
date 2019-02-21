@extends('layouts.app-2')

@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Danh khách hàng </h2>
                    <ul class="nav navbar-right panel_toolbox" style="display: flex;justify-content: flex-end;">
                        <li><a href="{{route('campaign.create')}}" style="color:#26B99A;"><i class="fa fa-plus"></i></a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>

                <form action="{{route('VayNongOnline.customer')}}" method="get" id="search_campaign">
                    <div class="row">
                        <input type="hidden" name="table" value="customer_details">
                        <input type="hidden" name="from" value="0">
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select name="where" id="" class="form-control select-campaign">
                                <option @if(!empty($where)) selected
                                        @endif value="all">Chọn Campaign
                                </option>
                                @if(!empty($campaigns))
                                    @foreach($campaigns as $campaign)
                                        <option @if($where == $campaign->id) selected
                                                @endif value="{{$campaign->id}}">{{$campaign->name}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <select name="address" id="" class="form-control select-address">
                                @if(!empty($address))
                                    <option value="">Chọn tỉnh thành</option>
                                    <option value="ha noi" {{($address == 'ha noi') ? 'selected' : ''}}>Hà Nội</option>
                                    <option value="ho chi minh" {{($address == 'ho chi minh') ? 'selected' : ''}}>TP Hồ Chí Minh</option>
                                @else
                                    <option value="" selected>Chọn tỉnh thành</option>
                                    <option value="ha noi">Hà Nội</option>
                                    <option value="ho chi minh">TP Hồ Chí Minh</option>
                                @endif
                            </select>
                        </div>
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <select name="to" id="" class="form-control select-to">
                                <option @if($to == 500) selected
                                        @endif value="500">500 data mới nhất
                                </option>
                                <option @if($to != 500) selected
                                        @endif value="all">Hiện tất cả
                                </option>
                            </select>
                        </div>
                    </div>
                </form>

                <hr>

                <div class="x_content">
                    <table id="datatable-buttons" class="table table-striped table-bordered">
                        <thead>
                        <tr>
                            <th>STT</th>
                            <th>Tên</th>
                            <th>Chiến dịch</th>
                            <th>SDT</th>
                            <th>Tuổi</th>
                            <th>Giới tính</th>
                            <th>Địa chỉ</th>
                            <th>Email</th>
                            <th>Số tiền</th>
                            <th>Thời gian</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(!empty($data))
                            @foreach($data as $key => $value)
                                <form action="" id="customer_{{$value->id}}">
                                    <input type="hidden" data-id="{{$value->id}}" name="id" value="{{ $value->age }}">
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $value->name }}</td>
                                        <td>{{ $value->campaign_name }}</td>
                                        <td>{{ $value->phone }}</td>
                                        <td><input type="text" data-id="{{$value->id}}" id="age_{{$value->id}}"
                                                   name="age_{{$value->id}}"
                                                   value="{{ $value->age }}"></td>
                                        <td>
                                            <select id="gender_{{$value->id}}" name="gender_{{$value->id}}"
                                                    data-id="{{$value->id}}" id="">
                                                <option @if($value->gender == 0) selected @endif value="0">Nam</option>
                                                <option @if($value->gender == 1) selected @endif value="1">Nữ</option>
                                            </select>
                                        </td>
                                        <td><input type="text" data-id="{{$value->id}}" id="address_{{$value->id}}"
                                                   name="address_{{$value->id}}"
                                                   value="{{ $value->address }}"></td>
                                        <td><input type="email" data-id="{{$value->id}}" id="email_{{$value->id}}"
                                                   name="email_{{$value->id}}"
                                                   value="{{ $value->email }}"></td>
                                        <td><input type="text" data-id="{{$value->id}}"
                                                   id="sotienmuonvay_{{$value->id}}" name="sotienmuonvay_{{$value->id}}"
                                                   value="{{ $value->sotienmuonvay }}"></td>
                                        <td>{{ $value->create_time }}</td>
                                    </tr>
                                </form>
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
        $('input').change(function () {
            var id = $(this).attr('data-id');
            var gender = $('#gender' + id).val();
            var age = $('#age_' + id).val();
            var address = $('#address_' + id).val();
            var email = $('#email_' + id).val();
            var sotienmuonvay = $('#sotienmuonvay_' + id).val();
            $.get("https://vaynongonline.com/api/api-temaz-edit.php?id=" + id + "&age=" + age + "&gender=" + gender + "&address=" + address + "&email=" + email + "&sotienmuonvay=" + sotienmuonvay, function (data) {
                alert("Load was performed.");
            });
        });
        $('.select-campaign').change(function () {
            $('#search_campaign').submit();
        });
        $('.select-to').change(function () {
            $('#search_campaign').submit();
        });
        $('.select-address').change(function () {
            $('#search_campaign').submit();
        });

    </script>
@endsection
