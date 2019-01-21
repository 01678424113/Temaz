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
                                {!! Form::select('category_id', [0 => 'Tất cả'] + $arrayCategories, $category_id, ['class' => 'form-control select2 select-category']) !!}
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
                            <th>Dịch vụ</th>
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
                                    <td>
                                        <input type="checkbox"
                                               @if($value->status == 1) checked @endif
                                               class=""/>
                                    </td>
                                    <td>{{ $value->created_at }}</td>
                                    <td>
                                        <a href="{{route('Home_import')}}"
                                           class="btn btn-xs btn-success"><i
                                                    class="fa fa-upload"></i></a>
                                        <a href="{{route('campaign.show',['id'=>$value->id])}}"
                                           class="btn btn-xs btn-info"><i
                                                    class="fa fa-eye"></i></a>
                                        <a href="{{route('campaign.edit',['id'=>$value->id])}}"
                                           class="btn btn-xs btn-info"><i
                                                    class="fa fa-edit"></i></a>
                                        <button type="button" data-toggle="modal" data-target="#myModal-{{$value->id}}"
                                           class="btn btn-xs btn-danger"><i
                                                    class="fa fa-times"></i></button>
                                        <div id="myModal-{{$value->id}}" class="modal fade" role="dialog">
                                            <div class="modal-dialog">
                                                <form action="{{route('campaign.destroy',['id'=>$value->id])}}" method="get">
                                                    <!-- Modal content-->
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                            <h4 class="modal-title">Xóa</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>Bạn muốn xóa chiến dịch này?</p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-default" data-dismiss="modal">Hủy</button>
                                                            <button type="submit" class="btn btn-danger">Tiếp tục</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>

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
    <!-- Modal -->
@endsection
@section('script')
    <script>
        $('.select-category').change(function () {
            $('#search_category').submit();
        })
    </script>
@endsection
