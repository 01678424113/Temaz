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
                                    <h2>Tạo chiến dịch</h2>
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
                                    <form action="{{ route('campaign.store') }}" method="post"
                                          class="form-horizontal form-label-left">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                @include('layouts.components.form-html.input-text', [
                                                    'label' => 'Tên chiến dịch',
                                                    'name' => 'name',
                                                    'is_required' => true,
                                                    'value' =>'',
                                                ])
                                                @include('layouts.components.form-html.input-text', [
                                                   'label' => 'Slug',
                                                   'name' => 'slug',
                                                   'is_required' => true,
                                                   'value' =>''
                                               ])
                                                @include('layouts.components.form-html.input-text', [
                                                  'label' => 'Sắp xếp',
                                                  'name' => 'sort_by',
                                                  'is_required' => false,
                                                  'value' => ''
                                              ])

                                            </div>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <div class="form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="">Nhóm
                                                        chiến dịch</label>
                                                    <div class="col-md-9 col-sm-9 col-xs-12">
                                                        {!! Form::select('category_id', $arrayCategories, '', ['class' => 'form-control select2 select-category']) !!}
                                                    </div>
                                                </div>
                                                @include('layouts.components.form-html.switch-checked', [
                                                'label' => 'Trạng thái',
                                                'name' => 'status',
                                                'is_required' => false,
                                                'is_checked' =>''
                                            ])
                                            </div>
                                        </div>
                                        <div class="ln_solid"></div>
                                        <div class="form-group">
                                            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                                <a href="{{ route('campaign.index') }}" class="btn btn-primary">Quay
                                                    lại</a>
                                                <button type="submit" name="btnSubmit" class="btn btn-success">Tạo
                                                    chiến dịch
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
