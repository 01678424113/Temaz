@extends('layouts.app-2')

@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Danh sách số đã mua </h2>
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
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>
                                        <input type="text" class="form-control" value="{{$value->phone}}" id="phone-{{$value->id}}">
                                    </td>
                                    <td>{{ $value->category_name }}</td>
                                    <td>{{ $value->source }}</td>
                                    <td>{{ $value->time }}</td>
                                    <td>{{ $value->time_import }}</td>
                                    <td><a target="_blank" href="{{$value->link}}">Click</a></td>
                                    <td>
                                        <button class="btn btn-info" onclick="copy({{$value->id}})">Copy</button>
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
        function copy(id) {
            var copyText = document.getElementById("phone-" + id);
            copyText.select();
            document.execCommand("copy");
            alert("Đã copy: " + copyText.value);
        }
    </script>
@endsection
