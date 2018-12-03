@extends('layouts.app-2')

@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Danh sách data đã Import </h2>
                    <ul class="nav navbar-right panel_toolbox" style="display: flex;justify-content: flex-end;">
                        <li><a href="{{route('sms-data.create')}}" style="color:#26B99A;"><i class="fa fa-plus"></i></a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <form action="{{route('sms-data.sendSms')}}" method="post" enctype="multipart/form-data"
                      id="form-send-sms">
                    @csrf
                    <div class="x_content">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="">Nội dung
                                            </label>
                                            <div class="col-md-9 col-sm-6 col-xs-12 form-group has-feedback">
                                                        <textarea name="content_sms" id="" cols="30" rows="10"
                                                                  class="form-control" required></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="">APIKEY
                                            </label>
                                            <div class="col-md-9 col-sm-6 col-xs-12 form-group has-feedback">
                                                <input type="text" name="APIKEY" value="EA7C58393611CB9A6C49C9B81BFD71"
                                                       class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="">SCRETKEY
                                            </label>
                                            <div class="col-md-9 col-sm-6 col-xs-12 form-group has-feedback">
                                                <input type="text" name="SECRETKEY"
                                                       value="E24422D0EC29026467A5919FDB2B0E" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="">BRANDNAME
                                            </label>
                                            <div class="col-md-9 col-sm-6 col-xs-12 form-group has-feedback">
                                                <input type="text" name="BRANDNAME" value="QCAO_ONLINE"
                                                       class="form-control">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for=""></label>
                                            <div class="col-md-9 col-sm-6 col-xs-12 form-group has-feedback">
                                                <button class="btn btn-success btn-send" type="button">Send</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="">
                                                Nhóm chiến dịch:
                                            </label>
                                            <div class=" col-md-9 col-sm-9 col-xs-12">
                                                <select class="form-control" name="campaign_id" id="">
                                                    <option value="0">Không chọn</option>
                                                    @if(!empty($arrayCampaigns))
                                                        @foreach($arrayCampaigns as $key=>$arrayCampaign)
                                                            <option value="{{$key}}">{{$arrayCampaign}}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12" style="margin-top: 15px;">
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="">
                                                Upload file:
                                            </label>
                                            <div class=" col-md-9 col-sm-9 col-xs-12">
                                                <input type="file" name="file_phone" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12" style="margin-top: 15px;">
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="">
                                                Nhập số điện thoại:
                                            </label>
                                            <div class=" col-md-9 col-sm-9 col-xs-12">
                                            <textarea name="text_phone" id="" cols="30" rows="10"
                                                      class="form-control"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <hr>
                            <div class="col-md-offset-7 col-md-5" style="text-align: center">
                                <div class="col-md-3" style="margin-top: 15px;">
                                    Tổng số tìm được: <span id="total">0</span>
                                </div>
                                <div class="col-md-3" style="margin-top: 15px;">
                                    Gửi thành công: <span class="green" id="success">0</span>
                                </div>
                                <div class="col-md-3" style="margin-top: 15px;">
                                    Gửi thất bại: <span class="red" id="fail">0</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $('.btn-send').click(function () {
            var url = $('#form-send-sms').attr('action');
            $.ajax({
                url: url,
                method: 'post',
                data: $('#form-send-sms').serialize(),
                success: function (data) {
                    console.log(data);
                    var apiKey = data.APIKEY;
                    var secretKey = data.SECRETKEY;
                    var content = data.content;
                    var smsType = data.SMSTYPE;
                    var brandName = data.BRANDNAME;
                    var list_phones = data.list_phones;
                    var success = $('#success').html();
                    var fail = $('#fail').html();
                    $('#total').html(list_phones.length);
                    $.each(list_phones, function (key, value) {
                        $.ajax({
                            url: "{{route('sms-data.doSendSms')}}",
                            method: 'post',
                            data: {
                                _token: "{{csrf_token()}}",
                                APIKEY: apiKey,
                                SECRETKEY: secretKey,
                                CONTENT: content,
                                SMSTYPE: smsType,
                                BRANDNAME: brandName,
                                PHONE: value,
                            },
                            success: function (data) {
                                console.log(data);
                                if(data.indexOf("CodeResult\":\"100") != -1){
                                    success = parseInt(success) + 1;
                                    $('#success').html(success);
                                }else{
                                    fail = parseInt(fail) + 1;
                                    $('#fail').html(fail);
                                }
                            }
                        })

                    })
                }
            })
        })
    </script>
@endsection
