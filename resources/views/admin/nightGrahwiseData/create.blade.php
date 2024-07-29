@extends('admin.layouts.admin-layout')

@section('title', 'Night GrahWiseData')

@section('content')

    {{-- Page Title --}}
    <div class="pagetitle">
        <h1>Night GrahWiseData</h1>
        <div class="row">
            <div class="col-md-8">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active"> <a
                                href="{{ route('dashboard') }}">{{ trans('label.Dashboard') }}</a> </li>
                        <li class="breadcrumb-item active"> <a
                                href="{{ route('grahsdata.index') }}">Night GrahWiseData</a> </li>
                        <li class="breadcrumb-item active">{{ trans('label.Create') }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    {{-- Clients Card --}}
    <div class="col-md-12">
        <div class="card">
            <form class="form" action="{{ route('nightgrahsdata.store') }}" method="POST" id="grahForm" novalidate>
                <div class="card-body">
                    @csrf
                    <div class="form_box">
                        <div class="form_box_inr">
                            <div class="box_title">
                                <h2>Night GrahWiseData</h2>
                            </div>
                            <div class="form_box_info csm_que">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="Date"
                                                class="form-label"><strong>{{ trans('label.Date') }}</strong>
                                                <span class="text-danger">*</span></label>
                                            <input type="text" name="date[]" id="date" class="form-control date">
                                            <div id="date_error" class="invalid-feedback"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 additional-info">
                                        <div class="form-group">
                                            <label for="grahname"
                                                class="form-label"><strong>{{ trans('label.Grah Name') }}</strong>
                                                <span class="text-danger">*</span></label>
                                            <select name="grah_id[]" class="form-control" id="grah_id">
                                                <option value="">-- Select GrahName --</option>
                                                @foreach ($grahs as $grah)
                                                    <option value="{{ $grah->id }}">{{ $grah->name }}</option>
                                                @endforeach
                                            </select>
                                            <div id="grah_error" class="invalid-feedback"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-3 additional-info">
                                        <div class="form-group">
                                            <label for="start_time"
                                                class="form-label"><strong>{{ trans('label.Start Time') }}</strong></label>
                                            <input type="time" name="start_time[]" id="start_time" class="form-control"
                                                onclick="this.focus()" onchange="validateTimeRange(this)" />
                                            <div id="start_time_error" class="invalid-feedback"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-3 additional-info">
                                        <div class="form-group">
                                            <label for="end_time"
                                                class="form-label"><strong>{{ trans('label.End Time') }}</strong></label>
                                            <input type="time" name="end_time[]" id="end_time" class="form-control"
                                                onclick="this.focus()" onchange="validateTimeRange(this)" />
                                            <div id="end_time_error" class="invalid-feedback"></div>
                                        </div>
                                    </div>
                                    <div class="row appending_div">
                                    </div>
                                    <div class="col-md-12 mt-3 additional-info text-end">
                                        <a href="" class="btn btn-sm new-category custom-btn" id="addOption"><i
                                                class="bi bi-plus-lg"></i></a>
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
        $(document).ready(function() {
            $('#grahForm').on('submit', function(event) {
                let allFieldsFilled = true;

                // Validate all form controls with class .form-control
                $('#grahForm .form-control').each(function() {
                    if ($(this).val().trim() === '') {
                        allFieldsFilled = false;
                        $(this).addClass('is-invalid'); // Add invalid class to show error
                    } else {
                        $(this).removeClass(
                            'is-invalid'); // Remove invalid class if field is filled
                    }
                });


                // Validate each appended set of data
                $('.added-option').each(function() {
                    var optionIndex = $(this).index() + 1;

                    if (!$("input[name='date[" + optionIndex + "]']").val().trim()) {
                        allFieldsFilled = false;
                        $("#date_" + optionIndex + "error").text("Date is required.").show();
                    } else {
                        $("#date_" + optionIndex + "error").hide();
                    }

                    if (!$("select[name='grah_id[" + optionIndex + "]']").val().trim()) {
                        allFieldsFilled = false;
                        $("#grah_" + optionIndex + "error").text("Grah Name is required.").show();
                    } else {
                        $("#grah_" + optionIndex + "error").hide();
                    }

                    if (!$("input[name='start_time[" + optionIndex + "]']").val().trim()) {
                        allFieldsFilled = false;
                        $("#start_time_" + optionIndex + "error").text("Start Time is required.")
                            .show();
                    } else {
                        $("#start_time_" + optionIndex + "error").hide();
                    }

                    if (!$("input[name='end_time[" + optionIndex + "]']").val().trim()) {
                        allFieldsFilled = false;
                        $("#end_time_" + optionIndex + "error").text("End Time is required.")
                            .show();
                    } else {
                        $("#end_time_" + optionIndex + "error").hide();
                    }

                });

                if (!allFieldsFilled) {
                    event.preventDefault(); // Prevent form submission
                    alert('Please fill in all required fields.');
                }
            });



            // Add option button click handler
            $('#addOption').on('click', function(e) {
                e.preventDefault();

                var optionIndex = $('.added-option').length + 1;

                // Calculate the new index for the appended option

                var field = '<div class="col-md-12 added-option">' +
                    '<div class="row">' +
                    '<label>_______________________________________________________________________________________________________________________________</label>' +
                    '<div class="col-md-6 align-content-center mt-3">' +
                    '<div class="row align-items-end">' +
                    '<div class="additional-info">' +
                    '<div class="form-group">' +
                    '<label for="date" class="form-label"><strong>{{ trans('label.Date') }}</strong></label>' +
                    '<input type="text" name="date[' + optionIndex + ']" class="form-control date">' +
                    '<div id="date_' + optionIndex + 'error" class="invalid-feedback"></div>' +
                    '</div>' +
                    '</div>' +
                    '</div>' +
                    '</div>' +
                    '<div class="col-md-6 align-content-center mt-3">' +
                    '<div class="row align-items-end">' +
                    '<div class="additional-info">' +
                    '<div class="form-group">' +
                    '<label for="grah_id" class="form-label"><strong>{{ trans('label.Grah Name') }}</strong></label>' +
                    '<select name="grah_id[' + optionIndex + ']" class="form-control">' +
                    '<option value="">-- Select GrahName --</option>' +
                    '@foreach ($grahs as $grah)' +
                    '<option value="{{ $grah->id }}">{{ $grah->name }}</option>' +
                    '@endforeach' +
                    '</select>' +
                    '<div id="grah_' + optionIndex + 'error" class="invalid-feedback"></div>' +
                    '</div>' +
                    '</div>' +
                    '</div>' +
                    '</div>' +
                    '<div class="col-md-6 align-content-center mt-3">' +
                    '<div class="row align-items-end">' +
                    '<div class="additional-info">' +
                    '<div class="form-group">' +
                    '<label for="start_time" class="form-label"><strong>{{ trans('label.Start Time') }}</strong></label>' +
                    '<input type="time" name="start_time[' + optionIndex +
                    ']" class="form-control" onclick="this.focus()" onchange="validateTimeRange(this)" />' +
                    '<div id="start_time_' + optionIndex + 'error" class="invalid-feedback"></div>' +
                    '</div>' +
                    '</div>' +
                    '</div>' +
                    '</div>' +
                    '<div class="col-md-6 align-content-center mt-3">' +
                    '<div class="row align-items-end">' +
                    '<div class="additional-info">' +
                    '<div class="form-group">' +
                    '<label for="end_time" class="form-label"><strong>{{ trans('label.End Time') }}</strong></label>' +
                    '<input type="time" name="end_time[' + optionIndex +
                    ']" class="form-control" onclick="this.focus()" onchange="validateTimeRange(this)" />' +
                    '<div id="end_time_' + optionIndex + 'error" class="invalid-feedback"></div>' +
                    '</div>' +
                    '</div>' +
                    '</div>' +
                    '</div>' +
                    '<div class="col-md-1 mt-2 additional-info">' +
                    '<div class="form-group">' +
                    '<button class="btn btn-sm btn-danger cancel-option"><i class="bi bi-trash" aria-hidden="true"></i></button>' +
                    '</div>' +
                    '</div>' +
                    '</div>' +
                    '</div>';

                $('.appending_div').append(field);

                optionIndex++;

                $('.added-option:last .date').datepicker({
                    dateFormat: 'dd-mm-yy', // Set the desired date format
                    autoclose: true, // Close the datepicker when a date is selected
                    todayHighlight: true // Highlight today's date
                });

            });

            // Initialize datepicker for the newly appended date fielD

            // Event delegation for the cancel button
            $('.appending_div').on('click', '.cancel-option', function(e) {
                e.preventDefault();

                $(this).closest('.added-option').remove();

                $('.added-option').each(function(index) {
                    var newIndex = index + 1;
                    $(this).find('[name^="date"]').attr('name', 'date[' + newIndex + ']');
                    $(this).find('[name^="grah_id"]').attr('name', 'grah_id[' + newIndex + ']');
                    $(this).find('[name^="start_time"]').attr('name', 'start_time[' + newIndex +
                        ']');
                    $(this).find('[name^="end_time"]').attr('name', 'end_time[' + newIndex + ']');

                    $(this).find('[id^="date_"]').attr('id', 'date_' + newIndex + 'error');
                    $(this).find('[id^="grah_"]').attr('id', 'grah_' + newIndex + 'error');
                    $(this).find('[id^="start_time_"]').attr('id', 'start_time_' + newIndex +
                        'error');
                    $(this).find('[id^="end_time_"]').attr('id', 'end_time_' + newIndex + 'error');
                });
            });


            // Function to validate time range



        });

        //     // Submit form validation
        //     $('#grahForm').on('submit', function(event) {
        //         let allFieldsFilled = true;

        //         // Validate all form controls with class .form-control
        //         $('#grahForm .form-control').each(function() {
        //             if ($(this).val().trim() === '') {
        //                 allFieldsFilled = false;
        //                 $(this).addClass('is-invalid'); // Add invalid class to show error
        //             } else {
        //                 $(this).removeClass(
        //                 'is-invalid'); // Remove invalid class if field is filled
        //             }
        //         });

        //         // Validate each appended set of data
        //         $('.added-option').each(function() {
        //             var optionIndex = $(this).index() +
        //             1; // Get the index of each added option dynamically

        //             if (!$("input[name='date[" + optionIndex + "]']").val().trim()) {
        //                 allFieldsFilled = false;
        //                 $("#date_" + optionIndex + "error").text("Date is required.").show();
        //             } else {
        //                 $("#date_" + optionIndex + "error").hide();
        //             }

        //             if ($("select[name='grah_id[" + optionIndex + "]']").val().trim() === '') {
        //                 allFieldsFilled = false;
        //                 $("#grah_" + optionIndex + "error").text("Grah Name is required.").show();
        //             } else {
        //                 $("#grah_" + optionIndex + "error").hide();
        //             }

        //             if ($("input[name='start_time[" + optionIndex + "]']").val().trim() === '') {
        //                 allFieldsFilled = false;
        //                 $("#start_time_" + optionIndex + "error").text("Start Time is required.")
        //                     .show();
        //             } else {
        //                 $("#start_time_" + optionIndex + "error").hide();
        //             }

        //             if (!$("input[name='end_time[" + optionIndex + "]']").val().trim()) {
        //                 allFieldsFilled = false;
        //                 $("#end_time_" + optionIndex + "error").text("End Time is required.")
        //             .show();
        //             } else {
        //                 $("#end_time_" + optionIndex + "error").hide();
        //             }
        //         });

        //         if (!allFieldsFilled) {
        //             event.preventDefault(); // Prevent form submission
        //             alert('Please fill in all required fields.');
        //         }
        //     });

        //     // Add option button click handler
        //     $('#addOption').on('click', function(e) {
        //         e.preventDefault();

        //         // Calculate the new index for the appended option
        //         var optionIndex = $('.added-option').length + 1;

        //         var field = '<div class="col-md-12 added-option">' +
        //             '<div class="row">' +
        //             '<label>_______________________________________________________________________________________________________________________________</label>' +
        //             '<div class="col-md-6 align-content-center mt-3">' +
        //             '<div class="row align-items-end">' +
        //             '<div class="additional-info">' +
        //             '<div class="form-group">' +
        //             '<label for="date" class="form-label"><strong>{{ trans('label.Date') }}</strong></label>' +
        //             '<input type="text" name="date[' + optionIndex + ']" class="form-control">' +
        //             '<div id="date_' + optionIndex + 'error" class="invalid-feedback"></div>' +
        //             '</div>' +
        //             '</div>' +
        //             '</div>' +
        //             '</div>' +
        //             '<div class="col-md-6 align-content-center mt-3">' +
        //             '<div class="row align-items-end">' +
        //             '<div class="additional-info">' +
        //             '<div class="form-group">' +
        //             '<label for="grah_id" class="form-label"><strong>{{ trans('label.Grah Name') }}</strong></label>' +
        //             '<select name="grah_id[' + optionIndex + ']" class="form-control">' +
        //             '@foreach ($grahs as $grah)' +
        //             '<option value="{{ $grah->id }}">{{ $grah->name }}</option>' +
        //             '@endforeach' +
        //             '</select>' +
        //             '<div id="grah_' + optionIndex + 'error" class="invalid-feedback"></div>' +
        //             '</div>' +
        //             '</div>' +
        //             '</div>' +
        //             '</div>' +
        //             '<div class="col-md-6 align-content-center mt-3">' +
        //             '<div class="row align-items-end">' +
        //             '<div class="additional-info">' +
        //             '<div class="form-group">' +
        //             '<label for="start_time" class="form-label"><strong>{{ trans('label.Start Time') }}</strong></label>' +
        //             '<input type="time" name="start_time[' + optionIndex +
        //             ']" class="form-control" onclick="this.focus()" onchange="validateTimeRange(this)" />' +
        //             '<div id="start_time_' + optionIndex + 'error" class="invalid-feedback"></div>' +
        //             '</div>' +
        //             '</div>' +
        //             '</div>' +
        //             '</div>' +
        //             '<div class="col-md-6 align-content-center mt-3">' +
        //             '<div class="row align-items-end">' +
        //             '<div class="additional-info">' +
        //             '<div class="form-group">' +
        //             '<label for="end_time" class="form-label"><strong>{{ trans('label.End Time') }}</strong></label>' +
        //             '<input type="time" name="end_time[' + optionIndex +
        //             ']" class="form-control" onclick="this.focus()" onchange="validateTimeRange(this)" />' +
        //             '<div id="end_time_' + optionIndex + 'error" class="invalid-feedback"></div>' +
        //             '</div>' +
        //             '</div>' +
        //             '</div>' +
        //             '</div>' +
        //             '<div class="col-md-1 mt-2 additional-info">' +
        //             '<div class="form-group">' +
        //             '<button class="btn btn-sm btn-danger cancel-option"><i class="bi bi-trash" aria-hidden="true"></i></button>' +
        //             '</div>' +
        //             '</div>' +
        //             '</div>' +
        //             '</div>';

        //         $('.appending_div').append(field);

        //         optionIndex++;

        //         $('.added-option:last .date').datepicker({
        //             dateFormat: 'dd-mm-yy', // Set the desired date format
        //             autoclose: true, // Close the datepicker when a date is selected
        //             todayHighlight: true // Highlight today's date
        //         });
        //     });

        //     // Event delegation for the cancel button
        //     $('.appending_div').on('click', '.cancel-option', function(e) {
        //         e.preventDefault();

        //         // Hide only the specific row containing the "Option Name" and "Icon" fields
        //         $(this).closest('.added-option').remove();

        //         // Update the index and IDs for remaining options
        //         $('.added-option').each(function(index) {
        //             var newIndex = index + 1;
        //             $(this).find('[name^="date"]').attr('name', 'date[' + newIndex + ']');
        //             $(this).find('[name^="grah_id"]').attr('name', 'grah_id[' + newIndex + ']');
        //             $(this).find('[name^="start_time"]').attr('name', 'start_time[' + newIndex +
        //                 ']');
        //             $(this).find('[name^="end_time"]').attr('name', 'end_time[' + newIndex + ']');

        //             $(this).find('[id^="date_"]').attr('id', 'date_' + newIndex + 'error');
        //             $(this).find('[id^="grah_"]').attr('id', 'grah_' + newIndex + 'error');
        //             $(this).find('[id^="start_time_"]').attr('id', 'start_time_' + newIndex +
        //                 'error');
        //             $(this).find('[id^="end_time_"]').attr('id', 'end_time_' + newIndex + 'error');
        //         });
        //     });
        // });


        $('.date').datepicker({
            dateFormat: 'dd-mm-yy', // Set the desired date format
            autoclose: true, // Close the datepicker when a date is selected
            todayHighlight: true // Highlight today's date
        });

        function validateTimeRange(input) {
            var selectedTime = input.value;
            var startTime = "09:00";
            var endTime = "15:30";

            if (selectedTime < startTime || selectedTime > endTime) {
                alert("Please select a time between 9:00 AM and 3:30 PM.");
                input.value = ''; // Clear the invalid value
            }
        }

        $('form').submit(function(e) {

            var date = $('#date').val().trim();
            var start_time = $('#start_time').val().trim();
            var end_time = $('#end_time').val().trim();
            var grah_id = $('#grah_id').val().trim();


            //questionType
            if (date === '') {
                $('#date').addClass('is-invalid');
                $('#date_error').text('Date is required.');
                e.preventDefault();
            } else {
                $('#date').removeClass('is-invalid');
                $('#date_error').text('');
            }

            if (grah_id === '') {
                $('#grah_id').addClass('is-invalid');
                $('#grah_error').text('Grah Name is required.');
                e.preventDefault();
            } else {
                $('#grah_id').removeClass('is-invalid');
                $('#grah_error').text('');
            }

            //questionName
            if (start_time === '') {
                $('#start_time').addClass('is-invalid');
                $('#start_time_error').text('Start Time is required.');
                e.preventDefault();
            } else {
                $('#start_time').removeClass('is-invalid');
                $('#start_time_error').text('');
            }

            //optionName1
            if (end_time === '') {
                $('#end_time').addClass('is-invalid');
                $('3end_time_error').text('End Time is required.');
                e.preventDefault();
            } else {
                $('#end_time').removeClass('is-invalid');
                $('#end_time_error').text('');
            }


        });
    </script>

@endsection
