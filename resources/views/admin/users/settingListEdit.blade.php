@extends('admin.layouts.admin-layout')

@section('title', 'Setting')

@section('content')

    {{-- Page Title --}}
    <div class="pagetitle">
        <h1>Setting</h1>
        <div class="row">
            <div class="col-md-8">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item "><a href="{{ route('settingDetail') }}">Setting</a></li>
                        <li class="breadcrumb-item active">Setting Edit</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>


    {{-- New Category add Section --}}
    <section class="section dashboard">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <form action="{{ route('setting.update') }}" method="POST">
                        <div class="card-body">
                            @csrf
                            <div class="form_box">
                                <div class="form_box_inr">
                                    <div class="box_title">
                                        <h2>Setting Details</h2>
                                    </div>
                                    <div class="form_box_info">
                                        <div class="row">
                                            <input type="hidden" name="id" id="id" value="{{encrypt($userData->id)}}">
                                            <div class="col-md-6 mb-3">
                                                <div class="form-group">
                                                    <label for="username" class="form-label">Username<span class="text-danger">*</span></label>
                                                    <input type="text" name="username" value="{{isset($userData->username) ? $userData->username : old('username')}}" id="username" class="form-control {{ $errors->has('username') ? 'is-invalid' : '' }}" placeholder="Enter First username">
                                                    @if ($errors->has('username'))
                                                        <div class="invalid-feedback">
                                                            {{ $errors->first('username') }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <div class="form-group">
                                                    <label for="api_key" class="form-label">Api Key<span class="text-danger">*</span></label>
                                                    <input type="api_key" name="api_key" value="{{isset($userData->api_key) ? $userData->api_key : old('api_key')}}" id="api_key" class="form-control {{$errors->has('api_key') ? 'is-invalid' : ''}}" placeholder="Enter Api Key">
                                                    @if ($errors->has('api_key'))
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('api_key') }}
                                                    </div>
                                                @endif
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <div class="form-group">
                                                    <label for="t_otp" class="form-label">t otp<span class="text-danger">*</span></label>
                                                    <input type="t_otp" name="t_otp" value="{{isset($userData->t_otp) ? $userData->t_otp : old('t_otp')}}" id="t_otp" class="form-control {{$errors->has('t_otp') ? 'is-invalid' : ''}}" placeholder="Enter Api Key">
                                                    @if ($errors->has('t_otp'))
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('t_otp') }}
                                                    </div>
                                                @endif
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <div class="form-group">
                                                    <label for="setting_password" class="form-label">Password<span class="text-danger">*</span></label>
                                                    <input type="setting_password" name="setting_password" value="{{isset($userData->setting_password) ? $userData->setting_password : old('setting_password')}}" id="setting_password" class="form-control {{$errors->has('setting_password') ? 'is-invalid' : ''}}" placeholder="Enter Api Key">
                                                    @if ($errors->has('setting_password'))
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('setting_password') }}
                                                    </div>
                                                @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-center">
                            <button class="btn form_button">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

@endsection
