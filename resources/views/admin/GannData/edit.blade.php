@extends('admin.layouts.admin-layout')

@section('title', 'Gann Stocks')

@section('content')

    {{-- Page Title --}}
    <div class="pagetitle">
        <h1>Gann Dates</h1>
        <div class="row">
            <div class="col-md-8">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active"> <a
                                href="{{ route('dashboard') }}">{{ trans('label.Dashboard') }}</a> </li>
                        <li class="breadcrumb-item active"> <a href="{{ route('gannStokes.index') }}">Gann Stocks</a> </li>
                        <li class="breadcrumb-item active">GannStocks View</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    {{-- Clients Card --}}
    <div class="gann_date_page">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <form action="{{ route('gannStocks.update') }}" method="POST" id="GannForm">
                    @csrf
                    <input type="hidden" name="id" class="form-control" value="{{ $GannData->id }}">
                    <div id="loader" style="display: none;">
                        <img src="https://i.gifer.com/ZKZg.gif" alt="Loading...">
                    </div>
                    <div class="gann_date_main">
                        <div class="gann_date_head">
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <div class="form-group">
                                        <label for="Stokes" class="form-label"><strong>Stocks</strong>
                                            <span class="text-danger"></span></label>
                                        <input type="text" name="stokes" class="form-control" value="{{ $GannData->stokes }}" >
                                    </div>
                                </div>
                            </div>
                            <div class="row align-items-center mt-4">
                                <div class="col-md-5">
                                    <div class="gann_date_head_title">
                                        <h4>Enter Any High / Low Date</h4>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="gann_start_date">
                                        <input type="text" class="form-control date" name="d_0" id="date" value="{{ $GannData->d_0 ?? '' }}">
                                    </div>
                                    <div id="date_error" style="color: red;"></div>
                                </div>
                                <div class="col-md-3 text-end">
                                    <div class="calculate_btn btn-group">
                                        <button id="calculateBtn" class="btn">Calculate</button>
                                        <button id="fetchDataBtn" class="btn"><i class="bi bi-bootstrap-reboot"></i></button>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="gann_date_field">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="gann_date_field_inr">
                                        <div class="row align-items-center">
                                            <div class="col-md-4">
                                            </div>
                                            <div class="col-md-3">
                                                <h5>Low Price</h5>
                                            </div>
                                            <div class="col-md-3">
                                                <h5>High Price</h5>
                                            </div>
                                            <div class="col-md-2">
                                                <h5>Close</h5>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="gann_date_field_inr">
                                        <div class="row align-items-center">
                                            <div class="col-md-1">
                                                <div class="gann_date_degree">
                                                    <h4>0°</h4>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="">
                                                    <input type="text" value="{{ $GannData->d_0 ?? '' }}" class="form-control" disabled>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="">
                                                    <input type="text" name="price_low_0" value="{{ $GannData->price_low_0 ?? ''}}"class="form-control low-price">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="">
                                                    <input type="text" name="price_high_0" value="{{ $GannData->price_high_0 ?? ''}}"class="form-control high-price">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="">
                                                    <input type="text" name="close_0" value="{{ $GannData->close_0 ?? '' }}" class="form-control close-price">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="gann_date_field_inr">
                                        <div class="row align-items-center">
                                            <div class="col-md-1">
                                                <div class="gann_date_degree">
                                                    <h4>30°</h4>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="gann_date_dates">
                                                    <input type="text" name="d_30" value="{{ $GannData->d_30 }}" class="form-control" >
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="">
                                                    <input type="text" name="price_low_30" value="{{ $GannData->price_low_30 ?? ''}}"class="form-control low-price">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="">
                                                    <input type="text" name="price_high_30" value="{{ $GannData->price_high_30 ?? ''}}"class="form-control high-price">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="">
                                                    <input type="text" name="close_30" value="{{ $GannData->close_30 ?? '' }}" class="form-control close-price">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="gann_date_field_inr">
                                        <div class="row align-items-center">
                                            <div class="col-md-1">
                                                <div class="gann_date_degree">
                                                    <h4>45°</h4>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="gann_date_dates">
                                                    <input type="text" name="d_45" value="{{ $GannData->d_45 }}" class="form-control" >
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="">
                                                    <input type="text" name="price_low_45" value="{{ $GannData->price_low_45 ?? ''}}"class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="">
                                                    <input type="text" name="price_high_45" value="{{ $GannData->price_high_45 ?? ''}}" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="">
                                                    <input type="text" name="close_45" value="{{ $GannData->close_45 ?? ''}}"class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="gann_date_field_inr">
                                        <div class="row align-items-center">
                                            <div class="col-md-1">
                                                <div class="gann_date_degree">
                                                    <h4>60°</h4>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="gann_date_dates">
                                                    <input type="text" name="d_60" value="{{ $GannData->d_60 }}" class="form-control" >
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="">
                                                    <input type="text" name="price_low_60" value="{{ $GannData->price_low_60 ?? ''}}"class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="">
                                                    <input type="text" name="price_high_60" value="{{ $GannData->price_high_60 ?? ''}}" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="">
                                                    <input type="text" name="close_60" value="{{ $GannData->close_60 ?? ''}}" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="gann_date_field_inr">
                                        <div class="row align-items-center">
                                            <div class="col-md-1">
                                                <div class="gann_date_degree">
                                                    <h4>72°</h4>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="gann_date_dates">
                                                    <input type="text" name="d_72" value="{{ $GannData->d_72 }}" class="form-control" >
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="">
                                                    <input type="text" name="price_low_72" value="{{ $GannData->price_low_72 ?? ''}}"class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="">
                                                    <input type="text" name="price_high_72" value="{{ $GannData->price_high_72 ?? ''}}"class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="">
                                                    <input type="text" name="close_72" value="{{ $GannData->close_72 ?? ''}}" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="gann_date_field_inr">
                                        <div class="row align-items-center">
                                            <div class="col-md-1">
                                                <div class="gann_date_degree">
                                                    <h4>90°</h4>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="gann_date_dates">
                                                    <input type="text" name="d_90" value="{{ $GannData->d_90 }}" class="form-control" >
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="">
                                                    <input type="text" name="price_low_90" value="{{ $GannData->price_low_90 ?? ''}}" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="">
                                                    <input type="text" name="price_high_90" value="{{ $GannData->price_high_90 ?? ''}}" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="">
                                                    <input type="text" name="close_90" value="{{ $GannData->close_90 ?? ''}}"class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="gann_date_field_inr">
                                        <div class="row align-items-center">
                                            <div class="col-md-1">
                                                <div class="gann_date_degree">
                                                    <h4>120°</h4>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="gann_date_dates">
                                                    <input type="text" name="d_120" value="{{ $GannData->d_120 }}" class="form-control" >
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="">
                                                    <input type="text" name="price_low_120" value="{{ $GannData->price_low_120 ?? ''}}" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="">
                                                    <input type="text" name="price_high_120" value="{{ $GannData->price_high_120 ?? ''}}" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="">
                                                    <input type="text" name="close_120" value="{{ $GannData->close_120 ?? ''}}" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="gann_date_field_inr">
                                        <div class="row align-items-center">
                                            <div class="col-md-1">
                                                <div class="gann_date_degree">
                                                    <h4>135°</h4>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="gann_date_dates">
                                                    <input type="text" name="d_135" value="{{ $GannData->d_135 }}" class="form-control" >
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="">
                                                    <input type="text" name="price_low_135" value="{{ $GannData->price_low_135 ?? ''}}" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="">
                                                    <input type="text" name="price_high_135" value="{{ $GannData->price_high_135 ?? ''}}" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="">
                                                    <input type="text" name="close_135" value="{{ $GannData->close_135 ?? ''}}" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="gann_date_field_inr">
                                        <div class="row align-items-center">
                                            <div class="col-md-1">
                                                <div class="gann_date_degree">
                                                    <h4>150°</h4>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="gann_date_dates">
                                                    <input type="text" name="d_150" value="{{ $GannData->d_150 }}" class="form-control" >
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="">
                                                    <input type="text" name="price_low_150" value="{{ $GannData->price_low_150 ?? ''}}" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="">
                                                    <input type="text" name="price_high_150" value="{{ $GannData->price_high_150 ?? ''}}" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="">
                                                    <input type="text" name="close_150" value="{{ $GannData->close_150 ?? ''}}" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="gann_date_field_inr">
                                        <div class="row align-items-center">
                                            <div class="col-md-1">
                                                <div class="gann_date_degree">
                                                    <h4>180°</h4>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="gann_date_dates">
                                                    <input type="text" name="d_180" value="{{ $GannData->d_180 }}" class="form-control" >
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="">
                                                    <input type="text" name="price_low_180" value="{{ $GannData->price_low_180 ?? ''}}" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="">
                                                    <input type="text" name="price_high_180" value="{{ $GannData->price_high_180 ?? ''}}" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="">
                                                    <input type="text" name="close_180" value="{{ $GannData->close_180 ?? ''}}" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="gann_date_field_inr">
                                        <div class="row align-items-center">
                                            <div class="col-md-1">
                                                <div class="gann_date_degree">
                                                    <h4>210°</h4>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="gann_date_dates">
                                                    <input type="text" name="d_210" value="{{ $GannData->d_210 }}" class="form-control" >
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="">
                                                    <input type="text" name="price_low_210" value="{{ $GannData->price_low_210 ?? ''}}" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="">
                                                    <input type="text" name="price_high_210" value="{{ $GannData->price_high_210 ?? ''}}" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="">
                                                    <input type="text" name="close_210" value="{{ $GannData->close_210 ?? ''}}" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="gann_date_field_inr">
                                        <div class="row align-items-center">
                                            <div class="col-md-1">
                                                <div class="gann_date_degree">
                                                    <h4>225°</h4>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="gann_date_dates">
                                                    <input type="text" name="d_225" value="{{ $GannData->d_225 }}" class="form-control" >
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="">
                                                    <input type="text" name="price_low_225" value="{{ $GannData->price_low_225 ?? ''}}" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="">
                                                    <input type="text" name="price_high_225" value="{{ $GannData->price_high_225 ?? ''}}" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="">
                                                    <input type="text" name="close_225" value="{{ $GannData->close_225 ?? ''}}" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="gann_date_field_inr">
                                        <div class="row align-items-center">
                                            <div class="col-md-1">
                                                <div class="gann_date_degree">
                                                    <h4>240°</h4>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="gann_date_dates">
                                                    <input type="text" name="d_240" value="{{ $GannData->d_240 }}" class="form-control" >
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="">
                                                    <input type="text" name="price_low_240" value="{{ $GannData->price_low_240 ?? ''}}" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="">
                                                    <input type="text" name="price_high_240" value="{{ $GannData->price_high_240 ?? ''}}" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="">
                                                    <input type="text" name="close_240" value="{{ $GannData->close_240 ?? ''}}" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="gann_date_field_inr">
                                        <div class="row align-items-center">
                                            <div class="col-md-1">
                                                <div class="gann_date_degree">
                                                    <h4>252°</h4>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="gann_date_dates">
                                                    <input type="text" name="d_252" value="{{ $GannData->d_252 }}" class="form-control" >
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="">
                                                    <input type="text" name="price_low_252" value="{{ $GannData->price_low_252 ?? ''}}" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="">
                                                    <input type="text" name="price_high_252" value="{{ $GannData->price_high_252 ?? ''}}" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="">
                                                    <input type="text" name="close_252" value="{{ $GannData->close_252 ?? ''}}" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="gann_date_field_inr">
                                        <div class="row align-items-center">
                                            <div class="col-md-1">
                                                <div class="gann_date_degree">
                                                    <h4>270°</h4>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="gann_date_dates">
                                                    <input type="text" name="d_270" value="{{ $GannData->d_270 }}" class="form-control" >
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="">
                                                    <input type="text" name="price_low_270" value="{{ $GannData->price_low_270 ?? ''}}" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="">
                                                    <input type="text" name="price_high_270" value="{{ $GannData->price_high_270 ?? ''}}" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="">
                                                    <input type="text" name="close_270" value="{{ $GannData->close_270 ?? ''}}" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="gann_date_field_inr">
                                        <div class="row align-items-center">
                                            <div class="col-md-1">
                                                <div class="gann_date_degree">
                                                    <h4>288°</h4>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="gann_date_dates">
                                                    <input type="text" name="d_288" value="{{ $GannData->d_288 }}" class="form-control" >
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="">
                                                    <input type="text" name="price_low_288" value="{{ $GannData->price_low_288 ?? ''}}" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="">
                                                    <input type="text" name="price_high_288" value="{{ $GannData->price_high_288 ?? ''}}" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="">
                                                    <input type="text" name="close_288" value="{{ $GannData->close_288 ?? ''}}" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="gann_date_field_inr">
                                        <div class="row align-items-center">
                                            <div class="col-md-1">
                                                <div class="gann_date_degree">
                                                    <h4>300°</h4>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="gann_date_dates">
                                                    <input type="text" name="d_300" value="{{ $GannData->d_300 }}" class="form-control" >
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="">
                                                    <input type="text" name="price_low_300" value="{{ $GannData->price_low_300 ?? ''}}" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="">
                                                    <input type="text" name="price_high_300" value="{{ $GannData->price_high_300 ?? ''}}" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="">
                                                    <input type="text" name="close_300" value="{{ $GannData->close_300 ?? ''}}" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="gann_date_field_inr">
                                        <div class="row align-items-center">
                                            <div class="col-md-1">
                                                <div class="gann_date_degree">
                                                    <h4>315°</h4>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="gann_date_dates">
                                                    <input type="text" name="d_315" value="{{ $GannData->d_315 }}" class="form-control" >
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="">
                                                    <input type="text" name="price_low_315" value="{{ $GannData->price_low_315 ?? ''}}" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="">
                                                    <input type="text" name="price_high_315" value="{{ $GannData->price_high_315 ?? ''}}" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="">
                                                    <input type="text" name="close_315" value="{{ $GannData->close_315 ?? ''}}" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="gann_date_field_inr">
                                        <div class="row align-items-center">
                                            <div class="col-md-1">
                                                <div class="gann_date_degree">
                                                    <h4>330°</h4>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="gann_date_dates">
                                                    <input type="text" name="d_330" value="{{ $GannData->d_330 }}" class="form-control" >
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="">
                                                    <input type="text" name="price_low_330" value="{{ $GannData->price_low_330 ?? ''}}" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="">
                                                    <input type="text" name="price_high_330" value="{{ $GannData->price_high_330 ?? ''}}" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="">
                                                    <input type="text" name="close_330" value="{{ $GannData->close_330 ?? ''}}" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="gann_date_field_inr">
                                        <div class="row align-items-center">
                                            <div class="col-md-1">
                                                <div class="gann_date_degree">
                                                    <h4>360°</h4>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="gann_date_dates">
                                                    <input type="text" name="d_360" value="{{ $GannData->d_360 }}" class="form-control" >
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="">
                                                    <input type="text" name="price_low_360" value="{{ $GannData->price_low_360 ?? ''}}" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="">
                                                    <input type="text" name="price_high_360" value="{{ $GannData->price_high_360 ?? ''}}" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="">
                                                    <input type="text" name="close_360" value="{{ $GannData->close_360 ?? ''}}" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-center mt-5">
                            <button type="submit" class="btn form_button">{{ trans('label.Save') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection


@section('page-js')

    <script>
        $(document).ready(function() {
            $('#date').datepicker({
                dateFormat: 'dd-mm-yy', // Set the desired date format
                autoclose: true, // Close the datepicker when a date is selected
                todayHighlight: true // Highlight today's date
            });

            $('#Stokes').change(function (){
               var selectedValue = $(this).val();

               if(selectedValue !== ''){
                $('#Stokes2').prop('disabled',true);
               }else{
                $('#Stokes2').prop('disabled',false);
               }
            });

            $('#Stokes2').on('input',function (){
               var inputValue = $(this).val();

               if(inputValue !== ''){
                $('#Stokes').prop('disabled',true);
               }else{
                $('#Stokes').prop('disabled',false);
               }
            });


            $('#GannForm').on('submit', function(event) {
                event.preventDefault();

                stock = $('#Stokes').val();
                stock2 = $('#Stokes2').val();
                date = $('#date').val();

                if (stock === '' || stock2 === '') {
                    $('#Stokes_error').text('Please fill up any one field Stocks').show();;
                } else {
                    $('#Stokes_error').hide();

                }

                if ((stock !== '' || stock2 !== '')) {
                    this.submit();
                }

            });


            // $('#gannDatesForm').on('submit', function(event) {
            //     event.preventDefault();
            //     var formData = $(this).serialize();
            //     $.ajax({
            //         url: $(this).attr('action'),
            //         type: 'POST',
            //         data: formData,
            //         success: function(response) {
            //             // Assuming response is an array of Gann dates corresponding to degrees
            //             response.forEach(function(item, index) {
            //                 var degree = (index + 1) *
            //                 30; // Calculate degree dynamically
            //                 $('.gann_date_dates input').eq(index).val(
            //                 item); // Populate corresponding input field
            //             });
            //         },
            //         error: function(xhr, status, error) {
            //             console.error('Error:', error);
            //             // Handle error if needed
            //         }
            //     });
            // });

            $('#calculateBtn').click(function(event) {
                event.preventDefault();

                // Retrieve the start date input value
                var startDate = $('#date').val();

                // Validate the start date format (optional, since datepicker enforces format)
                // Example: You can check if startDate matches 'dd-mm-yyyy' format

                // Calculate Gann dates based on the input date
                var start = moment(startDate, 'DD-MM-YYYY'); // Use moment.js for date manipulation

                if (start.isValid()) {
                    // Array of days for each degree
                    var days = [
                        30, 15, 15, 13, 18, 30, 15, 16, 30, 30,
                        16, 15, 12, 18, 19, 12, 15, 15, 31
                    ];

                    var response = [];

                    // Calculate each Gann date based on days array
                    days.forEach(function(daysCount, index) {
                        var nextDate = start.add(daysCount, 'days').format('DD/MM/YYYY');
                        response.push(nextDate);

                        // Assuming each degree input has a unique ID or class, update them here
                        // Example: $('#degree-30').val(nextDate);
                        // Replace '#degree-30' with your actual selector
                        $('.gann_date_dates input').eq(index).val(nextDate);
                    });

                    // Optionally, you can do something after all calculations are done
                    console.log('Gann dates calculated:', response);
                } else {
                    console.error('Invalid start date format or date.');
                    // Handle invalid date format or date here
                }
            });
        });

        $(document).ready(function() {

            $('#fetchDataBtn').click(function(event) {
                event.preventDefault();
                $('#loader').show();

                // Get the stock name and category from the variables
                var stockName = '{{ $GannData->stokes }}';
                var stockCategory = '{{ $GannData->stock_category }}'; // Replace with actual dynamic variable if needed

                // Get today's date
                var endDate = new Date();

                // Calculate the start date (2 years before the current date)
                var startDate = new Date();
                startDate.setFullYear(startDate.getFullYear() - 2);

                // Format dates as YYYY-MM-DD
                var formatDate = function(date) {
                    var year = date.getFullYear();
                    var month = ('0' + (date.getMonth() + 1)).slice(-2);
                    var day = ('0' + date.getDate()).slice(-2);
                    return year + '-' + month + '-' + day;
                };

                var formattedStartDate = formatDate(startDate);
                var formattedEndDate = formatDate(endDate);

                // Construct the API URL with parameters
                var apiUrl = '{{ route("gan-stock-price") }}';

                // Check stock category and append ".NS" if category is 1
                if (stockCategory == 1) {
                    stockName += '.NS';
                }

                // Send the AJAX request
                $.ajax({
                    url: apiUrl,
                    method: 'POST',
                    data: {
                        stock: stockName,
                        start_date: formattedStartDate,
                        end_date: formattedEndDate
                    },
                    success: function(response) {
                        // Handle the API response here
                        $('#loader').hide();
                        location.reload();
                        console.log('API Response:', response);
                    },
                    error: function(xhr, status, error) {
                        // Handle errors here
                        $('#loader').hide();
                        console.error('API Request Failed:', error);
                    }
                });
            });
        });

    </script>

@endsection
