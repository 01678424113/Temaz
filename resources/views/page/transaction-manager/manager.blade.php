@extends('layouts.app-2')

@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_content">
                    <div class="clearfix"></div>
                    <div class="row">
                        <div class="col-md-6 col-sm-12 col-xs-12">
                            <div class="x_panel">
                                <div class="x_title">
                                    <h2>Thống kê theo bảng</h2>
                                    <ul class="nav navbar-right panel_toolbox">
                                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                        </li>
                                        <li><a class="close-link"><i class="fa fa-close"></i></a>
                                        </li>
                                    </ul>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
                                    <table id="datatable-buttons" class="table table-striped table-bordered">
                                        <thead>
                                        <tr>
                                            <th>STT</th>
                                            <th>Thời gian</th>
                                            <th>Số tiền</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if(!empty($revenues))
                                            <?php $i = 1; ?>
                                            @foreach($revenues as $key => $value)
                                                <tr>
                                                    <td>{{ $i }}</td>
                                                    <td>{{ $key }}</td>
                                                    <td>{{ number_format($value) }} VND</td>
                                                </tr>
                                            @endforeach
                                        @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12 col-xs-12">
                            <div class="x_panel">
                                <div class="x_title">
                                    <h2>Biểu đồ doanh thu</h2>
                                    <form action="{{route('transaction-manager.manager')}}" method="get" id="transaction_manager">
                                        <div class="dataTables_length pull-right">
                                            <select name="time" class="form-control input-sm">
                                                <option {{(Request::input('time') == 'month') ? 'selected' : ''}} value="month" class="form-control">Tháng</option>
                                                <option {{(Request::input('time') == 'date') ? 'selected' : ''}} value="date" class="form-control">Ngày</option>
                                                <option {{(Request::input('time') == 'year') ? 'selected' : ''}} value="year" class="form-control">Năm</option>
                                            </select>
                                        </div>
                                    </form>
                                    <ul class="nav navbar-right panel_toolbox">
                                        <li><a class="collapse-link"><i
                                                        class="fa fa-chevron-up"></i></a>
                                        </li>
                                        <li class="dropdown">
                                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"
                                               role="button" aria-expanded="false"><i
                                                        class="fa fa-wrench"></i></a>
                                            <ul class="dropdown-menu" role="menu">
                                                <li><a href="#">Settings 1</a>
                                                </li>
                                                <li><a href="#">Settings 2</a>
                                                </li>
                                            </ul>
                                        </li>
                                        <li><a class="close-link"><i class="fa fa-close"></i></a>
                                        </li>
                                    </ul>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
                                    <canvas id="transactionChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="assets/vendors/Chart.js/dist/Chart.min.js"></script>
    <script>
        $('select[name=time]').change(function () {
            $('#transaction_manager').submit();
        });
        if ($('#transactionChart').length) {
            var ctx = document.getElementById("transactionChart");
            var transactionChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: {!! $month !!},
                    datasets: [{
                        label: 'Doanh thu',
                        backgroundColor: "#26B99A",
                        data: {!! $money !!}
                    }]
                },

                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    }
                }
            });

        }
    </script>
@endpush