@extends('layouts.master')
@section('menu')
@extends('sidebar.sidebar')
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
                            <h3>ادارة المستخدمين</h3>
                            <p class="text-subtitle text-muted">تعديل مستخدم</p>
                        </div>
                        <div class="col-12 col-md-6 order-md-2 order-first">
                            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="">تعديل مستخدم</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">ادارة المستخدمين</li>
                                </ol>
                            </nav>
                        </div>
                        
                    </div>
                </div>
                @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <button aria-label="Close" class="close" data-dismiss="alert" type="button">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <strong>خطا</strong>
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                <!-- Basic Horizontal form layout section start -->
                <section id="basic-horizontal-layouts">
                    <div class="row match-height">
                        <div class="col-md-12 col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">بيانات الخط</h4>
                                </div>
                              
                                <div class="card-content">
                                    <div class="card-body">
                                        {!! Form::model($user, ['method' => 'PATCH','route' => ['users.update', $user->id]]) !!}

                                            <div class="form-body">
                                                <div class="">

                                                    <div class="row mg-b-20">
                                                        <div class="parsley-input col-md-6" id="fnWrapper">
                                                            <label>اسم المستخدم: <span class="tx-danger">*</span></label>
                                                            {!! Form::text('name', null, array('class' => 'form-control','required')) !!}
                                                        </div>
                                
                                                        <div class="parsley-input col-md-6 mg-t-20 mg-md-t-0" id="lnWrapper">
                                                            <label>البريد الالكتروني: <span class="tx-danger">*</span></label>
                                                            {!! Form::text('email', null, array('class' => 'form-control','required')) !!}
                                                        </div>
                                                    </div>
                                
                                                </div>
                                
                                                <div class="row mg-b-20">
                                                    <div class="parsley-input col-md-6 mg-t-20 mg-md-t-0" id="lnWrapper">
                                                        <label>كلمة المرور: <span class="tx-danger">*</span></label>
                                                        {!! Form::password('password', array('class' => 'form-control','required')) !!}
                                                    </div>
                                
                                                    <div class="parsley-input col-md-6 mg-t-20 mg-md-t-0" id="lnWrapper">
                                                        <label> تاكيد كلمة المرور: <span class="tx-danger">*</span></label>
                                                        {!! Form::password('confirm-password', array('class' => 'form-control','required')) !!}
                                                    </div>
                                                </div>
                                
                                                <div class="row row-sm mg-b-20">
                                                    <div class="col-lg-6">
                                                        <label class="form-label">حالة المستخدم</label>
                                                        <select name="Status" id="select-beast" class="form-control  nice-select  custom-select">
                                                            <option value="{{ $user->Status}}">{{ $user->Status}}</option>
                                                            <option value="مفعل">مفعل</option>
                                                            <option value="غير مفعل">غير مفعل</option>
                                                        </select>
                                                    </div>
                                                </div>
                                
                                                <div class="row mg-b-20">
                                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                                        <div class="form-group">
                                                            <strong>نوع المستخدم</strong>
                                                            {!! Form::select('roles[]', $roles,$userRole, array('class' => 'form-control','multiple'))
                                                            !!}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mg-t-30">
                                                    <button class="btn btn-main-primary pd-x-20" type="submit">تحديث</button>
                                                </div>
                                                {!! Form::close() !!}
   
                                    </div>
                                </div>
                            </div>
                        </div>









                        
                   
                    </div>
                </section>
                <!-- // Basic Horizontal form layout section end -->

            </div>

            {!! Form::close() !!}
            <footer>
                <div class="footer clearfix mb-0 text-muted">
                    <div class="float-start">
                        <p>2023 &copy; Student Ride</p>
                    </div>
                    <div class="float-end">
                        <p>Crafted with <span class="text-danger"><i class="bi bi-heart"></i></span> by <a
                                href="http://ahmadsaugi.com">Student Ride</a></p>
                    </div>
                </div>
            </footer>
        </div>
@endsection