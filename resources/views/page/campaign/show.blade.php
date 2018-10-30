@extends('layouts.app-2')

@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Danh số điện thoại </h2>
                    <ul class="nav navbar-right panel_toolbox" style="display: flex;justify-content: flex-end;">
                        <li><a href="{{route('campaign.create')}}" style="color:#26B99A;"><i class="fa fa-plus"></i></a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>

                <div class="x_content">
                    <table id="datatable-buttons" class="table table-striped table-bordered">
                        <thead>
                        <tr>
                            <th></th>
                            <th>Thông tin</th>
                            <th>Nguồn</th>
                            <th>Ngày</th>
                            <th>Note</th>
                            <th>Check</th>
                            <th>Sale</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(!empty($data))
                            @foreach($data as $key => $value)
                                <tr>
                                    <td class="text-center">{{ $key + 1 }}</td>
                                    <td>
                                        {{ $value->name }}<br>
                                        {{ $value->email }}<br>
                                        {{ $value->phone }}
                                    </td>
                                    <td>{{ $value->source }}</td>
                                    <td>{{ $value->time }}</td>
                                    <td><textarea name="" id="" cols="30" class="form-control" rows="10">{{$value->note}}</textarea></td>
                                    <td>
                                       Số sale
                                    </td>
                                    <td>{!! $value->sale !!}</td>
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
        $('.select-category').change(function () {
            $('#search_category').submit();
        })
    </script>
@endsection
