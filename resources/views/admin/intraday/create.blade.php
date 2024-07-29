@extends('admin.layouts.admin-layout')

@section('title', 'Intraday')

@section('content')



    {{-- Page Title --}}
    <div class="pagetitle">
        <h1>{{ trans('label.IntraDay') }}</h1>
        <div class="row">
            <div class="col-md-8">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active"> <a
                                href="{{ route('dashboard') }}">{{ trans('label.Dashboard') }}</a> </li>
                        <li class="breadcrumb-item active"> <a
                                href="{{ route('intraday') }}">{{ trans('label.IntraDay') }}</a> </li>
                        <li class="breadcrumb-item active">{{ trans('label.Create') }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    {{-- Clients Card --}}
    <div class="col-md-12">
        <div class="card">
            <form class="form" action="{{ route('intraday.store') }}" method="POST" id="intradayForm" novalidate>
                <div class="card-body">
                    @csrf
                    <div class="form_box">
                        <div class="form_box_inr">
                            <div class="box_title">
                                <h2>{{ trans('label.IntraDay') }}</h2>
                            </div>
                            <div class="form_box_info csm_que">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="Date"
                                                class="form-label"><strong>{{ trans('label.Date') }}</strong>
                                                <span class="text-danger">*</span></label>
                                            <input type="text" name="date" id="date" class="form-control">
                                            <div id="date_error" class="invalid-feedback"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                    </div>

                                    <div class="col-md-3 mt-3 additional-info">
                                        <div class="form-group">
                                            <label for="start_time"
                                                class="form-label"><strong>{{ trans('label.Start Time') }}</strong></label>
                                            <input type="time" name="start_time[]" id="start_time" class="form-control"
                                                onclick="this.focus()" onchange="validateTimeRange(this)" />
                                            <div id="start_time_error" class="invalid-feedback"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 mt-3 additional-info">
                                        <div class="form-group">
                                            <label for="end_time"
                                                class="form-label"><strong>{{ trans('label.End Time') }}</strong></label>
                                            <input type="time" name="end_time[]" id="end_time" class="form-control"
                                                onclick="this.focus()" onchange="validateTimeRange(this)" />
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
                                                <input type="radio" name="buy_or_sale[]" id="buy_option" value="BUY"
                                                    class="form-check-input" />
                                                <label for="buy_option" class="form-check-label">Buy</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="radio" name="buy_or_sale[]" id="sell_option" value="SELL"
                                                    class="form-check-input" />
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
                                                <input type="radio" name="nifty_or_banknifty[]" id="nifty_option"
                                                    value="Nifty" class="form-check-input" />
                                                <label for="nifty_option" class="form-check-label">Nifty</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="radio" name="nifty_or_banknifty[]" id="banknifty_option"
                                                    value="BankNifty" class="form-check-input" />
                                                <label for="banknifty_option" class="form-check-label">BankNifty</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="radio" name="nifty_or_banknifty[]" id="both_option"
                                                    value="Both" class="form-check-input" checked />
                                                <label for="both_option" class="form-check-label">Both</label>
                                            </div>
                                            <div id="nifty_or_banknifty_feedback" class="invalid-feedback"></div>
                                        </div>
                                    </div>

                                    <div class="col-md-3 additional-info mt-3">
                                        <label for="featureby_or_optionby" class="form-label">
                                            <strong>{{ trans('label.Future Or Option') }}</strong>
                                        </label>
                                        <div class="form-group">
                                            <div class="form-check">
                                                <input type="radio" name="featureby_or_optionby[]"
                                                    id="featureby_option" value="Future" class="form-check-input" />
                                                <label for="featureby_option" class="form-check-label">Future</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="radio" name="featureby_or_optionby[]" id="optionby_option"
                                                    value="Option" class="form-check-input" checked />
                                                <label for="optionby_option" class="form-check-label">Option</label>
                                            </div>
                                            <div id="featureby_or_optionby_feedback" class="invalid-feedback"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-2 additional-info mt-3">
                                    </div>
                                    <div class="col-md-2 additional-info mt-3">
                                        <div class="form-group">
                                            <label for="target_price"
                                                class="form-label"><strong>{{ trans('label.Target price') }}</strong></label>
                                            <input type="number" name="target_price[]" min=1 id="target_price"
                                                class="form-control" value="20" />
                                            <div id="target_price_error" class="invalid-feedback"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-2 additional-info mt-3">
                                        <div class="form-group">
                                            <label for="quantity"
                                                class="form-label"><strong>{{ trans('label.Quantity') }}</strong></label>
                                            <input type="number" name="quantity[]" id="quantity" min=1
                                                class="form-control" value="1" />
                                            <div id="qty_error" class="invalid-feedback"></div>
                                        </div>
                                    </div>
                                    <div class="row appending_div">
                                    </div>
                                    <div class="col-md-12 additional-info text-end">
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

            </form>
        </div>
    </div>

@endsection

@section('page-js')

    <script>
        // Function to validate time range
        function validateTimeRange(input) {
            var selectedTime = input.value;
            var startTime = "09:00";
            var endTime = "15:30";

            if (selectedTime < startTime || selectedTime > endTime) {
                alert("Please select a time between 9:00 AM and 3:30 PM.");
                input.value = ''; // Clear the invalid value
            }
        }

        $('#intradayForm').on('submit', function(event) {
            let allFieldsFilled = true;

            // Validate all form controls with class .form-control
            $('#intradayForm .form-control').each(function() {
                if ($(this).val().trim() === '') {
                    allFieldsFilled = false;
                    $(this).addClass('is-invalid'); // Add invalid class to show error
                } else {
                    $(this).removeClass('is-invalid'); // Remove invalid class if field is filled
                }
            });

            // Validate radio buttons for Buy or Sell
            // if (!$("input[name^='buy_or_sale']:checked").length) {
            //     allFieldsFilled = false;
            //     $("#buy_or_sale_feedback").text("Please select Buy or Sell").show();
            // } else {
            //     $("#buy_or_sale_feedback").hide();
            // }

            // Validate each appended set of data
            $('.added-option').each(function() {
                var optionIndex = $(this).index() + 1;

                if (!$("input[name='start_time[" + optionIndex + "]']").val().trim()) {
                    allFieldsFilled = false;
                    $("#start_time_" + optionIndex + "error").text("Start Time is required.").show();
                } else {
                    $("#start_time_" + optionIndex + "error").hide();
                }

                if (!$("input[name='end_time[" + optionIndex + "]']").val().trim()) {
                    allFieldsFilled = false;
                    $("#end_time_" + optionIndex + "error").text("End Time is required.").show();
                } else {
                    $("#end_time_" + optionIndex + "error").hide();
                }

                // if (!$("input[name='buy_or_sale[" + optionIndex + "]']:checked").length) {
                //     allFieldsFilled = false;
                //     $("#buy_or_sale_" + optionIndex + "_feedback").text("Please select Buy or Sell").show();
                // } else {
                //     $("#buy_or_sale_" + optionIndex + "_feedback").hide();
                // }

                if (!$("input[name='nifty_or_banknifty[" + optionIndex + "]']:checked").length) {
                    allFieldsFilled = false;
                    $("#nifty_or_banknifty_" + optionIndex + "_feedback").text(
                        "Please select Nifty or BankNifty").show();
                } else {
                    $("#nifty_or_banknifty_" + optionIndex + "_feedback").hide();
                }

                if (!$("input[name='featureby_or_optionby[" + optionIndex + "]']:checked").length) {
                    allFieldsFilled = false;
                    $("#featureby_or_optionby_" + optionIndex + "_feedback").text(
                        "Please select Future or Option").show();
                } else {
                    $("#featureby_or_optionby_" + optionIndex + "_feedback").hide();
                }

                if ($("input[name='quantity[" + optionIndex + "]']").val().trim() === '') {
                    allFieldsFilled = false;
                    $("#qty_" + optionIndex + "error").text("Quantity is required.").show();
                } else {
                    $("#qty_" + optionIndex + "error").hide();
                }

                if ($("input[name='target_price[" + optionIndex + "]']").val().trim() === '') {
                    allFieldsFilled = false;
                    $("#target_price_" + optionIndex + "error").text("Target Price is required.").show();
                } else {
                    $("#target_price_" + optionIndex + "error").hide();
                }
            });

            if (!allFieldsFilled) {
                event.preventDefault(); // Prevent form submission
                alert('Please fill in all required fields.');
            }
        });


        // Initialize date picker
        $('#date').datepicker({
            dateFormat: 'dd-mm-yy', // Set the desired date format
            autoclose: true, // Close the datepicker when a date is selected
            todayHighlight: true // Highlight today's date
        });

        // question option 
        // $(document).ready(function() {
        //     // Attach a change event listener to the radio buttons
        //     $('.is-available-radio').change(function() {
        //         // Get the selected value
        //         var selectedValue = $(this).val();

        //         // Show or hide the additional-info div based on the selected value
        //         if (selectedValue == 1) {
        //             $('.additional-info').show();
        //         } else {
        //             $('.additional-info').hide();
        //         }
        //     });
        // });


        // **  multiple option_name  **

        $(document).ready(function() {


            var optionIndex = 1; // Start index from 1

            $('#addOption').on('click', function(e) {
                e.preventDefault();

                var field = '<div class="col-md-12 added-option">' +
                    '<div class="row">' +
                    '<label>_______________________________________________________________________________________________________________________________</label>' +
                    '<div class="col-md-3 align-content-center mt-3">' +
                    '<div class="row align-items-end">' +
                    '<div class="additional-info ">' +
                    '<div class="form-group">' +
                    '<label for="start_time" class="form-label">' +
                    '<strong>{{ trans('label.Start Time') }}</strong>' +
                    '</label>' +
                    '<input type="time" name="start_time[' + optionIndex +
                    ']" class="form-control"  onclick="this.focus()" onchange="validateTimeRange(this)" />' +
                    '<div id="start_time_' + optionIndex + 'error" class="invalid-feedback"></div>' +
                    '</div>' +
                    '</div>' +
                    '</div>' +
                    '</div>' +
                    '<div class="col-md-3 align-content-center mt-3">' +
                    '<div class="row align-items-end">' +
                    '<div class="additional-info ">' +
                    '<div class="form-group">' +
                    '<label for="end_time" class="form-label">' +
                    '<strong>{{ trans('label.End Time') }}</strong>' +
                    '</label>' +
                    '<input type="time" name="end_time[' + optionIndex +
                    ']" class="form-control"  onclick="this.focus()" onchange="validateTimeRange(this)" />' +
                    '<div id="end_time_' + optionIndex + 'error" class="invalid-feedback"></div>' +
                    '</div>' +
                    '</div>' +
                    '</div>' +
                    '</div>' +
                    '<div class="col-md-6 additional-info"></div>' +
                    '<div class="col-md-3 align-content-center mt-3">' +
                    '<div class="row align-items-end">' +
                    '<div class="additional-info ">' +
                    '<label for="buy_or_sale" class="form-label">' +
                    '<strong>{{ trans('label.Buy Or Sell') }}</strong>' +
                    '</label>' +
                    '<div class="form-group">' +
                    '<div class="form-check">' +
                    '<input type="radio" name="buy_or_sale[' + optionIndex +
                    ']" value="BUY" class="form-check-input" id="buy_option_' + optionIndex + '" />' +
                    '<label class="form-check-label" for="buy_option_' + optionIndex + '">Buy</label>' +
                    '</div>' +
                    '<div class="form-check">' +
                    '<input type="radio" name="buy_or_sale[' + optionIndex +
                    ']" value="SELL" class="form-check-input" id="sell_option_' + optionIndex + '" />' +
                    '<label class="form-check-label" for="sell_option_' + optionIndex + '">Sell</label>' +
                    '</div>' +
                    '<div id="buy_or_sale_' + optionIndex + '_feedback" class="invalid-feedback"></div>' +
                    '</div>' +
                    '</div>' +
                    '</div>' +
                    '</div>' +
                    '<div class="col-md-3 align-content-center mt-3">' +
                    '<div class="row align-items-end">' +
                    '<div class="additional-info ">' +
                    '<label for="nifty_or_banknifty" class="form-label">' +
                    '<strong>{{ trans('label.Nifty Or BankNifty') }}</strong>' +
                    '</label>' +
                    '<div class="form-group">' +
                    '<div class="form-check">' +
                    '<input type="radio" name="nifty_or_banknifty[' + optionIndex +
                    ']" value="Nifty" class="form-check-input" id="nifty_option_' + optionIndex + '" />' +
                    '<label class="form-check-label" for="nifty_option_' + optionIndex + '">Nifty</label>' +
                    '</div>' +
                    '<div class="form-check">' +
                    '<input type="radio" name="nifty_or_banknifty[' + optionIndex +
                    ']" value="BankNifty" class="form-check-input" id="banknifty_option_' + optionIndex +
                    '" />' +
                    '<label class="form-check-label" for="banknifty_option_' + optionIndex +
                    '">BankNifty</label>' +
                    '</div>' +
                    '<div class="form-check">' +
                    '<input type="radio" name="nifty_or_banknifty[' + optionIndex +
                    ']" value="Both" class="form-check-input" id="both_option_' + optionIndex +
                    '" checked/>' +
                    '<label class="form-check-label" for="both_option_' + optionIndex + '">Both</label>' +
                    '</div>' +
                    '<div id="nifty_or_banknifty_' + optionIndex +
                    '_feedback" class="invalid-feedback"></div>' +
                    '</div>' +
                    '</div>' +
                    '</div>' +
                    '</div>' +
                    '<div class="col-md-3 align-content-center mt-3">' +
                    '<div class="row align-items-end">' +
                    '<div class="additional-info ">' +
                    '<label for="featureby_or_optionby" class="form-label">' +
                    '<strong>{{ trans('label.Future Or Option') }}</strong>' +
                    '</label>' +
                    '<div class="form-group">' +
                    '<div class="form-check">' +
                    '<input type="radio" name="featureby_or_optionby[' + optionIndex +
                    ']" value="Future" class="form-check-input" id="feature_option_' + optionIndex +
                    '" />' +
                    '<label class="form-check-label" for="feature_option_' + optionIndex +
                    '">Future</label>' +
                    '</div>' +
                    '<div class="form-check">' +
                    '<input type="radio" name="featureby_or_optionby[' + optionIndex +
                    ']" value="Option" class="form-check-input" id="option_option_' + optionIndex +
                    '" checked/>' +
                    '<label class="form-check-label" for="option_option_' + optionIndex +
                    '">Option</label>' +
                    '</div>' +
                    '<div id="featureby_or_optionby_' + optionIndex +
                    '_feedback" class="invalid-feedback"></div>' +
                    '</div>' +
                    '</div>' +
                    '</div>' +
                    '</div>' +
                    '<div class="col-md-2 align-content-center mt-3">' +
                    '</div>' +
                    '<div class="col-md-2 align-content-center mt-3">' +
                    '<div class="row align-items-end">' +
                    '<div class="additional-info ">' +
                    '<label for="target_price" class="form-label">' +
                    '<strong>{{ trans('label.Target price') }}</strong>' +
                    '</label>' +
                    '<div class="form-group">' +
                    '<input type="number" name="target_price[' + optionIndex +
                    ']" min="1" id="target_price" class="form-control" value="20"/>' +
                    '<div id="target_price_' + optionIndex +
                    'error" class="invalid-feedback"></div>' +
                    '</div>' +
                    '</div>' +
                    '</div>' +
                    '</div>' +
                    '<div class="col-md-2 align-content-center mt-3">' +
                    '<div class="row align-items-end">' +
                    '<div class="additional-info ">' +
                    '<label for="quantity" class="form-label">' +
                    '<strong>{{ trans('label.Quantity') }}</strong>' +
                    '</label>' +
                    '<div class="form-group">' +
                    '<input type="number" name="quantity[' + optionIndex +
                    ']" min="1" class="form-control" value="1"/>' +
                    '<div id="qty_' + optionIndex + 'error" class="invalid-feedback"></div>' +
                    '</div>' +
                    '</div>' +
                    '</div>' +
                    '</div>' +
                    '<div class="col-md-7 text-end align-content-center mt-5">' +
                    '<div class="row align-items-end">' +
                    '<div class="additional-info ">' +
                    '<button class="btn btn-sm mx-3 btn-danger cancel-option"><i class="bi bi-trash" aria-hidden="true"></i></button>' +
                    '</div>' +
                    '</div>' +
                    '</div>' +
                    '</div>' +
                    '</div>';


                $('.appending_div').append(field);

                optionIndex++; // Increment index for the next option
            });

            // Event delegation for the cancel button
            $('.appending_div').on('click', '.cancel-option', function(e) {
                e.preventDefault();

                // Hide only the specific row containing the "Option Name" and "Icon" fields
                $(this).closest('.added-option').remove();

                $('.added-option').each(function(index) {
                    var newIndex = index + 1;
                    $(this).find('[name^="start_time"]').attr('name', 'start_time[' + newIndex +
                        ']');
                    $(this).find('[name^="end_time"]').attr('name', 'end_time[' + newIndex + ']');
                    $(this).find('[name^="buy_or_sale"]').attr('name', 'buy_or_sale[' + newIndex +
                        ']');
                    $(this).find('[name^="nifty_or_banknifty"]').attr('name',
                        'nifty_or_banknifty[' + newIndex + ']');
                    $(this).find('[name^="featureby_or_optionby"]').attr('name',
                        'featureby_or_optionby[' + newIndex + ']');
                    $(this).find('[name^="target_price"]').attr('name', 'target_price[' + newIndex +
                        ']');
                    $(this).find('[name^="quantity"]').attr('name', 'quantity[' + newIndex + ']');

                    $(this).find('[id^="start_time_"]').attr('id', 'start_time_' + newIndex +
                        'error');
                    $(this).find('[id^="end_time_"]').attr('id', 'end_time_' + newIndex + 'error');
                    $(this).find('[id^="buy_or_sale_"]').attr('id', 'buy_or_sale_' + newIndex +
                        '_feedback');
                    $(this).find('[id^="nifty_or_banknifty_"]').attr('id', 'nifty_or_banknifty_' +
                        newIndex + '_feedback');
                    $(this).find('[id^="featureby_or_optionby_"]').attr('id',
                        'featureby_or_optionby_' + newIndex + '_feedback');
                    $(this).find('[id^="target_price_"]').attr('id', 'target_price_' + newIndex +
                        'error');
                    $(this).find('[id^="qty_"]').attr('id', 'qty_' + newIndex + 'error');
                });
                optionIndex--;
            });


        });

        $('form').submit(function(e) {
            var date = $('#date').val().trim();
            var start_time = $('#start_time').val().trim();
            var end_time = $('#end_time').val().trim();
            var target_price = $('#target_price').val().trim();
            var qty = $('#quantity').val().trim();


            //questionType
            if (date === '') {
                $('#date').addClass('is-invalid');
                $('#date_error').text('Date is required.');
                e.preventDefault();
            } else {
                $('#date').removeClass('is-invalid');
                $('#date_error').text('');
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
                $('#end_time_error').text('End Time is required.');
                e.preventDefault();
            } else {
                $('#end_time').removeClass('is-invalid');
                $('#end_time_error').text('');
            }

            //optionName1
            if (qty === '') {
                $('#quantity').addClass('is-invalid');
                $('#qty_error').text('Quantity is required.');
                e.preventDefault();
            } else {
                $('#quantity').removeClass('is-invalid');
                $('#qty_error').text('');
            }

            //target_price
            if (target_price === '') {
                $('#target_price').addClass('is-invalid');
                $('#target_price_error').text('Target Price is required.');
                e.preventDefault();
            } else {
                $('#target_price').removeClass('is-invalid');
                $('#target_price_error').text('');
            }


        });
    </script>

@endsection
