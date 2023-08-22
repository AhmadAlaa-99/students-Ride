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
                            <h3>ادارة الرحلات</h3>
                            <p class="text-subtitle text-muted">اضافة رحلة</p>
                        </div>
                        <div class="col-12 col-md-6 order-md-2 order-first">
                            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.html">ادارة الرحلات</a></li>
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
                                    <h4 class="card-title">بيانات الرحلة</h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                    <form class="form form-horizontal" action="{{ route('trips.store') }}" method="post" enctype="multipart/form-data"
                        autocomplete="off"> 
                        {{ csrf_field() }}

   
                                            <div class="form-body">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label>تاريخ الرحلة</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <input type="date" id="start" class="form-control"
                                                            name="trip_date" placeholder="تاريخ الرحلة">
                                                            @error('trip_date')
    <div class="alert alert-danger">{{ $message }}</div>
@enderror
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label>اوقات الرحلة</label>
                                                    </div>
                                                    <div class="col-md-2 form-group">
                                                        <input type="time" id="email-id" class="form-control"
                                                            name="time_1" placeholder="EX : 9:20,9:40,9:60">
                                                            @error('time_1')
    <div class="alert alert-danger">{{ $message }}</div>
@enderror
                                                    </div>
                                                    <div class="col-md-2 form-group">
                                                        <input type="time" id="email-id" class="form-control"
                                                            name="time_2" placeholder="EX : 9:20,9:40,9:60">
                                                            @error('time_2')
    <div class="alert alert-danger">{{ $message }}</div>
@enderror
                                                    </div>
                                                    <div class="col-md-2 form-group">
                                                        <input type="time" id="email-id" class="form-control"
                                                            name="time_3" placeholder="EX : 9:20,9:40,9:60">
                                                            @error('time_3')
    <div class="alert alert-danger">{{ $message }}</div>
@enderror
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label> السائق</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                    <div class="input-group mb-3">
                                                    <label class="input-group-text"
                                                        for="inputGroupSelect01">Options</label>
                                                    <select class="form-select" name="driver_id"id="inputGroupSelect01">
                                                        <option selected>Select Driver...</option>
                                                        @foreach($drivers as $driver)
                                                        <option value="{{$driver->id}}">{{$driver->full_name}}</option>
                                                        @endforeach
                                                      
                                                    </select>
                                                    @error('driver_id')
    <div class="alert alert-danger">{{ $message }}
        
    </div>
@enderror
                                                </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <label>الخط</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                    <div class="input-group mb-3">
                                                    <label class="input-group-text"
                                                        for="inputGroupSelect01">Options</label>
                                                    <select class="form-select" name="line_id"id="inputGroupSelect01">
                                                        <option selected>Select Line...</option>
                                                        @foreach($lines as $line)
                                                        <option value="{{$line->id}}">{{$line->start}} - {{$line->end}} - {{$line->price}}</option>
                                                        @endforeach
                                                      
                                                    </select>
                                                    @error('line_id')
    <div class="alert alert-danger">{{ $message }}</div>
@enderror
                                                </div>
                                                    </div>

                                              
                                                
                                           
                                                </div>
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