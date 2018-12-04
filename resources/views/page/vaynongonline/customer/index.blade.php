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
                        <input type="hidden" name="where" value="1">
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select name="where" id="" class="form-control select-campaign">
                                <option @if(!empty($where)) selected
                                        @endif value="">Chọn Campaign</option>
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
                                <option value="">Chọn tỉnh thành</option>
                                <option value="ha noi">Hà Nội</option>
                                <option value="ho chi minh">TP Hồ Chí Minh</option>
                            </select>
                        </div>
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <select name="to" id="" class="form-control select-to">
                                <option @if($to == 1000) selected
                                        @endif value="1000">1000 data mới nhất</option>
                                <option @if($to != 1000) selected
                                        @endif value="all">Hiện tất cả</option>
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
                        </tr>
                        </thead>
                        <tbody>
                        @if(!empty($data))
                            @foreach($data as $key => $value)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $value->name }}</td>
                                    <td>{{ $value->campaign_name }}</td>
                                    <td>{{ $value->phone }}</td>
                                    <td>{{ $value->age }}</td>
                                    <td>{{ $value->gender }}</td>
                                    <td>{{ $value->address }}</td>
                                    <td>{{ $value->email }}</td>
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
        $('.select-campaign').change(function () {
            $('#search_campaign').submit();
        })
        $('.select-to').change(function () {
            $('#search_campaign').submit();
        })
        $('.select-address').change(function () {
            $('#search_campaign').submit();
        })
    </script>
@endsection
