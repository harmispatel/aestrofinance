@extends('admin.layouts.admin-layout')

@section('title', 'Trayodashi')

@section('content')

    {{-- Page Title --}}
    <div class="pagetitle">
        <h1>Trayodashi</h1>
        <div class="row">
            <div class="col-md-8">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active"><a href="{{ route('trayodashi.index') }}">Trayodashi</a></li>
                        <li class="breadcrumb-item active">Edit</li>
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
                    <form action="{{ route('trayodashi.update')}}" method="POST">
                        <div class="card-body">
                            @csrf
                            <div class="form_box">
                                <div class="form_box_inr">
                                    <div class="box_title">
                                        <h2>Trayodashi</h2>
                                    </div>
                                    <div class="form_box_info">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <div class="form-group">
                                                    <label for="start_date_time" class="form-label">Start Date & Time<span
                                                            class="text-danger">*</span></label>
                                                            <input type="hidden" name="id" value="{{ encrypt($trayodashis->id)}}">
                                                    <input type="text" name="start_date_time"  id="start_date_time" 
                                                        value="{{ isset($trayodashis->start_date_time) ? $trayodashis->start_date_time : old('start_date_time') }}"
                                                        class="form-control {{ $errors->has('start_date_time') ? 'is-invalid' : '' }}"
                                                       >
                                                    @if ($errors->has('start_date_time'))
                                                        <div class="invalid-feedback">
                                                            {{ $errors->first('start_date_time') }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <div class="form-group">
                                                    <label for="end_date_time" class="form-label">End Date & Time<span
                                                            class="text-danger">*</span></label>
                                                      
                                                    <input type="text" name="end_date_time"
                                                        value="{{ isset($trayodashis->end_date_time) ? $trayodashis->end_date_time : old('end_date_time') }}"
                                                        id="end_date_time" 
                                                        class="form-control {{ $errors->has('end_date_time') ? 'is-invalid' : '' }}">
                                                    @if ($errors->has('end_date_time'))
                                                        <div class="invalid-feedback">
                                                            {{ $errors->first('end_date_time') }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="card-footer text-center">
                                        <button class="btn form_button">Update</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('page-js')
<script>
    flatpickr("#start_date_time", {
        enableTime: true,
        dateFormat: "Y-m-d H:i",
    });

    flatpickr("#end_date_time", {
        enableTime: true,
        dateFormat: "Y-m-d H:i",
    });
</script>
@endsection
