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
                            <h3>ادارة خطوط النقل</h3>
                            <p class="text-subtitle text-muted">اضافة خط نقل</p>
                        </div>
                        <div class="col-12 col-md-6 order-md-2 order-first">
                            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.html">خطوط النقل</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">اضافة</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
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
                                    <form class="form form-horizontal" action="{{ route('lines.store') }}" method="post" enctype="multipart/form-data"
                        autocomplete="off"> 
                        {{ csrf_field() }}

                                        
                                            <div class="form-body">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label>محطة الانطلاق</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <input type="text" id="start" class="form-control"
                                                            name="start" placeholder="محطة الانطلاق">
                                                            @error('start')
    <div class="alert alert-danger">{{ $message }}</div>
@enderror
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label>محطة الوجهة</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <input type="text" id="email-id" class="form-control"
                                                            name="end" placeholder="محطة الوجهة">
                                                            @error('end')
    <div class="alert alert-danger">{{ $message }}</div>
@enderror
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label>اجرة الخط</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <input type="number" id="contact-info" class="form-control"
                                                            name="price" placeholder="اجرة الخط">
                                                            @error('price')
    <div class="alert alert-danger">{{ $message }}</div>
@enderror
                                                    </div>

</br>
                                                    <div class="col-sm-12 d-flex justify-content-end">
                                                        <button type="submit"
                                                            class="btn btn-primary me-1 mb-1">Submit</button>
                                                        <button type="reset"
                                                            class="btn btn-light-secondary me-1 mb-1">Reset</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>









                        
                   
                    </div>
                </section>
                <!-- // Basic Horizontal form layout section end -->

            </div>

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