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
                <small>chiến dịch</small>
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
                            <form action="{{ route('campaign.update',['id'=>$campaign->id]) }}" method="post"
                                  class="form-horizontal form-label-left" id="form-update-campaign">
                                @csrf
                                <div class="form-body">
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Tên
                                            <span class="required"> * </span>
                                        </label>
                                        <div class="col-md-4">
                                            <input type="text" name="name" data-required="1" value="{{$campaign->name}}"
                                                   class="form-control"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Sắp xếp
                                            <span class="required"> * </span>
                                        </label>
                                        <div class="col-md-4">
                                            <input name="sort_by" type="text" class="form-control"
                                                   value="{{$campaign->sort_by}}"/></div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Dịch vụ
                                            <span class="required"> * </span>
                                        </label>
                                        <div class="col-md-4">
                                            {!! Form::select('category_id', $arrayCategories, $campaign->category_id, ['class' => 'form-control select2 select-category']) !!}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Trạng thái
                                            <span class="required"> * </span>
                                        </label>
                                        <div class="col-md-4">
                                            <div class="mt-checkbox-list">
                                                <label class="mt-checkbox">
                                                    <input type="checkbox" @if($campaign->status ?? '') checked
                                                           @endif name="status"/>
                                                    <span></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <div class="form-group">
                                <div class="row">
                                    <?php
                                    $i = 1;
                                    ?>
                                    @if(!empty($smsContents))
                                        @foreach($smsContents as $smsContent)
                                            <div class="col-md-12">
                                                <form action="{{route('sms-content.update',['id'=>$smsContent->id])}}"
                                                      method="post" id="content-{{$smsContent->id}}"
                                                      style="margin-bottom: 15px">
                                                    @csrf
                                                    <input type="hidden" name="id">
                                                    <div class="form-group">
                                                        <label class="control-label col-md-3" style="text-align: right">Mẫu
                                                            SMS
                                                            <span class="required"> * </span>
                                                        </label>
                                                        <div class="col-md-4">
                                                                <textarea class="resizable_textarea form-control"
                                                                          onchange="changeContentSms({{$smsContent->id}})"
                                                                          rows="5" id="" name="content_sms"
                                                                          placeholder="">{{$smsContent->content}}</textarea>
                                                        </div>
                                                        <div class="col-md-2">
                                                            @if($i == count($smsContents))
                                                            <div class="btn btn-success add_sample_sms"><i
                                                                        class="fa fa-plus"></i></div>
                                                            @endif
                                                            @if($i != 1)
                                                                <a href="{{route('sms-content.destroy',['id'=>$smsContent->id])}}"
                                                                   class="btn btn-danger"><i
                                                                            class="fa fa-close"></i></a>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <?php
                                            $i++;
                                            ?>
                                        @endforeach
                                    @endif
                                    <div class="col-md-12">`
                                        <form action="{{route('sms-content.store')}}" method="post"
                                              class="div_sample_sms">
                                            @csrf
                                            <input type="hidden" name="campaign_id" value="{{$campaign->id}}">
                                        </form>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="form-actions">
                            <div class="row">
                                <div class="col-md-offset-3 col-md-9">
                                    <button type="button" class="btn green"
                                            onclick="document.getElementById('form-update-campaign').submit();">
                                        Lưu
                                    </button>
                                    <a href="{{ route('campaign.index') }}"
                                       class="btn grey-salsa btn-outline">Quay lại</a>
                                </div>
                            </div>
                        </div>
                        <!-- END FORM-->
                    </div>
                    <!-- END VALIDATION STATES-->
                </div>
            </div>
        </div>
        <!-- END CONTENT BODY -->
    </div>
@endsection
@section('script')
    <script>
        $('.add_sample_sms').click(function () {
            $('.add_sample_sms').addClass('hidden');
            $('.div_sample_sms').append("<div class='row' style=\"margin-bottom: 15px\"><div class='col-md-12'><div class=\"form-group form_sample_sms\">\n" +
                "                                                    <label class=\"control-label col-md-3 col-sm-3 col-xs-12\" style=\"text-align: right\" for=\"\">\n" +
                "                                                        Mẫu SMS <span class=\"required\">*</span>\n" +
                "                                                    </label>\n" +
                "                                                    <div class=\"col-md-4\">\n" +
                "                                                        <textarea class=\"resizable_textarea form-control\" rows=\"5\" id=\"\"\n" +
                "                                                                  name=\"content_sms\" placeholder=\"\"></textarea>\n" +
                "                                                    </div>\n" +
                "                                                    <div class=\"col-md-2\">\n" +
                "                                                        <button type=\"submit\" class=\"btn btn-success save_sample_sms\"><i class=\"fa fa-save\"></i></button>\n" +
                "                                                        <div class=\"btn btn-danger remove_sample_sms\"><i class=\"fa fa-close\"></i></div>\n" +
                "                                                    </div>\n" +
                "                                                </div>\n" +
                "                                            </div>\n" +
                "                                            <script>\n" +
                "                                                $('.remove_sample_sms').click(function () {\n" +
                "                                                   $(this).parent().parent().remove();\n" +
                "                                                   $('.add_sample_sms').removeClass('hidden');\n" +
                "                                                });\n" +
                "                                            <\/script><\/div><\/div>")
        });
        $('.remove_sample_sms').click(function () {
            $(this).parent().parent().remove();
        });

        function changeContentSms(id) {
            var url = $("#content-" + id).attr('action');
            $.ajax({
                url: url,
                method: 'post',
                data: $("#content-" + id).serialize(),
                success: function (data) {
                    if (data['status']) {
                        console.log(data['message']);
                    } else {
                        console.log(data['message']);
                    }
                }
            })
        }
    </script>
@endsection