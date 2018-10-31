@extends('layouts.app-2')

@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Danh số điện thoại </h2>
                    <ul class="nav navbar-right panel_toolbox" style="display: flex;justify-content: flex-end;">
                        <li><a href="{{route('phone.create')}}" style="color:#26B99A;"><i class="fa fa-plus"></i></a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>

                <div class="x_content">
                    <table id="datatable-buttons" class="table table-striped table-bordered">
                        <thead>
                        <tr>
                            <th></th>
                            <th style="max-width: 200px;">Thông tin</th>
                            <th style="max-width: 70px;">Sale</th>
                            <th style="max-width: 70px;">Ngày</th>
                            <th>Note</th>
                            <th style="max-width: 70px;">Check</th>
                            <th style="max-width: 50px;"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(!empty($data))
                            @foreach($data as $key => $value)
                                <tr>
                                    <td class="text-center">{{ $key + 1 }}</td>
                                    <td>
                                        Tên: {{ $value->name }}<br>
                                        Email: {{ $value->email }}<br>
                                        SDT: {{ $value->phone }}<br>
                                        Nguồn: {{ $value->source }}<br>
                                        Trang
                                        thái: {{($value->status == \App\Models\Phone::$FAIL) ? 'Thất bại' : ''}}{{($value->status == \App\Models\Phone::$NOT_PROCESS) ? 'Chưa hỗ trợ' : ''}}{{($value->status == \App\Models\Phone::$PROCESS) ? 'Chờ phản hồi' : ''}}{{($value->status == \App\Models\Phone::$SUCCESS) ? 'Thành công' : ''}}
                                    </td>
                                    <td>{{ $value->sale }}</td>
                                    <td>{{ $value->time }}</td>
                                    <form action="{{route('phone.updateNote',['id'=>$value->id])}}"
                                          id="data-{{$value->id}}" method="post">
                                        @csrf
                                        <td>

                                            <textarea name="note" id="" cols="30" class="form-control" rows="10"
                                                      onblur="changeNote({{$value->id}})"
                                                      style="width: 100%">{{$value->note}}</textarea>
                                        </td>
                                        <td>
                                            <select name="status" class="form-control select-status" onchange="changeNote({{$value->id}})">
                                                <option value="{{\App\Models\Phone::$FAIL}}" {{($value->status == \App\Models\Phone::$FAIL) ? 'selected' : ''}}>
                                                    Thất bại
                                                </option>
                                                <option value="{{\App\Models\Phone::$NOT_PROCESS}}" {{($value->status == \App\Models\Phone::$NOT_PROCESS) ? 'selected' : ''}}>
                                                    Chưa hỗ trợ
                                                </option>
                                                <option value="{{\App\Models\Phone::$PROCESS}}" {{($value->status == \App\Models\Phone::$PROCESS) ? 'selected' : ''}}>
                                                    Chờ phản hồi
                                                </option>
                                                <option value="{{\App\Models\Phone::$SUCCESS}}" {{($value->status == \App\Models\Phone::$SUCCESS) ? 'selected' : ''}}>
                                                    Thành công
                                                </option>
                                            </select>
                                        </td>
                                    </form>
                                    <td class="text-center">
                                        <a href="{{route('phone.edit',['id'=>$value->id])}}"
                                           class="btn btn-xs btn-info"><i
                                                    class="fa fa-edit"></i></a>
                                        <a href="{{route('phone.destroy',['id'=>$value->id])}}"
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
        function changeNote(id) {
            var url = $("#data-" + id).attr('action');
            $.ajax({
                url: url,
                method: 'post',
                data: $("#data-" + id).serialize(),
                success: function (data) {
                    if (data['status']) {
                        console.log(data['message']);
                    } else {
                        console.log(data['message']);
                    }
                }
            })
        }
    </script>
@endsection
