@extends('layouts.app-2')

@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Danh sách số đã Import </h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
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
                            <th>Số điện thoại</th>
                            <th>Danh mục</th>
                            <th>Nguồn</th>
                            <th>Thời gian</th>
                            <th>Thời gian import</th>
                            <th>Link</th>
                            <th>Hành động</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(!empty($data))
                            @foreach($data as $key => $value)
                                @if(!in_array($value->id,$listNumberBought))
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $value->phone }}</td>
                                        <td>{{ $value->category_name }}</td>
                                        <td>{{ $value->source }}</td>
                                        <td>{{ $value->time }}</td>
                                        <td>{{ $value->time_import }}</td>
                                        <td><a target="_blank" href="{{$value->link}}">Click</a></td>
                                        <td>
                                            <a href="javascript:void(0)" data-id="{{$value->id}}"
                                               data-href="{{route('phone.doBuyNewNumberPhone',['id'=>$value->id])}}"
                                               class="btn btn-xs btn-success btn-buy-number"
                                               id="btn-buy-{{$value->id}}">Mua ngay</a>
                                        </td>
                                    </tr>
                                @endif
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
        $('.btn-buy-number').click(function () {
            var id = $(this).attr('data-id');
            var href = $(this).attr('data-href');
            $.ajax({
                url: href,
                type: 'GET'
            }).done(function (response) {
                if (response === '1') {
                    $("#btn-buy-" + id).addClass('disabled').html('Đã mua');
                    alert('Mua số thành công');
                } else {
                    alert('Đã xảy ra lỗi hoặc tài khoản không đủ. Vui lòng thử lại sau');
                }
                console.log(response)
            });
        })
    </script>
@endsection
