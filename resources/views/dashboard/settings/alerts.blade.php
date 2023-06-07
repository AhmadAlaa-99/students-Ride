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
                <h3>ادارة الانذارات</h3>
                <p class="text-subtitle text-muted">
                  عرض بيانات المستخدمين
                </p>
              </div>
              <div class="col-12 col-md-6 order-md-2 order-first">
                <nav
                  aria-label="breadcrumb"
                  class="breadcrumb-header float-start float-lg-end"
                >
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                      <a href="index.html">انذارات المستخدمين</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                      عرض الانذارات
                    </li>
                  </ol>
                </nav>
              </div>
            </div>
          </div>
          <section class="section">
            <div class="card">
              <div class="card-header">بيانات الطلاب </div>
              <div class="card-body">
                <table class="table table-striped" id="table1">
                  <thead>
                    <tr>
                    <th>#</th>
                      <th>الاسم</th>
                      <th>البريد الالكتروني</th>     
                      <th>عدد الانذارات</th>
                    </tr>
                  </thead>
                  <tbody>
                                 @php
                                $i = 0;
                                @endphp
                                @foreach ($students as $student)
                                    @php
                                    $i++
                                    @endphp
                    <tr>
                    <td>{{ $i }}</td>
                      <td>
                      


                      <span class="badge bg-warning">{{$student->full_name}}</span>
                        
                      </td>
                      <td>
                      <span class="badge bg-warning">{{$student->email}}</span>
                        </td>
                      <td>
                      <span class="badge bg-danger">{{$student->alert_count}}</span>
                      </td>
                 
              
</div>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </section>



          <section class="section">
            <div class="card">
              <div class="card-header">بيانات السائقين </div>
              <div class="card-body">
                <table class="table table-striped" id="table1">
                  <thead>
                    <tr>
                    <th>#</th>
                      <th>الاسم</th>
                      <th>البريد الالكتروني</th>     
                      <th>عدد الانذارات</th>
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
                      <td>
                      


                      <span class="badge bg-warning">{{$driver->full_name}}</span>
                        
                      </td>
                      <td>
                      <span class="badge bg-warning">{{$driver->email}}</span>
                        </td>
                      <td>
                      <span class="badge bg-danger">{{$driver->alert_count}}</span>
                      </td>
                      <td>
                        <div style="display: flex;">
                        <a href="#" title="الغاء تفعيل الحساب">
                        <div class="icon dripicons-trash"></div>
                        </a>
                        <a href="#" title="ارسال انذار">
                        <div class="icon dripicons-blog"></div>
                        </a>
                   
                        </td>
                 
              
</div>
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