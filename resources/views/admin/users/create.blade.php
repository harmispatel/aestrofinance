@extends('admin.layouts.admin-layout')

@section('title', 'New Users')

@section('content')

    {{-- Page Title --}}
    <div class="pagetitle">
        <h1>Users</h1>
        <div class="row">
            <div class="col-md-8">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item "><a href="{{ route('users') }}">Users</a></li>
                        <li class="breadcrumb-item active">Create</li>
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
                    <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data" id="regForm">
                        <div class="card-body">
                            @csrf
                            <div class="form_box">
                                <div class="form_box_inr">
                                    <div class="box_title">
                                        <h2>User Details</h2>
                                    </div>
                                    <div class="form_box_info">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <div class="form-group">
                                                    <label for="name" class="form-label">Name<span class="text-danger">*</span></label>
                                                    <input type="text" name="name" id="name" value="{{old('name')}}" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" placeholder="Enter Name">
                                                    @if ($errors->has('name'))
                                                        <div class="invalid-feedback">
                                                            {{ $errors->first('name') }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <div class="form-group">
                                                    <label for="email" class="form-label">Email<span class="text-danger">*</span></label>
                                                    <input type="email" name="email" id="email" value="{{old('email')}}" class="form-control {{$errors->has('email') ? 'is-invalid' : ''}}" placeholder="Enter Email">
                                                    @if ($errors->has('email'))
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('email') }}
                                                    </div>
                                                @endif
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <div class="form-group">
                                                    <label for="password" class="form-label">Password<span class="text-danger">*</span></label>
                                                    <input type="password" name="password" id="password" value="{{old('password')}}" class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" placeholder="Enter Password">
                                                    @if ($errors->has('password'))
                                                        <div class="invalid-feedback">
                                                            {{ $errors->first('password') }}
                                                        </div>
                                                    @endif
                                                </div>

                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="confirm_password" class="form-label">Confirm Password<span class="text-danger">*</span></label>
                                                    <input type="password" name="confirm_password" id="confirm_password" value="{{old('confirm_password')}}" class="form-control {{ $errors->has('confirm_password') ? 'is-invalid' : ''}}" placeholder="Enter Confirm Password">
                                                    @if ($errors->has('confirm_password'))
                                                        <div class="invalid-feedback">
                                                            {{ $errors->first('confirm_password') }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="role_id" class="form-label">User Role<span class="text-danger">*</span></label>
                                                <select name="role_id" id="role_id" name="role_id" class="form-select">
                                                    <option value="">-- Select Role --</option>
                                                    @foreach ($roles as $role)
                                                    <option value="{{$role->id}}" {{ old('role_id') == $role->id ? "selected" :""}}>{{ $role->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form_box_inr">
                                    <div class="box_title">
                                        <h2>User Image</h2>
                                    </div>
                                    <div class="form_box_info">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <div class="form_group">
                                                    <label for="image" class="form-label">Image<span class="text-danger">*</span></label>
                                                    <input type="file" name="image" class="form-control @error('image') is-invalid @enderror">
                                                    @if ($errors->has('image'))
                                                        <div class="invalid-feedback">
                                                            {{ $errors->first('image') }}
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
                            <button class="btn form_button">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection


