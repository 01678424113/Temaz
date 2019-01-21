@extends('layouts.app-2')

@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Danh sách tài khoản </h2>
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
                    <table id="datatable" style="width:100%" class="table table-striped table-bordered">
                        <thead>
                        <tr>
                            <th>STT</th>
                            <th>Tên nhân viên</th>
                            <th>Email</th>
                            <th>Nhóm chiến dịch</th>
                            <th>Vai trò</th>
                            <th>Trạng thái</th>
                            <th>Hành động</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $i = 1; ?>
                        @foreach($data as $item)
                            <tr>
                                <td>{{ $i }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->email }}</td>
                                <td>{{ $item->category_name }}</td>
                                <td>{{ $item->getRoleNames() }}</td>
                                <td>
                                    <div class="">
                                        <label>
                                            <input type="checkbox" disabled class="" @if($item->status ?? '') checked @endif/>
                                        </label>
                                    </div>

                                </td>
                                <td>
                                    <a href="{{ route('user-admin.edit', $item->id) }}" class="btn btn-xs btn-info"><i
                                                class="fa fa-pencil"></i></a>
                                    <button type="button" data-toggle="modal" data-target="#myModal-{{$item->id}}"
                                            class="btn btn-xs btn-danger"><i
                                                class="fa fa-times"></i></button>
                                    <div id="myModal-{{$item->id}}" class="modal fade" role="dialog">
                                        <div class="modal-dialog">
                                            <form action="{{route('user-admin.destroy',['id'=>$item->id])}}" method="get">
                                                <!-- Modal content-->
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        <h4 class="modal-title">Xóa</h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Bạn muốn xóa user này?</p>
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
                            <?php $i++ ?>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
