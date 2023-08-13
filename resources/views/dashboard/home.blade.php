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
        <h3>احصائيات التطبيق</h3>
    </div>
    {{-- message --}}
    {!! Toastr::message() !!}
    <div class="page-content">
        <section class="row">
            <div class="col-12 col-lg-9">
                <div class="row">
                    <div class="col-6 col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body px-3 py-4-5">
                                <div class="row">
                                    <div class="col-md-4">
                                        
                                        <div class="avatar avatar-lg">
                                            <img src="images/Avatar_dri.png">
                            
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <h6 class="text-muted font-semibold">عدد السائقين</h6>
                                        <h6 class="font-extrabold mb-0">{{\App\Models\driver::count()}}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body px-3 py-4-5">
                                <div class="row">
                                    <div class="col-md-4">
                                    <div class="avatar avatar-lg">
                                            <img src="images/Avatar_stu.png">
                            
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <h6 class="text-muted font-semibold">عدد الطلاب</h6>
                                        <h6 class="font-extrabold mb-0">{{\App\Models\student::count()}}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body px-3 py-4-5">
                                <div class="row">
                                    <div class="col-md-4">
                                    <div class="avatar avatar-lg">
                                            <img src="images/Avatar_tri.png">
            
                                        </div>
                                    </div>
                                    
                                    
                                    <div class="col-md-8">
                                        <h6 class="text-muted font-semibold">عدد الرحلات</h6>
                                        <h6 class="font-extrabold mb-0">{{\App\Models\trip::count()}}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body px-3 py-4-5">
                                <div class="row">
                                    <div class="col-md-4">
                                    

                                      <div class="avatar avatar-lg">
                                            <img src="images/Avatar_lines.png">
            
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <h6 class="text-muted font-semibold">عدد الخطوط</h6>
                                        <h6 class="font-extrabold mb-0">{{\App\Models\line::count()}}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-xl-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>الرحلات المجدولة</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover table-lg">
                                        <thead>
                                            <tr>
                                                <th>اسم السائق</th>
                                                <th>بيانات الخط</th>
                                                <th>عدد الركاب</th>
                                                <th>تاريخ الرحلة</th>
                                                <th>التوقيت النهائي</th>
                                             
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($trips as $trip)
                                            <tr>
                                           
                                                <td class="col-3">
                                                    <div class="d-flex align-items-center">
                                                        <div class="avatar avatar-md">
                                                        <img src="images/Avatar_dri.png">
                                                        </div>
                                                        <p class="font-bold ms-3 mb-0">{{$trip->driver->full_name}}</p>
                                                    </div>
                                                </td>
                      <td>
                        <span class="badge bg-success">{{$trip->line->start}} - {{$trip->line->end}} - {{$trip->line->price}}</span>
                      </td>
                      <td>{{$trip->driver->num_stu}}</td>
                      
                      <td>{{$trip->trip_date}}</td>
                      <td>{{$trip->time_final}}</td>
                  
                                                
                                            </tr>
                                          
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            
            </div>
            <div class="col-12 col-lg-3">
                <div class="card" data-bs-toggle="modal" data-bs-target="#default">
                    <div class="card-body py-4 px-5">
                        <div class="d-flex align-items-center">
                            <div class="avatar avatar-xl">
                                <!-- {{ URL::to('/images/'. Auth::user()->avatar) }} -->
                                <img src="images/Avatar_adm.png" alt="{{ Auth::user()->avatar }}">
                            </div>
                            <div class="ms-3 name">
                                <h5 class="font-bold">{{ Auth::user()->name }}</h5>
                                <h6 class="text-muted mb-0">{{ Auth::user()->email }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            

                <div class="card">
                    <div class="card-header">
                        <h4>الذمم المالية</h4>
                    </div>
                    <div class="card-content pb-4">
                       
                  @foreach($dri as $dr )
                        <div class="recent-message d-flex px-4 py-3">
                            <div class="avatar avatar-lg">
                            <img src="images/Avatar_dri.png">
                               
                            </div>
                            <div class="name ms-4">
                                <h5 class="mb-1">{{$dr->full_name}}</h5>
                                <h6 class="text-muted mb-0">{{$dr->financial}}</h6>
                            </div>
                        </div>
                        @endforeach
                        
                     
                      <!--
                        <div class="px-4">
                            <button class='btn btn-block btn-xl btn-light-primary font-bold mt-3'>
                                تصفح بيانات</button>
                        </div>
-->
                    </div>
                </div>
             
            </div>
        </section>
    </div>

    <footer>
        <div class="footer clearfix mb-0 text-muted">
            <div class="float-start">
                <p>2021 &copy; Soeng Souy</p>
            </div>
            <div class="float-end">
                <p>Crafted with <span class="text-danger"><i class="bi bi-heart"></i></span> by <a
                href="http://souysoeng.com">Soeng Souy</a></p>
            </div>
        </div>
    </footer>
</div>
@endsection