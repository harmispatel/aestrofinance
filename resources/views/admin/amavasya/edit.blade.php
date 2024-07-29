@extends('admin.layouts.admin-layout')

@section('title', 'Amavasya')

@section('content')

    {{-- Page Title --}}
    <div class="pagetitle">
        <h1>Amavasya</h1>
        <div class="row">
            <div class="col-md-8">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active"><a href="{{ route('amavasya.index') }}">Amavasya</a></li>
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
                    <form action="{{ route('amavasya.update')}}" method="POST">
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
                                                    <label for="start_time" class="form-label">Start Date & Time<span
                                                            class="text-danger">*</span></label>
                                                            <input type="hidden" name="id" value="{{ encrypt($amavasyaData->id)}}">
                                                    <input type="text" name="start_time"  id="start_time"
                                                        value="{{ isset($amavasyaData->start_time) ? $amavasyaData->start_time : old('start_time') }}"
                                                        class="form-control {{ $errors->has('start_time') ? 'is-invalid' : '' }}"
                                                       >
                                                    @if ($errors->has('start_time'))
                                                        <div class="invalid-feedback">
                                                            {{ $errors->first('start_time') }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <div class="form-group">
                                                    <label for="end_time" class="form-label">End Date & Time<span
                                                            class="text-danger">*</span></label>

                                                    <input type="text" name="end_time"
                                                        value="{{ isset($amavasyaData->end_time) ? $amavasyaData->end_time : old('end_time') }}"
                                                        id="end_time"
                                                        class="form-control {{ $errors->has('end_time') ? 'is-invalid' : '' }}">
                                                    @if ($errors->has('end_time'))
                                                        <div class="invalid-feedback">
                                                            {{ $errors->first('end_time') }}
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
    flatpickr("#start_time", {
        enableTime: true,
        dateFormat: "Y-m-d H:i",
    });

    flatpickr("#end_time", {
        enableTime: true,
        dateFormat: "Y-m-d H:i",
    });
</script>
@endsection
