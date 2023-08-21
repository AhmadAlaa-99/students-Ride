@extends('layouts.master')
@section('menu')
@extends('sidebar.sidebar')
@endsection
@section('content')
<!--
<style>
  .alert {
    border: none;
    border: 61%;
    border-radius: 55px;
    
}
  </style>

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
                <h3>الاشعارات</h3>
                <p class="text-subtitle text-muted">
               
                </p>
              </div>
              <div class="col-12 col-md-6 order-md-2 order-first">
                <nav
                  aria-label="breadcrumb"
                  class="breadcrumb-header float-start float-lg-end"
                >
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                      <a href="index.html">ادارة الاشعارات</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                    الاشعارات
                    </li>
                  </ol>
                </nav>
              </div>
            </div>
          </div>
          <section class="section">
            <div class="row">
          
              <div class="col-12 col-md-12">
                <div class="card">
                  <div class="card-header">
                    <h4>غير مقروءة {{ auth()->user()->unreadNotifications->count() }}</h4>
                  </div>
                  <div class="card-body">
                
                   
                  </div>
                </div>
             
              </div>
            </div>
          </section>
        </div>

        <footer>
          <div class="footer clearfix mb-0 text-muted">
            <div class="float-start">
              <p>2021 &copy; SoengSouy</p>
            </div>
            <div class="float-end">
              <p>
                Crafted with
                <span class="text-danger"><i class="bi bi-heart"></i></span> by
                <a href="http://soengsouy.com">A. Soeng Souy</a>
              </p>
            </div>
          </div>
        </footer>
      </div>
-->
<style>
  body{
  background-color: #fcfcfc;
}

.row{
  margin: auto;
    padding: 30px;
    width: 61%;
    display: flex;
    flex-flow: column;
    direction: rtl;

  .card{
    width: 100%;
    margin-bottom: 5px;
    display: block;
    transition: opacity 0.3s;
  }
}


.card-body{
  padding: 0.5rem;
  table{
    width: 100%;
    tr{
      display:flex;
      td{
        a.btn{
          font-size: 0.8rem;
          padding: 3px;
        }
      }
      td:nth-child(2){
        text-align:right;
        justify-content: space-around;
      }
    }
  }
  
}

.card-title:before{
  display:inline-block;
  font-family: 'Font Awesome\ 5 Free';
  font-weight:900;
  font-size: 1.1rem;
  text-align: center;
  border: 2px solid grey;
  border-radius: 100px;
  width: 30px;
  height: 30px;
  padding-bottom: 3px;
  margin-right: 10px;
}

.notification-invitation {
  .card-body {
    .card-title:before {
      color: #90CAF9;
      border-color: #90CAF9;
      content: "\f007";
    }
  }
}

.notification-warning {
  .card-body {
    .card-title:before {
      color: #FFE082;
      border-color: #FFE082;
      content: "\f071";
    }
  }
}

.notification-danger {
  .card-body {
    .card-title:before {
      color: #FFAB91;
      border-color: #FFAB91;
      content: "\f00d";
    }
  }
}

.notification-reminder {
  .card-body {
    .card-title:before {
      color: #CE93D8;
      border-color: #CE93D8;
      content: "\f017";
    }
  }
}

.card.display-none{
  display: none;
  transition: opacity 2s;
}


  </style>
<div class="row notification-container">
  <h2 class="text-center">قسم الاشعارات</h2>
  <p class="dismiss text-right"><a id="dismiss-all" href="{{route('mark_all_read')}}">حذف جميع الاشعارات</a></p>
  @foreach (auth()->user()->unreadNotifications as $notification)            
  <div class="card notification-card notification-reminder">
    <div class="card-body">
       <table>
      
        <tr>
      
          <td style="width:70%">
         
          <div class="">
          <div class="avatar bg-primary me-3">
                                <span class="avatar-content"><i class="bi bi-envelope"></i></span>
                            </div>
          {{ $notification->data['body'] }}
          </div></td>
          <td style="width:30%">
            <a href="{{ $notification->data['action'] }}" class="btn btn-primary">تفاصيل</a>
            <a href="{{ route('mark_As_read',$notification->id) }}" 
            class="btn btn-danger dismiss-notification">حذف</a>
          </td>
        </tr>
      </table>
    </div>
  </div>
  @endforeach
  
  
</div>
<script>
  const dismissAll = document.getElementById('dismiss-all');
const dismissBtns = Array.from(document.querySelectorAll('.dismiss-notification'));

const notificationCards = document.querySelectorAll('.notification-card');

dismissBtns.forEach(btn => {
  btn.addEventListener('click', function(e){
    e.preventDefault;
    var parent = e.target.parentElement.parentElement.parentElement.parentElement.parentElement.parentElement;
    parent.classList.add('display-none');
  })
});

dismissAll.addEventListener('click', function(e){
  e.preventDefault;
  notificationCards.forEach(card => {
    card.classList.add('display-none');
  });
  const row = document.querySelector('.notification-container');
  const message = document.createElement('h4');
  message.classList.add('text-center');
  message.innerHTML = 'All caught up!';
  row.appendChild(message);
})
  </script>
@endsection