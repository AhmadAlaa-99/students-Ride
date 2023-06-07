@extends('layouts.master')
@section('menu')
@extends('sidebar.sidebar')
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" >
@endsection
@section('content')
<div id="main">
    <header class="mb-3">
        <a href="#" class="burger-btn d-block d-xl-none">
            <i class="bi bi-justify fs-3"></i>
        </a>
    </header>
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Form Checkbox Information</h3>
                <p class="text-subtitle text-muted">Form checkbox</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Form Checkbox</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    

<style>
    /*  customize check box radio*/
    label{
        display:block;
        line-height:25px;
    }
    .option-input {
        -webkit-appearance: none;
        -moz-appearance: none;
        -ms-appearance: none;
        -o-appearance: none;
        appearance: none;
        position: relative;
        top: 8px;
        right: 0;
        bottom: 0;
        left: 0;
        height: 25px;
        width: 25px;
        transition: all 0.15s ease-out 0s;
        background: #cbd1d8;
        border: none;
        color: #fff;
        cursor: pointer;
        display: inline-block;
        margin-right: 0.5rem;
        outline: none;
        position: relative;
        z-index: 1000;
    }
    .option-input:hover {
        background: #9faab7;
    }
    .option-input:checked {
        background: #5ddab4;
    }
    .option-input:checked::before {
        width: 25px;
        height: 25px;
        display:flex;
        content: '\f00c';
        font-size: 15px;
        font-weight:bold;
        position: absolute;
        align-items:center;
        justify-content:center;
        font-family:'Font Awesome 5 Free';
    }
    .option-input:checked::after {
        -webkit-animation: click-wave 0.65s;
        -moz-animation: click-wave 0.65s;
        animation: click-wave 0.65s;
        background: #5ddab4;
        content: '';
        display: block;
        position: relative;
        z-index: 100;
    }
    .option-input.radio {
        border-radius: 50%;
    }
    .option-input.radio::after {
        border-radius: 50%;
    }

    @keyframes click-wave {
    0% {
        height: 25px;
        width: 25px;
        opacity: 0.35;
        position: relative;
    }
    100% {
        height: 150px;
        width: 150px;
        margin-left: -60px;
        margin-top: -60px;
        opacity: 0;
    }
    }
    /* end customize check box radio*/
</style>

    {{-- message --}}
    {!! Toastr::message() !!}

    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Form Checkbox Save</h4>
            </div>
            <div class="card-content">
                <div class="card-body">
                    <form class="form form-horizontal" action="{{ route('form/checkbox/save') }}" method="POST">
                        @csrf
                        <div class="form-body">
                            <div class="row">
                                <div class="radio">
                                    <label>Question 1</label>
                                </div>
                                <div class="radio">
                                    <label><input type="radio" class="option-input radio" name="question1" value="A">A</label>
                                    <label><input type="radio" class="option-input radio" name="question1" value="B">B</label>
                                    <label><input type="radio" class="option-input radio" name="question1" value="C">C</label>
                                </div>
                                <div class="radio">
                                    <label>Question 2</label>
                                </div>
                                <div class="radio">
                                    <label><input type="radio" class="option-input radio" name="question2" value="A">A</label>
                                    <label><input type="radio" class="option-input radio" name="question2" value="B">B</label>
                                    <label><input type="radio" class="option-input radio" name="question2" value="C">C</label>
                                </div>
                                <div class="radio">
                                    <label>Question 3</label>
                                </div>
                                <div class="radio">
                                    <label><input type="radio" class="option-input radio" name="question3" value="A">A</label>
                                    <label><input type="radio" class="option-input radio" name="question3" value="B">B</label>
                                    <label><input type="radio" class="option-input radio" name="question3" value="C">C</label>
                                </div>
                            </div>
                             <br>
                            <div class="col-12 d-flex justify-left-end">
                                <button type="submit" class="btn btn-primary me-1 mb-1">Save</button>
                                <button type="reset" class="btn btn-light-secondary me-1 mb-1">Cannel</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection