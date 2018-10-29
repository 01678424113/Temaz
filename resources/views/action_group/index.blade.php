@extends('layouts.app-2')
@section('title', 'Quản lý phân quyền')
@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Quản lý phân quyền </h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                        <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="table-responsive">
                        <table class="table table-responsive table-striped table-striped">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tên nhóm quyền</th>
                                <th>Mô tả</th>
                                <th width="150">Hành động</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if(!empty($listData)){
                            foreach($listData as $key => $value){
                            ?>
                            <tr>
                                <td>{{ $value->id }}</td>
                                <td>{{ $value->name }}</td>
                                <td>{!! nl2br($value->description) !!}</td>
                                <td>
                                    <a href="{{ route('ActionGroup_edit', ['id' => $value->id]) }}"
                                       class="btn btn-warning"><i class="fa fa-edit"></i></a>
                                    <a href="{{ route('ActionGroup_delete', ['id' => $value->id]) }}"
                                       class="btn btn-danger"><i class="fa fa-close"></i></a>
                                </td>
                            </tr>
                            <?php
                            }
                            }
                            ?>
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection