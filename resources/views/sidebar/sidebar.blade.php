
<div id="sidebar" class="active">
            <div class="sidebar-wrapper active">
                <div class="sidebar-header">
                    <div class="d-flex justify-content-between">
                        <div class="logo">
                            

                            <a href="index.html"><img style="height: 3.2rem;"
                            src="{{ URL::asset('assets/images/logo/logo.png') }}"
                             alt="Logo" srcset=""></a>
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
                                <i class="bi bi-graph-up"></i>
                                <span>احصائيات التطبيق</span>
                            </a>
                        </li>
                        
           
         
          
         
         

                     @can( 'ادارة عمليات الخطوط')

                        <li class="sidebar-item  has-sub">
                            <a href="#" class='sidebar-link'>
                                <i class="bi bi-arrow-left-right"></i>
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
                        @endcan
                        @can('ادارة عمليات السائقين')
           
                        <li class="sidebar-item  has-sub">
                            <a href="#" class='sidebar-link'>
                                <i class="bi bi-speedometer2"></i>
                                <span>ادارة بيانات السائقين</span>
                            </a>
                            <ul class="submenu ">
                                <li class="submenu-item ">
                                    <a href="{{route('drivers.index')}}">عرض بيانات السائقين (حساب نشط)</a>
                                </li>
                                <li class="submenu-item ">
                                    <a href="{{route('drivers_index_unactive')}}">عرض بيانات السائقين (حساب محظور)</a>
                                </li>
                                <li class="submenu-item ">
                                    <a href="{{route('drivers.create')}}">اضافة سائق</a>
                                </li>
                               
                            </ul>
                        </li>
                        @endcan
                        @can('ادارة عمليات الرحلات')
           
                        <li class="sidebar-item  has-sub">
                            <a href="#" class='sidebar-link'>
                                <i class="bi bi-slack"></i>
                                <span>ادارة بيانات الرحلات</span>
                            </a>
                            <ul class="submenu ">
                                <li class="submenu-item ">
                                    <a href="{{route('trips.index')}}">عرض بيانات الرحلات القادمة</a>
                                </li>
                                <li class="submenu-item ">
                                    <a href="{{route('trips_finite')}}">عرض بيانات الرحلات المنتيهة</a>
                                 </li>
                                <li class="submenu-item ">
                                    <a href="{{route('trips_current')}}">عرض بيانات الرحلات الحالية</a>
                                </li>
                                <li class="submenu-item ">
                                    <a href="{{route('trips_progress')}}">عرض بيانات الرحلات قيد التقدم</a>
                                </li>
                                <li class="submenu-item ">
                                    <a href="{{route('trips_canelled')}}">عرض بيانات الرحلات تم الغاؤها</a>
                                </li>
                                <li class="submenu-item ">
                                    <a href="{{route('trips.create')}}">اضافة رحلة</a>
                                </li>
                               
                            </ul>
                        </li>
                        @endcan
                
       
           
         
          
            @can('تصفح بيانات الطلاب')
         
                        <li class="sidebar-item active ">
                            <a href="{{route('students.index')}}" class='sidebar-link'>
                                <i class="bi bi-person-circle"></i>
                                <span>تصفح بيانات الطلاب</span>
                            </a>
                        </li>
                        @endcan
                        @can('تصفح قسم الانذارات')
                        <li class="sidebar-item active ">
                            <a href="{{route('alerts')}}" class='sidebar-link'>
                                <i class="bi bi-exclamation-triangle-fill"></i>
                                <span>قسم الانذارات</span>
                            </a>
                        </li>
                        @endcan
                        @can('تصفح قسم الاقتراحات')
                        
                        <li class="sidebar-item active ">
                            <a href="{{route('suggestions')}}" class='sidebar-link'>
                                <i class="bi bi-chat-left-text-fill"></i>
                                <span>قسم الاقتراحات</span>
                            </a>
                        </li>
                        @endcan
                        @can('تصفح قسم الاشعارات')
                        <li class="sidebar-item active ">
                            <a href="{{route('notifications_admin')}}" class='sidebar-link'>
                                <i class="bi bi-bell-fill"></i>
                                <span style="border-radius: 38px;"class="badge bg-danger"> {{ auth()->user()->unreadNotifications->count() }}
</span>
                                <span>قسم الاشعارات</span>

                            </a>
                        </li>
                    
                        @endcan
                    <!--
                        <li class="sidebar-item">
                            <a href="{{route('profile_admin')}}" class='sidebar-link'>
                                <i class="bi bi-gear"></i>
                                <span>اعدادات الحساب</span>
                            </a>
                        </li>
-->
@can('ادارة بيانات المستخدمين ')
          
                        <li class="sidebar-item">
                            <a href="{{ url('/' . ($page = 'users')) }}" class='sidebar-link'>
                                <i class="bi bi-person-lines-fill"></i>
                                <span> قائمة المستخدمين</span>
                            </a>
                        </li>
                        @endcan
                        @can('ادارة الصلاحيات ')
            
                        <li class="sidebar-item">
                            <a href="{{ url('/' . ($page = 'roles')) }}" class='sidebar-link'>
                                <i class="bi bi-patch-check-fill"></i>
                                <span>صلاحيات المستخدمين</span>
                            </a>
                        </li>
                        @endcan
                        <li class="sidebar-item">
                            <a href="{{ url('/' . ($page = 'logout')) }}" class='sidebar-link'>
                            <i class="bi bi-toggle2-off"></i>                                <span>تسجيل الخروج</span>
                            </a>
                        </li>
                    </ul>
                </div>
                <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
            </div>
        </div>