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
                <form action="{{route('category.doAddPhoneToCategory')}}" method="post">
                    @csrf
                    <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback" style="padding: 5px;">
                        <select name="category_id"
                                class="form-control select2"
                                id="">
                            @if(!empty($categories))
                                @foreach($categories as $key=>$category)
                                    <option value="{{$key}}">{{$category}}</option>
                                @endforeach
                            @endif
                        </select>
                        <button class="btn btn-info" style="margin-top: 10px;">Cập nhập</button>

                    </div>

                    <div class="x_content">
                        <table id="datatable-buttons" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th style="width: 30px">#</th>
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
                                        <td>
                                            <input type="checkbox" name="phoneIds[]" value="{{$value->id}}" style="width: 20px;height: 20px;"/>
                                        </td>
                                        <td>{{ $value->phone }}</td>
                                        <td>{{ $value->category_name }}</td>
                                        <td>{{ $value->source }}</td>
                                        <td>{{ $value->time }}</td>
                                        <td>{{ $value->created_at }}</td>
                                        <td><a target="_blank" href="{{$value->link}}">Click</a></td>
                                        <td>
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
                </form>
            </div>
        </div>
    </div>
    

@endsection
