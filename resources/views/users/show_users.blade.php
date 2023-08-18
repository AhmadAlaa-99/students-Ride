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
<style>
  .badge {
 
    color: #ff0018;
 
}
  </style>
@section('js')
     <script src="{{ URL::to('assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js') }} "></script>
     <script src="{{ URL::to('assets/vendors/perfect-scrollbar/perfect-scrollbar.css') }} "></script>
     <script src="{{ URL::to('assets/vendors/bootstrap-icons/bootstrap-icons.css') }} "></script>
@endsection
@section('content')
@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
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
                <h3>ادارة المستخدمين</h3>
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
                      <a href="index.html">بيانات المستخدمين</a>
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
              <div class="card-body">
              <div class="col-sm-1 col-md-2">
                        <a class="btn btn-primary btn-sm" href="{{ route('users.create') }}">اضافة مستخدم</a>
                </div>
                <table class="table table-striped" id="table1">
                  <thead>
                    <tr>
                      <th class="wd-10p border-bottom-0">#</th>
                      <th class="wd-15p border-bottom-0">اسم المستخدم</th>
                      <th class="wd-20p border-bottom-0">البريد الالكتروني</th>
                      <th class="wd-15p border-bottom-0">حالة المستخدم</th>
                      <th class="wd-15p border-bottom-0">نوع المستخدم</th>
                      <th class="wd-10p border-bottom-0">العمليات</th>
                    </tr>
                  </thead>
                  <tbody>
                                 @php
                                $i = 0;
                                @endphp
                                @foreach ($data as $key => $user)
                                <tr>
                                    <td>{{ ++$i }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        @if ($user->Status == 'مفعل')
                                            <span class="modal-effect btn btn-sm btn-danger">
                                                <div class="dot-label bg-success ml-1"></div>{{ $user->Status }}
                                            </span>
                                        @else
                                            <span class="modal-effect btn btn-sm btn-danger">
                                                <div class="dot-label bg-danger ml-1"></div>{{ $user->Status }}
                                            </span>
                                        @endif
                                    </td>

                                    <td>
                                        @if (!empty($user->getRoleNames()))
                                            @foreach ($user->getRoleNames() as $v)
                                                <label class="btn btn-sm btn-info" >{{ $v }}</label>
                                            @endforeach
                                        @endif
                                    </td>

                                    <td>
                                            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-info"
                                                title="تعديل"><i class="las la-pen"></i>تعديل</a>

                                            <a class="modal-effect btn btn-sm btn-danger" 
                                        
                                              href="#modaldemo8" title="حذف"><i
                                                    class="las la-trash"></i>حذف</a>
                                    </td>
                                </tr>
                                
                          @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </section>
        </div>
   <!-- Modal effects -->

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
      
<script>
  $('#modaldemo8').on('show.bs.modal', function(event) {
      var button = $(event.relatedTarget)
      var user_id = button.data('user_id')
      var username = button.data('username')
      var modal = $(this)
      modal.find('.modal-body #user_id').val(user_id);
      modal.find('.modal-body #username').val(username);
  })

</script>
@endsection