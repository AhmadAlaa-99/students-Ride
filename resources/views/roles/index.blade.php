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


@if (session()->has('Add'))
    <script>
        window.onload = function() {
            notif({
                msg: " تم اضافة الصلاحية بنجاح",
                type: "success"
            });
        }

    </script>
@endif

@if (session()->has('edit'))
    <script>
        window.onload = function() {
            notif({
                msg: " تم تحديث بيانات الصلاحية بنجاح",
                type: "success"
            });
        }

    </script>
@endif

@if (session()->has('delete'))
    <script>
        window.onload = function() {
            notif({
                msg: " تم حذف الصلاحية بنجاح",
                type: "error"
            });
        }

    </script>
@endif
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
                <h3>صلاحيات المستخدمين</h3>
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
                      <a href="index.html">صلاحيات المستخدمين</a>
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
                <a class="btn btn-primary btn-sm" href="{{ route('roles.create') }}">اضافة</a>
              </div>
                <table class="table table-striped" id="table1">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>الاسم</th>
                      <th>العمليات</th>
                  </tr>
                  </thead>
                  <tbody>
                    @foreach ($roles as $key => $role)
                        <tr>
                            <td>{{ ++$i }}</td>
                            <td>{{ $role->name }}</td>
                            <td>
                                @can('عرض صلاحية')
                                    <a class="btn btn-success btn-sm"
                                        href="{{ route('roles.show', $role->id) }}">عرض</a>
                                @endcan
                                
                                @can('تعديل صلاحية')
                                    <a class="btn btn-primary btn-sm"
                                        href="{{ route('roles.edit', $role->id) }}">تعديل</a>
                                @endcan

                                @if ($role->name !== 'owner')
                                    @can('حذف صلاحية')
                                        {!! Form::open(['method' => 'DELETE', 'route' => ['roles.destroy',
                                        $role->id], 'style' => 'display:inline']) !!}
                                        {!! Form::submit('حذف', ['class' => 'btn btn-danger btn-sm']) !!}
                                        {!! Form::close() !!}
                                    @endcan
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