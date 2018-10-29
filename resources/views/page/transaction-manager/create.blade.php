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
                                    <h2>Tạo giao dịch</h2>
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
                                    <form action="{{ route('transaction-manager.store') }}" method="post"
                                          class="form-horizontal form-label-left">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <div class="form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="">Chọn user<span class="required">*</span></label>
                                                    <div class="col-md-9 col-sm-9 col-xs-12">
                                                        {!! Form::select('user_id', ['' => 'Chọn user'] + $listUser, old('user_id'), ['class' => 'form-control select2']) !!}
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="">Loại
                                                        giao dịch</label>
                                                    <div class="col-md-9 col-sm-6 col-xs-12 form-group has-feedback">
                                                        <select name="type" id="" class="form-control">
                                                            <option value="{{\App\Models\Transaction::$TYPE_PLUS}}">Cộng
                                                                tiền
                                                            </option>
                                                            <option value="{{\App\Models\Transaction::$TYPE_MINUS}}">Trừ
                                                                tiền
                                                            </option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="">Số tiền<span class="required">*</span></label>
                                                    <div class="col-md-9 col-sm-9 col-xs-12">
                                                        <input type="number" name="amount" class="form-control" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <div class="form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="">Lý do<span class="required">*</span></label>
                                                    <div class="col-md-9 col-sm-9 col-xs-12">
                                                        <textarea class="resizable_textarea form-control" rows="5" required id="" name="note" placeholder=""></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="ln_solid"></div>
                                        <div class="form-group">
                                            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                                <a href="{{ route('home') }}" class="btn btn-primary">Quay lại</a>
                                                <button type="submit" name="btnSubmit" class="btn btn-success">Tạo giao
                                                    dịch
                                                </button>
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
