<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
    <div class="menu_section">
        <h3>Temaz Media</h3>
        <ul class="nav side-menu">
            <li><a href="{{ route('home') }}"><i class="fa fa-dashboard"></i> Trang chủ </a></li>
            <li>
                <a href="javascript:;">
                    <i class="fa fa-user"></i> Quản lý tài khoản <span class="fa fa-chevron-down"></span>
                </a>
                <ul class="nav child_menu">
                    <li><a href="{{ route('user-admin.index') }}">Danh sách tài khoản</a></li>
                    <li><a href="{{ route('user-admin.create') }}">Tạo mới tài khoản</a></li>
                </ul>
            </li>
            <li>
                <a href="javascript:;">
                    <i class="fa fa-group"></i> Phân quyền admin<span class="fa fa-chevron-down"></span>
                </a>
                <ul class="nav child_menu">
                    <li><a href="{{ route('role.index') }}">Vai trò</a></li>
                    <li><a href="{{ route('permission.index') }}">Quyền</a></li>
                </ul>
            </li>
            <li>
                <a href="javascript:;">
                    <i class="fa fa-list"></i> Dịch vụ <span class="fa fa-chevron-down"></span>
                </a>
                <ul class="nav child_menu">
                    <li><a href="{{ route('category.index') }}">Danh sách dịch vụ</a></li>
                    <li><a href="{{ route('campaign.index') }}">Chiến dịch</a></li>
                </ul>
            </li>
            <li>
                <a href="javascript:;">
                    <i class="fa fa-list"></i> SMS <span class="fa fa-chevron-down"></span>
                </a>
                <ul class="nav child_menu">
                    <li><a href="{{ route('sms-data.index') }}">Gửi SMS</a></li>
                </ul>
            </li>
            <li>
                <a href="javascript:;">
                    <i class="fa fa-list"></i> Vay Nóng Online <span class="fa fa-chevron-down"></span>
                </a>
                <form action="{{route('VayNongOnline.campaign')}}" method="get" id="campaign-vaynong">
                    <input type="hidden" name="table" value="campaign">
                </form>
                <form action="{{route('VayNongOnline.customer')}}" method="get" id="customer-vaynong">
                    <input type="hidden" name="table" value="customer_details">
                    <input type="hidden" name="from" value="0">
                    <input type="hidden" name="to" value="500">
                    <input type="hidden" name="where" value="">
                </form>
                <ul class="nav child_menu">
                    <li>
                        <a href="javascript:void(0)" onclick="$('#campaign-vaynong').submit()">Campaign</a>
                    </li>
                    <li>
                        <a href="javascript:void(0)" onclick="$('#customer-vaynong').submit()">Customer</a>
                    </li>
                </ul>

            </li>
        </ul>
    </div>
</div>
