<div id="sidebar" class="active">
            <div class="sidebar-wrapper active">
                <div class="sidebar-header">
                    <div class="d-flex justify-content-between">
                        <div class="logo">
                            <a href="index.html"><img src="assets/images/logo/logo.png" alt="Logo" srcset=""></a>
                        </div>
                        <div class="toggler">
                            <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                        </div>
                    </div>
                </div>
                <div class="sidebar-menu">
                    <ul class="menu">
                        <li class="sidebar-title">لوحة التحكم</li>

                        <li class="sidebar-item  ">
                            <a href="{{route('home')}}" class='sidebar-link'>
                                <i class="bi bi-grid-fill"></i>
                                <span>احصائيات التطبيق</span>
                            </a>
                        </li>

                        <li class="sidebar-item  has-sub">
                            <a href="#" class='sidebar-link'>
                                <i class="bi bi-stack"></i>
                                <span>ادارة خطوط النقل</span>
                            </a>
                            <ul class="submenu ">
                                <li class="submenu-item ">
                                    <a href="{{route('lines.index')}}">عرض بيانات الخطوط</a>
                                </li>
                                <li class="submenu-item ">
                                    <a href="{{route('lines.create')}}">اضافة خط</a>
                                </li>
                            </ul>
                        </li>

                        <li class="sidebar-item  has-sub">
                            <a href="#" class='sidebar-link'>
                                <i class="bi bi-collection-fill"></i>
                                <span>ادارة بيانات السائقين</span>
                            </a>
                            <ul class="submenu ">
                                <li class="submenu-item ">
                                    <a href="{{route('drivers.index')}}">عرض بيانات السائقين</a>
                                </li>
                                <li class="submenu-item ">
                                    <a href="{{route('drivers.create')}}">اضافة سائق</a>
                                </li>
                               
                            </ul>
                        </li>
                        <li class="sidebar-item  has-sub">
                            <a href="#" class='sidebar-link'>
                                <i class="bi bi-collection-fill"></i>
                                <span>ادارة بيانات الرحلات</span>
                            </a>
                            <ul class="submenu ">
                                <li class="submenu-item ">
                                    <a href="{{route('trips.index')}}">عرض بيانات الرحلات</a>
                                </li>
                                <li class="submenu-item ">
                                    <a href="{{route('trips.create')}}">اضافة رحلة</a>
                                </li>
                               
                            </ul>
                        </li>

                        <li class="sidebar-item active ">
                            <a href="{{route('students.index')}}" class='sidebar-link'>
                                <i class="bi bi-basket-fill"></i>
                                <span>تصفح بيانات الطلاب</span>
                            </a>
                        </li>

                        <li class="sidebar-item active ">
                            <a href="{{route('alerts')}}" class='sidebar-link'>
                                <i class="bi bi-basket-fill"></i>
                                <span>قسم الانذارات</span>
                            </a>
                        </li>
                        <li class="sidebar-item active ">
                            <a href="{{route('suggestions')}}" class='sidebar-link'>
                                <i class="bi bi-basket-fill"></i>
                                <span>قسم الاقتراحات</span>
                            </a>
                        </li>
                        <li class="sidebar-item active ">
                            <a href="{{route('notifications_admin')}}" class='sidebar-link'>
                                <i class="bi bi-basket-fill"></i>
                                <span>قسم الاشعارات</span>
                            </a>
                        </li>
                        <li class="sidebar-title">الاعدادات  &amp; العامة</li>
                        <li class="sidebar-item">
                            <a href="{{route('profile_admin')}}" class='sidebar-link'>
                                <i class="bi bi-file-earmark-medical-fill"></i>
                                <span>اعدادات الحساب</span>
                            </a>
                        </li>

                 

                    </ul>
                </div>
                <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
            </div>
        </div>