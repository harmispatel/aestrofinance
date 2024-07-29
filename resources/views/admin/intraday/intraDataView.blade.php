@extends('admin.layouts.admin-layout')

@section('title', 'IntraDay')

@section('content')

    {{-- Page Title --}}
    <div class="pagetitle">
        <h1>{{ trans('label.IntraDay') }}</h1>
        <div class="row">
            <div class="col-md-8">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active"> <a
                                href="{{ route('dashboard') }}">{{ trans('label.dashboard') }}</a> </li>
                        <li class="breadcrumb-item active"> <a
                                href="{{ route('intraday') }}">{{ trans('label.IntraDay') }}</a> </li>
                        <li class="breadcrumb-item active">{{ trans('label.IntraValuesView') }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    {{-- Clients Card --}}
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="form_box">
                    <div class="form_box_inr">
                        <div class="box_title">
                            <h2>{{ trans('label.IntraDay') }}</h2>
                        </div>
                        <div class="form_box_info">
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="option_name" class="form-label"><strong>* {{ $intra->date ? \Carbon\Carbon::createFromFormat('Y-m-d', $intra->date)->format('d-m-y') : '' }} ?</strong></label>

                                </div>
                                @foreach ($intraValues as $intraValue)
                                    <div class="col-md-12">
                                        <div class="row align-items-end added-option">
                                            <label>_______________________________________________________________________________________________________________________________</label>
                                            <div class="col-md-3 additional-info">
                                                <div class="form-group">
                                                    <label for="start_time"
                                                        class="form-label"><strong>{{ trans('label.Start Time') }}</strong></label>
                                                    <input type="hidden" id="id" value="{{ $intraValue->id }}"
                                                        class="form-control">
                                                    <input type="time" id="start_time"
                                                        value={{ $intraValue->start_time }} class="form-control"
                                                        disabled />
                                                </div>
                                            </div>
                                            <div class="col-md-3 additional-info">
                                                <div class="form-group">
                                                    <label for="end_time"
                                                        class="form-label"><strong>{{ trans('label.End Time') }}</strong></label>
                                                    <input type="time" id="end_time" value={{ $intraValue->end_time }}
                                                        class="form-control" disabled />
                                                    <div id="end_time_error" class="invalid-feedback"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 additional-info mt-3"></div>
                                            <div class="col-md-3 additional-info mt-3">
                                                <label for="buy_or_sale" class="form-label">
                                                    <strong>{{ trans('label.Buy Or Sell') }}</strong>
                                                </label>
                                                <div class="form-group">
                                                    <div class="form-check">
                                                        <input type="radio" id="buy_option" value="BUY"
                                                            class="form-check-input"
                                                            {{ $intraValue->buy_or_sale == 'BUY' ? 'checked' : '' }}
                                                            disabled />
                                                        <label for="buy_option" class="form-check-label">Buy</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="radio" id="sell_option" value="SELL"
                                                            class="form-check-input"
                                                            {{ $intraValue->buy_or_sale == 'SELL' ? 'checked' : '' }}
                                                            disabled />
                                                        <label for="sell_option" class="form-check-label">Sell</label>
                                                    </div>
                                                    <div id="buy_or_sale_feedback" class="invalid-feedback"></div>
                                                </div>
                                            </div>

                                            <div class="col-md-3 additional-info mt-3">
                                                <label for="nifty_or_banknifty" class="form-label">
                                                    <strong>{{ trans('label.Nifty Or BankNifty') }}</strong>
                                                </label>
                                                <div class="form-group">
                                                    <div class="form-check">
                                                        <input type="radio" id="nifty_option" value="Nifty"
                                                            class="form-check-input"
                                                            {{ $intraValue->nifty_or_banknifty == 'Nifty' ? 'checked' : '' }}
                                                            disabled />
                                                        <label for="nifty_option" class="form-check-label">Nifty</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="radio" id="banknifty_option" value="BankNifty"
                                                            class="form-check-input"
                                                            {{ $intraValue->nifty_or_banknifty == 'BankNifty' ? 'checked' : '' }}
                                                            disabled />
                                                        <label for="banknifty_option"
                                                            class="form-check-label">BankNifty</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="radio" id="both_option" value="Both"
                                                            class="form-check-input"
                                                            {{ $intraValue->nifty_or_banknifty == 'Both' ? 'checked' : '' }}
                                                            disabled />
                                                        <label for="both_option" class="form-check-label">Both</label>
                                                    </div>
                                                    <div id="nifty_or_banknifty_feedback" class="invalid-feedback">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-3 additional-info mt-3">
                                                <label for="featureby_or_optionby" class="form-label">
                                                    <strong>{{ trans('label.Future Or Option') }}</strong>
                                                </label>
                                                <div class="form-group">
                                                    <div class="form-check">
                                                        <input type="radio" id="featureby_option" value="Feature"
                                                            class="form-check-input"
                                                            {{ $intraValue->featureby_or_optionby == 'Feature' ? 'checked' : '' }}
                                                            disabled />
                                                        <label for="featureby_option"
                                                            class="form-check-label">Feature</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="radio" id="optionby_option" value="Option"
                                                            class="form-check-input"
                                                            {{ $intraValue->featureby_or_optionby == 'Option' ? 'checked' : '' }}
                                                            disabled />
                                                        <label for="optionby_option"
                                                            class="form-check-label">Option</label>
                                                    </div>
                                                    <div id="featureby_or_optionby_feedback" class="invalid-feedback">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2 additional-info mt-3">
                                                <div class="form-group">
                                                    <label for="quantity"
                                                        class="form-label"><strong>{{ trans('label.Quantity') }}</strong></label>
                                                    <input type="number" id="quantity" min=1 class="form-control"
                                                        value="{{ $intraValue->quantity }}" disabled />
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer text-center">
                <a href="{{ route('intraday') }}" class="btn form_button">{{ trans('label.Back') }}</a>
            </div>
        </div>
    </div>

@endsection
