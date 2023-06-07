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
                            <h3>ادارة بيانات السائقين</h3>
                            <p class="text-subtitle text-muted">اضافة سائق</p>
                        </div>
                        <div class="col-12 col-md-6 order-md-2 order-first">
                            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.html">بيانات السائقين</a></li>
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
                                    <h4 class="card-title">بيانات السائق</h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                    <form class="form form-horizontal" action="{{ route('drivers.store') }}" method="post" enctype="multipart/form-data"
                        autocomplete="off"> 
                        {{ csrf_field() }}

                      

                                            <div class="form-body">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label>الاسم الكامل</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <input type="text" id="start" class="form-control"
                                                            name="full_name" placeholder="الاسم الكامل">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label>البريد الالكتروني</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <input type="text" id="email" class="form-control"
                                                            name="email" placeholder="البريد الالكتروني">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label>كلمة السر</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <input type="number" id="contact-info" class="form-control"
                                                            name="password" placeholder="كلمة السر">
                                                    </div>

                                                    <div class="col-md-4">
                                                        <label>رقم الهاتف</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <input type="number" id="contact-info" class="form-control"
                                                            name="phone_number" placeholder="رقم الهاتف">
                                                    </div>


                                                    <div class="col-md-4">
                                                        <label>العمر</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <input type="number" id="contact-info" class="form-control"
                                                            name="age" placeholder="العمر">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label>الجنس</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">

                                                    <div class="input-group mb-3">
                                                    <label class="input-group-text"
                                                        for="inputGroupSelect01">Options</label>
                                                    <select class="form-select" name="gender"id="inputGroupSelect01">
                                                        <option selected>Select Gender...</option>
                                                        <option value="male">male</option>
                                                        <option value="female">female</option>
                                                      
                                                    </select>
                                                </div>
                                                
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label>تاريخ بداية العقد</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <input type="date" id="contact-info" class="form-control"
                                                            name="date_reg" placeholder="تاريخ بداية العقد">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label>تاريح نهاية العقد</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <input type="date" id="contact-info" class="form-control"
                                                            name="data_reg_end" placeholder="تاريخ نهاية العقد">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label>رقم المركبة</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <input type="text" id="contact-info" class="form-control"
                                                            name="vehicle_number" placeholder="رقم المركبة">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label>نوع المركبة</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <input type="text" id="contact-info" class="form-control"
                                                            name="vehicle_type" placeholder="نوع المركبة">
                                                    </div>
                                                  
                                                    <div class="col-md-4">
                                                        <label>عدد الركاب</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <input type="number" id="contact-info" class="form-control"
                                                            name="num_stu" placeholder="عدد الركاب ">
                                                    </div>

                                                    <div class="col-md-4">
                                                        <label>ملفات العقد</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <input type="file" id="contact-info" class="form-control"
                                                            name="portfolio" placeholder="ملف العقد">
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