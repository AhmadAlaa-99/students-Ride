@extends('layouts.master')
@section('menu')
@extends('sidebar.sidebar')
@endsection
@section('css')
<link rel="preconnect" href="https://fonts.gstatic.com">

    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ URL::to('assets/vendors/dripicons/webfont.css') }}">
    <link rel="stylesheet" href="{{ URL::to('assets/css/pages/dripicons.css') }}">
    <link rel="stylesheet" href="{{ URL::to('assets/vendors/perfect-scrollbar/perfect-scrollbar.css') }}">
    <link rel="stylesheet" href="{{ URL::to('assets/vendors/bootstrap-icons/bootstrap-icons.css') }}">

   
@endsection
@section('js')
     <script src="{{ URL::to('assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js') }} "></script>
     <script src="{{ URL::to('assets/vendors/perfect-scrollbar/perfect-scrollbar.css') }} "></script>
     <script src="{{ URL::to('assets/vendors/bootstrap-icons/bootstrap-icons.css') }} "></script>
@endsection
@section('content')
<div id="main">
        <header class="mb-3">
          <a href="#" class="burger-btn d-block d-xl-none">
            <i class="bi bi-justify fs-3"></i>
          </a>
        </header>

        <div class="page-heading">
          <div class="page-title">
            <div class="row">
              <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>ادارة بيانات السائقين</h3>
                <p class="text-subtitle text-muted">
                  عرض بيانات السائقين
                </p>
              </div>
              <div class="col-12 col-md-6 order-md-2 order-first">
                <nav
                  aria-label="breadcrumb"
                  class="breadcrumb-header float-start float-lg-end"
                >
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                      <a href="index.html">بيانات السائقين</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                      عرض البيانات
                    </li>
                  </ol>
                </nav>
              </div>
            </div>
          </div>
          <section class="section">
            <div class="card">
              <div class="card-header">بيانات السائقين </div>
              <div class="card-body">
                <table class="table table-striped" id="table1">
                  <thead>
                    <tr>
                    <th>#</th>
                      <th>الاسم الكامل</th>
                      <th>البريد الالكتروني</th>
                      <th>العمر</th>
                      <th>الجنس</th>
                      <th>الرقم</th>
                      <th>تاريخ بداية التسجيل</th>
                      <th>تاريخ نهاية التسجيل</th>
                      <th>رقم المركبة</th>
                      <th>نوع المركبة</th>
                      <th>عدد الركاب</th>
                      <th>المحفظة</th>
                      <th>العقد</th>
                      <th>حالة الحساب</th>
                      <th>عدد الانذارات</th>
                      <th> تفاصيل الرحلات</th>
                      <th>العمليات</th>
                    </tr>
                  </thead>
                  <tbody>
                  @php
                                $i = 0;
                                @endphp
                                @foreach ($drivers as $driver)
                                    @php
                                    $i++
                                    @endphp
                    <tr>
                    <td>{{ $i }}</td>

    
                      <td>{{$driver->full_name}}</td>
                      <td>{{$driver->email}}</td>
                      <td>{{$driver->age}}</td>
                      <td>
                        <span class="badge bg-success">{{$driver->gender}}</span>
                      </td>
                      <td>{{$driver->phone_number}}</td>
                      <td>{{$driver->date_reg}}</td>
                      <td>{{$driver->data_reg_end}}</td>
                      <td>
                        <span class="badge bg-success">{{$driver->vehicle_number}}</span>
                      </td>
                      <td>{{$driver->vehicle_type}}</td>
                      <td>{{$driver->num_stu}}</td>
                      <td>{{$driver->financial}}</td>
                      
                      <td>
                        
                    

                     <a class="btn btn-outline-info btn-sm"
                                                           href="{{route('down.contract_file',$driver->id)}}"
                                                                            role="button"><i
                                                                                class="fas fa-download"></i>&nbsp;
                                                                            تحميل</a>


                      </td>
                      <td>{{$driver->status}}</td>
                      <td>{{$driver->alert_count}}</td>
                      <td><a href="{{route('driver_trips',$driver->id)}}">driver_trips</a></td>
                      <td>
                        <div style="display: flex;">
                        <a href="#" title="تعديل الحساب">
                        <div class="icon dripicons-trash"></div>
                        </a>
                        <a href="" title="حذف الحساب">
                        <div class="icon dripicons-blog"></div>
                        </a>
                        @if($driver->status=="active")
                  
                          <a href="{{route('inactive_driver',$driver->id)}}" title="الغاء تفعيل الحساب">
                        <div class="icon dripicons-document-edit"></div>
                        </a>

                        <a href="{{route('driver_sendalert',$driver->id)}}" title=" ارسال انذار">
                        <div class="icon dripicons-document-edit"></div>
                        </a>

                        
                        @else
                        
                          <a href="{{route('active_driver',$driver->id)}}" title="تفعيل الحساب">
                        <div class="icon dripicons-document-edit"></div>
                        </a>

                        
                        @endif
                    
                      
                        </td>
                   
                
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </section>
        </div>

        <footer>
          <div class="footer clearfix mb-0 text-muted">
            <div class="float-start">
              <p>2023 &copy; Student Ride</p>
            </div>
            <div class="float-end">
              <p>
                Crafted with
                <span class="text-danger"><i class="bi bi-heart"></i></span> by
                <a href="">Student Ride</a>
              </p>
            </div>
          </div>
        </footer>
      </div>
@endsection