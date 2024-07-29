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
                <div class="gann_date_main">
                    <div class="gann_date_head">
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <div class="form-group">
                                    <label for="Stokes" class="form-label"><strong>Stocks</strong>
                                        <span class="text-danger"></span></label>
                                    <input type="text" class="form-control" value="{{ $GannData->stokes }}" disabled>
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
                                            <div class="gann_date_dates">
                                                <input type="text" name="d_0" value="{{ $GannData->d_0 }}" class="form-control" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="">
                                                <input type="text" name="price_low_0" value="{{ $GannData->price_low_0 ?? ''}}"class="form-control low-price" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="">
                                                <input type="text" name="price_high_0" value="{{ $GannData->price_high_0 ?? ''}}"class="form-control high-price" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="">
                                                <input type="text" name="close_0" value="{{ $GannData->close_0 ?? '' }}" class="form-control close-price" disabled>
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
                                                <input type="text" name="d_30" value="{{ $GannData->d_30 }}" class="form-control" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="">
                                                <input type="text" name="price_low_30" value="{{ $GannData->price_low_30 ?? ''}}"class="form-control low-price" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="">
                                                <input type="text" name="price_high_30" value="{{ $GannData->price_high_30 ?? ''}}"class="form-control high-price" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="">
                                                <input type="text" name="close_30" value="{{ $GannData->close_30 ?? '' }}" class="form-control close-price" disabled>
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
                                                <input type="text" name="d_45" value="{{ $GannData->d_45 }}" class="form-control" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="">
                                                <input type="text" name="price_low_45" value="{{ $GannData->price_low_45 ?? ''}}"class="form-control" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="">
                                                <input type="text" name="price_high_45" value="{{ $GannData->price_high_45 ?? ''}}" class="form-control" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="">
                                                <input type="text" name="close_45" value="{{ $GannData->close_45 ?? ''}}"class="form-control" disabled>
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
                                                <input type="text" name="d_60" value="{{ $GannData->d_60 }}" class="form-control" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="">
                                                <input type="text" name="price_low_60" value="{{ $GannData->price_low_60 ?? ''}}"class="form-control" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="">
                                                <input type="text" name="price_high_60" value="{{ $GannData->price_high_60 ?? ''}}" class="form-control" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="">
                                                <input type="text" name="close_60" value="{{ $GannData->close_60 ?? ''}}" class="form-control" disabled>
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
                                                <input type="text" name="d_72" value="{{ $GannData->d_72 }}" class="form-control" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="">
                                                <input type="text" name="price_low_72" value="{{ $GannData->price_low_72 ?? ''}}"class="form-control" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="">
                                                <input type="text" name="price_high_72" value="{{ $GannData->price_high_72 ?? ''}}"class="form-control" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="">
                                                <input type="text" name="close_72" value="{{ $GannData->close_72 ?? ''}}" class="form-control" disabled>
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
                                                <input type="text" name="d_90" value="{{ $GannData->d_90 }}" class="form-control" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="">
                                                <input type="text" name="price_low_90" value="{{ $GannData->price_low_90 ?? ''}}" class="form-control" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="">
                                                <input type="text" name="price_high_90" value="{{ $GannData->price_high_90 ?? ''}}" class="form-control" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="">
                                                <input type="text" name="close_90" value="{{ $GannData->close_90 ?? ''}}"class="form-control" disabled>
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
                                                <input type="text" name="d_120" value="{{ $GannData->d_120 }}" class="form-control" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="">
                                                <input type="text" name="price_low_120" value="{{ $GannData->price_low_120 ?? ''}}" class="form-control" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="">
                                                <input type="text" name="price_high_120" value="{{ $GannData->price_high_120 ?? ''}}" class="form-control" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="">
                                                <input type="text" name="close_120" value="{{ $GannData->close_120 ?? ''}}" class="form-control" disabled>
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
                                                <input type="text" name="d_135" value="{{ $GannData->d_135 }}" class="form-control" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="">
                                                <input type="text" name="price_low_135" value="{{ $GannData->price_low_135 ?? ''}}" class="form-control" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="">
                                                <input type="text" name="price_high_135" value="{{ $GannData->price_high_135 ?? ''}}" class="form-control" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="">
                                                <input type="text" name="close_135" value="{{ $GannData->close_135 ?? ''}}" class="form-control" disabled>
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
                                                <input type="text" name="d_150" value="{{ $GannData->d_150 }}" class="form-control" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="">
                                                <input type="text" name="price_low_150" value="{{ $GannData->price_low_150 ?? ''}}" class="form-control" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="">
                                                <input type="text" name="price_high_150" value="{{ $GannData->price_high_150 ?? ''}}" class="form-control" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="">
                                                <input type="text" name="close_150" value="{{ $GannData->close_150 ?? ''}}" class="form-control" disabled>
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
                                                <input type="text" name="d_180" value="{{ $GannData->d_180 }}" class="form-control" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="">
                                                <input type="text" name="price_low_180" value="{{ $GannData->price_low_180 ?? ''}}" class="form-control" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="">
                                                <input type="text" name="price_high_180" value="{{ $GannData->price_high_180 ?? ''}}" class="form-control" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="">
                                                <input type="text" name="close_180" value="{{ $GannData->close_180 ?? ''}}" class="form-control" disabled>
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
                                                <input type="text" name="d_210" value="{{ $GannData->d_210 }}" class="form-control" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="">
                                                <input type="text" name="price_low_210" value="{{ $GannData->price_low_210 ?? ''}}" class="form-control" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="">
                                                <input type="text" name="price_high_210" value="{{ $GannData->price_high_210 ?? ''}}" class="form-control" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="">
                                                <input type="text" name="close_210" value="{{ $GannData->close_210 ?? ''}}" class="form-control" disabled>
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
                                                <input type="text" name="d_225" value="{{ $GannData->d_225 }}" class="form-control" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="">
                                                <input type="text" name="price_low_225" value="{{ $GannData->price_low_225 ?? ''}}" class="form-control" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="">
                                                <input type="text" name="price_high_225" value="{{ $GannData->price_high_225 ?? ''}}" class="form-control" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="">
                                                <input type="text" name="close_225" value="{{ $GannData->close_225 ?? ''}}" class="form-control" disabled>
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
                                                <input type="text" name="d_240" value="{{ $GannData->d_240 }}" class="form-control" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="">
                                                <input type="text" name="price_low_240" value="{{ $GannData->price_low_240 ?? ''}}" class="form-control" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="">
                                                <input type="text" name="price_high_240" value="{{ $GannData->price_high_240 ?? ''}}" class="form-control" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="">
                                                <input type="text" name="close_240" value="{{ $GannData->close_240 ?? ''}}" class="form-control" disabled>
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
                                                <input type="text" name="d_252" value="{{ $GannData->d_252 }}" class="form-control" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="">
                                                <input type="text" name="price_low_252" value="{{ $GannData->price_low_252 ?? ''}}" class="form-control" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="">
                                                <input type="text" name="price_high_252" value="{{ $GannData->price_high_252 ?? ''}}" class="form-control" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="">
                                                <input type="text" name="close_252" value="{{ $GannData->close_252 ?? ''}}" class="form-control" disabled>
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
                                                <input type="text" name="d_270" value="{{ $GannData->d_270 }}" class="form-control" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="">
                                                <input type="text" name="price_low_270" value="{{ $GannData->price_low_270 ?? ''}}" class="form-control" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="">
                                                <input type="text" name="price_high_270" value="{{ $GannData->price_high_270 ?? ''}}" class="form-control" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="">
                                                <input type="text" name="close_270" value="{{ $GannData->close_270 ?? ''}}" class="form-control" disabled>
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
                                                <input type="text" name="d_288" value="{{ $GannData->d_288 }}" class="form-control" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="">
                                                <input type="text" name="price_low_288" value="{{ $GannData->price_low_288 ?? ''}}" class="form-control" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="">
                                                <input type="text" name="price_high_288" value="{{ $GannData->price_high_288 ?? ''}}" class="form-control" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="">
                                                <input type="text" name="close_288" value="{{ $GannData->close_288 ?? ''}}" class="form-control" disabled>
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
                                                <input type="text" name="d_300" value="{{ $GannData->d_300 }}" class="form-control" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="">
                                                <input type="text" name="price_low_300" value="{{ $GannData->price_low_300 ?? ''}}" class="form-control" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="">
                                                <input type="text" name="price_high_300" value="{{ $GannData->price_high_300 ?? ''}}" class="form-control" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="">
                                                <input type="text" name="close_300" value="{{ $GannData->close_300 ?? ''}}" class="form-control" disabled>
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
                                                <input type="text" name="d_315" value="{{ $GannData->d_315 }}" class="form-control" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="">
                                                <input type="text" name="price_low_315" value="{{ $GannData->price_low_315 ?? ''}}" class="form-control" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="">
                                                <input type="text" name="price_high_315" value="{{ $GannData->price_high_315 ?? ''}}" class="form-control" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="">
                                                <input type="text" name="close_315" value="{{ $GannData->close_315 ?? ''}}" class="form-control" disabled>
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
                                                <input type="text" name="d_330" value="{{ $GannData->d_330 }}" class="form-control" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="">
                                                <input type="text" name="price_low_330" value="{{ $GannData->price_low_330 ?? ''}}" class="form-control" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="">
                                                <input type="text" name="price_high_330" value="{{ $GannData->price_high_330 ?? ''}}" class="form-control" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="">
                                                <input type="text" name="close_330" value="{{ $GannData->close_330 ?? ''}}" class="form-control" disabled>
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
                                                <input type="text" name="d_360" value="{{ $GannData->d_360 }}" class="form-control" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="">
                                                <input type="text" name="price_low_360" value="{{ $GannData->price_low_360 ?? ''}}" class="form-control" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="">
                                                <input type="text" name="price_high_360" value="{{ $GannData->price_high_360 ?? ''}}" class="form-control" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="">
                                                <input type="text" name="close_360" value="{{ $GannData->close_360 ?? ''}}" class="form-control" disabled>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('page-js')

@endsection
