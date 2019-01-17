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
                                          class="form-horizontal form-label-left" id="form-update-campaign">
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
                                                  'label' => 'Sắp xếp',
                                                  'name' => 'sort_by',
                                                  'is_required' => false,
                                                  'value' => $campaign->sort_by
                                              ])
                                            </div>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <div class="form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="">Dịch
                                                        vụ</label>
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
                                    </form>
                                    <div class="row">
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <?php
                                            $i = 1;
                                            ?>
                                            @if(!empty($smsContents))
                                                @foreach($smsContents as $smsContent)
                                                    <form action="{{route('sms-content.update',['id'=>$smsContent->id])}}"
                                                          method="post" id="content-{{$smsContent->id}}">
                                                        @csrf
                                                        <input type="hidden" name="id">
                                                        <div class="form-group">
                                                            <label class="control-label col-md-3 col-sm-3 col-xs-12"
                                                                   for="">Mẫu SMS <span
                                                                        class="required">*</span></label>
                                                            <div class="col-md-7 col-sm-7 col-xs-10">
                                                                <textarea class="resizable_textarea form-control"
                                                                          onchange="changeContentSms({{$smsContent->id}})"
                                                                          rows="5" id="" name="content_sms"
                                                                          placeholder="">{{$smsContent->content}}</textarea>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="btn btn-success add_sample_sms"><i
                                                                            class="fa fa-plus"></i></div>
                                                                @if($i != 1)
                                                                    <a href="{{route('sms-content.destroy',['id'=>$smsContent->id])}}"
                                                                       class="btn btn-danger"><i
                                                                                class="fa fa-close"></i></a>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </form>
                                                    <?php
                                                    $i++;
                                                    ?>
                                                @endforeach
                                            @endif
                                            <form action="{{route('sms-content.store')}}" method="post"
                                                  class="div_sample_sms">
                                                @csrf
                                                <input type="hidden" name="campaign_id" value="{{$campaign->id}}">
                                            </form>
                                        </div>
                                    </div>
                                    <div class="ln_solid"></div>
                                    <div class="row">
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="form-group" style="float: right">
                                                <a href="{{ route('campaign.index') }}" class="btn btn-primary">Quay
                                                    lại</a>
                                                <button type="button"
                                                        onclick="document.getElementById('form-update-campaign').submit();"
                                                        class="btn btn-success">Sửa
                                                    chiến dịch
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $('.add_sample_sms').click(function () {
            $('.add_sample_sms').addClass('hidden');
            $('.div_sample_sms').append("<div class=\"form-group form_sample_sms\">\n" +
                "                                                    <label class=\"control-label col-md-3 col-sm-3 col-xs-12\" for=\"\">\n" +
                "                                                        Mẫu SMS <span class=\"required\">*</span>\n" +
                "                                                    </label>\n" +
                "                                                    <div class=\"col-md-7 col-sm-7 col-xs-10\">\n" +
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
                "                                            <\/script>")
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