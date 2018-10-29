@extends('layouts.app-2')

@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Danh chiến dịch </h2>
                    <ul class="nav navbar-right panel_toolbox" style="display: flex;justify-content: flex-end;">
                        <li><a href="{{route('campaign.create')}}" style="color:#26B99A;"><i  class="fa fa-plus"></i></a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <form action="{{route('campaign.index')}}" method="get" id="search_category">
                    <div class="row">
                        <div class="form-group">
                            <label class="control-label col-md-1 col-sm-3 col-xs-12">
                                Nhóm chiến dịch
                            </label>
                            <div class="col-md-5 col-sm-5 col-xs-12">
                                {!! Form::select('category_id', [0 => '...'] + $arrayCategories, $category_id, ['class' => 'form-control select2 select-category']) !!}
                            </div>
                        </div>
                    </div>
                </form>
                <hr>

                <div class="x_content">
                    <table id="datatable-buttons" class="table table-striped table-bordered">
                        <thead>
                        <tr>
                            <th>STT</th>
                            <th>Tên chiến dịch</th>
                            <th>Nhóm chiến dịch</th>
                            <th>Trạng thái</th>
                            <th>Thời gian tạo</th>
                            <th>Hành động</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(!empty($data))
                            @foreach($data as $key => $value)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $value->name }}</td>
                                    <td>{{ $value->category_name }}</td>
                                    <td><label for="" class="btn-success">{{ $value->status }}</label></td>
                                    <td>{{ $value->created_at }}</td>
                                    <td>
                                        <a href="{{route('campaign.edit',['id'=>$value->id])}}"
                                           class="btn btn-xs btn-info"><i
                                                    class="fa fa-edit"></i></a>
                                        <a href="{{route('campaign.destroy',['id'=>$value->id])}}"
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
