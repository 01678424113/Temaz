@extends('admin.layout')
@section('content')
    <div class="page-content-wrapper">
        <!-- BEGIN CONTENT BODY -->
        <div class="page-content">
            <!-- BEGIN PAGE HEADER-->
            <!-- BEGIN THEME PANEL -->
        @include('admin.layouts.theme-panel')
        <!-- END THEME PANEL -->
            <h1 class="page-title"> {{$title}}
                <small>sms cronjob</small>
            </h1>
            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                        <i class="icon-home"></i>
                        <a href="{{route('home')}}">Home</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <a href="#">{{$title}}</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                </ul>
                <div class="page-toolbar">
                    <div class="btn-group pull-right">
                        <button type="button" class="btn btn-fit-height grey-salt dropdown-toggle"
                                data-toggle="dropdown" data-hover="dropdown" data-delay="1000" data-close-others="true">
                            Actions
                            <i class="fa fa-angle-down"></i>
                        </button>
                        {{--       <ul class="dropdown-menu pull-right" role="menu">
                                   <li>
                                       <a href="#">
                                           <i class="icon-bell"></i> Action</a>
                                   </li>
                                   <li>
                                       <a href="#">
                                           <i class="icon-shield"></i> Another action</a>
                                   </li>
                                   <li>
                                       <a href="#">
                                           <i class="icon-user"></i> Something else here</a>
                                   </li>
                                   <li class="divider"></li>
                                   <li>
                                       <a href="#">
                                           <i class="icon-bag"></i> Separated link</a>
                                   </li>
                               </ul>--}}
                    </div>
                </div>
            </div>
            <!-- END PAGE HEADER-->
            <div class="m-heading-1 border-green m-bordered">
                <h3>Chú ý: </h3>
                <p></p>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <!-- BEGIN VALIDATION STATES-->
                    <div class="portlet light portlet-fit portlet-form ">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="icon-settings font-red"></i>
                                <span class="caption-subject font-red sbold uppercase">{{$title}}</span>
                            </div>
                            <div class="actions">
                                <div class="btn-group btn-group-devided" data-toggle="buttons">
                                    <label class="btn btn-transparent red btn-outline btn-circle btn-sm active">
                                        <input type="radio" name="options" class="toggle" id="option1">Actions</label>
                                    <label class="btn btn-transparent red btn-outline btn-circle btn-sm">
                                        <input type="radio" name="options" class="toggle" id="option2">Settings</label>
                                </div>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <!-- BEGIN FORM-->
                            <form action="{{route('sms-cronjob.store')}}" method="post"
                                  class="form-horizontal form-label-left">
                                @csrf
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label col-md-3">Campaign
                                                    <span class="required"> * </span>
                                                </label>
                                                <div class="col-md-9">
                                                    <select class="form-control select_campaign" name="campaign_id" id=""
                                                            required>
                                                        @if(!empty($arrayCampaigns))
                                                            @foreach($arrayCampaigns as $key=>$arrayCampaign)
                                                                <option value="{{$key}}">{{$arrayCampaign}}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-3">Tên
                                                    <span class="required"> * </span>
                                                </label>
                                                <div class="col-md-9">
                                                    <input type="text" class="form-control" name="name" required>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-3">Thời gian
                                                    <span class="required"> * </span>
                                                </label>
                                                <div class="col-md-9">
                                                    <select class="form-control select_campaign" name="time" id="" required>
                                                        <option value="1">1</option>
                                                        <option value="5">5</option>
                                                        <option value="10">10</option>
                                                        <option value="30">30</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group" style="text-align: right;margin-right: 0;">
                                                    <button class="btn btn-success btn-send" type="submit">Đặt lịch</button>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="">
                                                    Upload file:
                                                </label>
                                                <div class=" col-md-7 col-sm-7 col-xs-10">
                                                    <input type="file" name="file_phone" class="form-control">
                                                </div>
                                                <div class=" col-md-2 col-sm-2 col-xs-2">
                                                    <a href="/home/temaz.net/public_html/PhoneSample.xlsx" download
                                                       class="btn btn-success add_sample_sms"><i
                                                                class="fa fa-download"></i></a>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="">
                                                    Nhập số điện thoại:
                                                </label>
                                                <div class=" col-md-9 col-sm-9 col-xs-12">
                                            <textarea name="text_phone" id="" cols="30" rows="10" required
                                                      class="form-control"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </form>
                            <!-- END FORM-->
                        </div>
                    </div>
                    <!-- END VALIDATION STATES-->
                </div>
            </div>
        </div>
        <!-- END CONTENT BODY -->
    </div>
@endsection