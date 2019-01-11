@extends('layouts.app-2')

@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>SMS</h2>
                    <ul class="nav navbar-right panel_toolbox" style="display: flex;justify-content: flex-end;">
                        <li><a href="{{route('sms-cronjob.create')}}" style="color:#26B99A;"><i class="fa fa-plus"></i></a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <form action="{{route('sms-cronjob.smsCronjob')}}" method="post" enctype="multipart/form-data"
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
                                                                  class="form-control"
                                                                  required>{{$cronjob->content}}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="">Thời gian
                                            </label>
                                            <div class="col-md-9 col-sm-6 col-xs-12 form-group has-feedback">
                                                <input type="number" name="time" value="{{$cronjob->time}}"
                                                       class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for=""></label>
                                            <div class="col-md-9 col-sm-6 col-xs-12 form-group has-feedback">
                                                <button class="btn btn-success btn-send" type="submit">Đặt lịch</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-12" style="margin-top: 15px;">
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="">
                                                Danh sách:
                                            </label>
                                            <div class=" col-md-9 col-sm-9 col-xs-12">
                                                <?php
                                                $list_phones = json_decode($cronjob->list_phones);
                                                $i = 1;
                                                $text = '';
                                                foreach ($list_phones as $phone) {
                                                    if ($i == 1) {
                                                        $text = $phone;
                                                    } else {
                                                        $text = $text . '</br>' . $phone;
                                                    }
                                                    $i++;
                                                }
                                                ?>
                                                {!! $text !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <hr>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('script')

@endsection

