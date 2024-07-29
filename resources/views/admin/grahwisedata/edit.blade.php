@extends('admin.layouts.admin-layout')

@section('title', 'GrahWiseData')

@section('content')

    {{-- Page Title --}}
    <div class="pagetitle">
        <h1>{{ trans('label.GrahWiseData') }}</h1>
        <div class="row">
            <div class="col-md-8">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active"> <a
                                href="{{ route('dashboard') }}">{{ trans('label.Dashboard') }}</a> </li>
                        <li class="breadcrumb-item active"> <a
                                href="{{ route('grahsdata.index') }}">{{ trans('label.GrahWiseData') }}</a> </li>
                        <li class="breadcrumb-item active">{{ trans('label.Edit') }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    {{-- Clients Card --}}
    <div class="col-md-12">
        <div class="card">
            <form class="form" action="{{ route('grahdata.update') }}" method="POST" id="grahForm" novalidate>
                <div class="card-body">
                    @csrf
                    <div class="form_box">
                        <div class="form_box_inr">
                            <div class="box_title">
                                <h2>{{ trans('label.GrahWiseData') }}</h2>
                            </div>
                            <div class="form_box_info csm_que">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="Date"
                                                class="form-label"><strong>{{ trans('label.Date') }}</strong>
                                                <span class="text-danger">*</span></label>
                                                <input type="hidden" name="id"  class="form-control date" value="{{ encrypt($grahWiseData->id) }}">
                                            <input type="text" name="date"  class="form-control date" value="{{ $grahWiseData->date }}">
                                            <div class="invalid-feedback date_error"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 additional-info">
                                        <div class="form-group">
                                            <label for="grahname"
                                                class="form-label"><strong>{{ trans('label.Grah Name') }}</strong>
                                                <span class="text-danger">*</span></label>
                                            <select name="grah_id" class="form-control grah_id">
                                                <option value="">-- Select GrahName --</option>
                                                @foreach ($grahs as $grah)
                                                    <option value="{{ $grah->id }}" {{ $grahWiseData->grah_id == $grah->id ? 'selected' : ''}}>{{ $grah->name }}</option>
                                                @endforeach
                                            </select>
                                            <div class="invalid-feedback grah_error"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-3 additional-info">
                                        <div class="form-group">
                                            <label for="start_time"
                                                class="form-label"><strong>{{ trans('label.Start Time') }}</strong></label>
                                            <input type="time" name="start_time" class="form-control start_time"
                                                onclick="this.focus()" onchange="validateTimeRange(this)" value="{{ $grahWiseData->start_time ? \Carbon\Carbon::createFromFormat('h:i A', $grahWiseData->start_time)->format('H:i') : '' }}"/>
                                            <div class="invalid-feedback start_time_error"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-3 additional-info">
                                        <div class="form-group">
                                            <label for="end_time"
                                                class="form-label"><strong>{{ trans('label.End Time') }}</strong></label>
                                            <input type="time" name="end_time" class="form-control end_time" 
                                                onclick="this.focus()" onchange="validateTimeRange(this)"  value="{{ $grahWiseData->end_time ? \Carbon\Carbon::createFromFormat('h:i A', $grahWiseData->end_time)->format('H:i') : '' }}"/>
                                            <div class="invalid-feedback end_time_error"></div>
                                        </div>
                                    </div>
                                    <div class="row appending_div">
                                    </div>
                                  
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-center">
                    <button type="submit" class="btn form_button">{{ trans('label.Save') }}</button>
                </div>
        </div>
        </form>
    </div>
    </div>

@endsection

@section('page-js')

    <script>
            function validateTimeRange(input) {
                var selectedTime = input.value;
                var startTime = "09:00";
                var endTime = "15:30";

                if (selectedTime < startTime || selectedTime > endTime) {
                    alert("Please select a time between 9:00 AM and 3:30 PM.");
                    input.value = ''; // Clear the invalid value
                }
            }


            $('.date').datepicker({
                dateFormat: 'dd-mm-yy', // Set the desired date format
                autoclose: true, // Close the datepicker when a date is selected
                todayHighlight: true // Highlight today's date
            });

        $('form').submit(function(e) {

            event.preventDefault(); // Prevent form submission to manually validate fields

            let allFieldsFilled = true;
            const requiredFields = $('#grahForm .form-control');

            requiredFields.each(function() {
                if ($(this).val().trim() === '') {
                    allFieldsFilled = false;
                    $(this).addClass('is-invalid'); // Add invalid class to show error
                } else {
                    $(this).removeClass(
                    'is-invalid'); // Remove invalid class if field is filled
                }
            });

            if (!allFieldsFilled) {
                    alert('All fields are required');
                } else {
                    // If all fields are filled, submit the form
                    this.submit();
                }

            var date = $('.date').val().trim();
            var start_time = $('.start_time').val().trim();
            var end_time = $('.end_time').val().trim();
            var grah_id = $('.grah_id').val().trim();


            //questionType
            if (date === '') {
                $('.date').addClass('is-invalid');
                $('.date_error').text('Date is required.');
                e.preventDefault();
            } else {
                $('.date').removeClass('is-invalid');
                $('.date_error').text('');
            }

            if (grah_id === '') {
                $('.grah_id').addClass('is-invalid');
                $('.grah_error').text('Grah Name is required.');
                e.preventDefault();
            } else {
                $('.grah_id').removeClass('is-invalid');
                $('.grah_error').text('');
            }

            //questionName
            if (start_time === '') {
                $('.start_time').addClass('is-invalid');
                $('.start_time_error').text('Start Time is required.');
                e.preventDefault();
            } else {
                $('.start_time').removeClass('is-invalid');
                $('.start_time_error').text('');
            }

            //optionName1
            if (end_time === '') {
                $('.end_time').addClass('is-invalid');
                $('.end_time_error').text('End Time is required.');
                e.preventDefault();
            } else {
                $('.end_time').removeClass('is-invalid');
                $('.end_time_error').text('');
            }


        });
    </script>

@endsection
