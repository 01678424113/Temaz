@extends('layouts.app-2')

@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_content">
                    <div class="clearfix"></div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="x_panel">
                                <div class="x_title">
                                    <h2>Import</h2>
                                    <ul class="nav navbar-right panel_toolbox">
                                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                        </li>
                                        <li><a class="close-link"><i class="fa fa-close"></i></a>
                                        </li>
                                    </ul>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
                                    <br/>
                                    <form action="{{ route('Home_doImport') }}" method="post" enctype="multipart/form-data"
                                          class="form-horizontal form-label-left">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <div class="form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="">Nguồn<span class="required">*</span></label>
                                                    <div class="col-md-9 col-sm-9 col-xs-12">
                                                        <select name="source" id="" class="form-control">
                                                            <option value="viettel">Viettel</option>
                                                            <option value="mobiphone">Mobiphone</option>
                                                            <option value="vinaphone">Vinaphone</option>
                                                            <option value="facebook">Facebook</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="">Chọn
                                                        file:<span class="required">*</span></label>
                                                    <div class="col-md-9 col-sm-9 col-xs-12">
                                                        <input type="file" name="file" class="form-control" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                                    <a href="{{ route('home') }}" class="btn btn-primary">Quay lại</a>
                                                    <button type="submit" name="btnSubmit" class="btn btn-success">Upload</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
