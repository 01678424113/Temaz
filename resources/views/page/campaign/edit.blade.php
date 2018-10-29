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
                                    <h2>Sửa chiến dịch</h2>
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
                                    <form action="{{ route('campaign.update',['id'=>$campaign->id]) }}" method="post"
                                          class="form-horizontal form-label-left">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                @include('layouts.components.form-html.input-text', [
                                                    'label' => 'Tên chiến dịch',
                                                    'name' => 'name',
                                                    'is_required' => true,
                                                    'value' =>$campaign->name,
                                                ])
                                                @include('layouts.components.form-html.input-text', [
                                                   'label' => 'Slug',
                                                   'name' => 'slug',
                                                   'is_required' => true,
                                                   'value' =>$campaign->slug
                                               ])
                                                @include('layouts.components.form-html.input-text', [
                                                  'label' => 'Sắp xếp',
                                                  'name' => 'sort_by',
                                                  'is_required' => false,
                                                  'value' => $campaign->sort_by
                                              ])

                                            </div>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <div class="form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="">Nhóm
                                                        chiến dịch</label>
                                                    <div class="col-md-9 col-sm-9 col-xs-12">
                                                        {!! Form::select('category_id', $arrayCategories, $campaign->category_id, ['class' => 'form-control select2 select-category']) !!}
                                                    </div>
                                                </div>
                                                @include('layouts.components.form-html.switch-checked', [
                                                'label' => 'Trạng thái',
                                                'name' => 'status',
                                                'is_required' => false,
                                                'is_checked' =>($campaign->status == 1) ? true : false
                                            ])
                                            </div>
                                        </div>
                                        <div class="ln_solid"></div>
                                        <div class="form-group">
                                            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                                <a href="{{ route('campaign.index') }}" class="btn btn-primary">Quay
                                                    lại</a>
                                                <button type="submit" name="btnSubmit" class="btn btn-success">Sửa
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
