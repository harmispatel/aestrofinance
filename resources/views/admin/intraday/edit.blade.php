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
                        <li class="breadcrumb-item active">{{ trans('label.Edit') }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    {{-- Clients Card --}}
    <div class="col-md-12">
        <div class="card">
            <form class="form" action="{{ route('intraday.update') }}" method="POST" id="intradayForm" novalidate>
                <input type="hidden" name="id" id="id" value="{{ encrypt($intra->id) }}">

                <div class="card-body">
                    @csrf
                    <div class="form_box">
                        <div class="form_box_inr">
                            <div class="box_title">
                                <h2>{{ trans('label.IntraDay') }}</h2>
                            </div>
                            <div class="form_box_info csm_que">
                                <div class="row" id="data">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="Date"
                                                class="form-label"><strong>{{ trans('label.Date') }}</strong>
                                                <span class="text-danger">*</span></label>
                                            <input type="text" name="date" id="date"
                                                value="{{ old('date', $intra->date ? \Carbon\Carbon::createFromFormat('Y-m-d', $intra->date)->format('d-m-y') : '') }}"
                                                class="form-control">
                                            <div id="date_error" class="invalid-feedback"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mt-4">
                                    </div>
                                    @foreach ($intraValues as $id => $value)
                                  
                                        <div class="col-md-12 added-option">
                                            <div class="row align-items-end ">
                                                <label>_______________________________________________________________________________________________________________________________</label>
                                                <div class="col-md-3 additional-info">
                                                    <div class="form-group">
                                                        <label for="start_time"
                                                            class="form-label"><strong>{{ trans('label.Start Time') }}</strong></label>
                                                        <input type="hidden" name="intra_id[{{$id}}]" id="id"
                                                            value="{{ $value->id }}" class="form-control">
                                                        <input type="time" name="start_time[{{$id}}]" id="start_time"
                                                            value="{{ $value->start_time }}" class="form-control"
                                                            onclick="this.focus()" onchange="validateTimeRange(this)" />
                                                        <div id="start_time_{{$id}}error" class="invalid-feedback"></div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 additional-info">
                                                    <div class="form-group">
                                                        <label for="end_time"
                                                            class="form-label"><strong>{{ trans('label.End Time') }}</strong></label>
                                                        <input type="time" name="end_time[{{$id}}]" id="end_time"
                                                            value="{{ $value->end_time }}" class="form-control"
                                                            onclick="this.focus()" onchange="validateTimeRange(this)" />
                                                        <div id="end_time_{{$id}}error" class="invalid-feedback"></div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 additional-info mt-3"></div>
                                                <div class="col-md-3 additional-info mt-3">
                                                    <label for="buy_or_sale" class="form-label">
                                                        <strong>{{ trans('label.Buy Or Sell') }}</strong>
                                                    </label>
                                                    <div class="form-group">
                                                        <div class="form-check">
                                                            <input type="radio" name="buy_or_sale[{{ $loop->index }}]"
                                                                id="buy_option" value="BUY" class="form-check-input"
                                                                {{ $value->buy_or_sale == 'BUY' ? 'checked' : '' }} />
                                                            <label for="buy_option" class="form-check-label">Buy</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input type="radio" name="buy_or_sale[{{ $loop->index }}]"
                                                                id="sell_option" value="SELL" class="form-check-input"
                                                                {{ $value->buy_or_sale == 'SELL' ? 'checked' : '' }} />
                                                            <label for="sell_option" class="form-check-label">Sell</label>
                                                        </div>
                                                        <div id="buy_or_sale_{{$id}}_feedback" class="invalid-feedback"></div>
                                                    </div>
                                                </div>

                                                <div class="col-md-3 additional-info mt-3">
                                                    <label for="nifty_or_banknifty" class="form-label">
                                                        <strong>{{ trans('label.Nifty Or BankNifty') }}</strong>
                                                    </label>
                                                    <div class="form-group">
                                                        <div class="form-check">
                                                            <input type="radio"
                                                                name="nifty_or_banknifty[{{ $loop->index }}]"
                                                                id="nifty_option" value="Nifty" class="form-check-input"
                                                                {{ $value->nifty_or_banknifty == 'Nifty' ? 'checked' : '' }} />
                                                            <label for="nifty_option"
                                                                class="form-check-label">Nifty</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input type="radio"
                                                                name="nifty_or_banknifty[{{ $loop->index }}]"
                                                                id="banknifty_option" value="BankNifty"
                                                                class="form-check-input"
                                                                {{ $value->nifty_or_banknifty == 'BankNifty' ? 'checked' : '' }} />
                                                            <label for="banknifty_option"
                                                                class="form-check-label">BankNifty</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input type="radio"
                                                                name="nifty_or_banknifty[{{ $loop->index }}]"
                                                                id="both_option" value="Both" class="form-check-input"
                                                                {{ $value->nifty_or_banknifty == 'Both' ? 'checked' : '' }} />
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
                                                            <input type="radio"
                                                                name="featureby_or_optionby[{{ $loop->index }}]"
                                                                id="featureby_option" value="Future"
                                                                class="form-check-input"
                                                                {{ $value->featureby_or_optionby == 'Future' ? 'checked' : '' }} />
                                                            <label for="featureby_option"
                                                                class="form-check-label">Future</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input type="radio"
                                                                name="featureby_or_optionby[{{ $loop->index }}]"
                                                                id="optionby_option" value="Option"
                                                                class="form-check-input"
                                                                {{ $value->featureby_or_optionby == 'Option' ? 'checked' : '' }} />
                                                            <label for="optionby_option"
                                                                class="form-check-label">Option</label>
                                                        </div>
                                                        <div id="featureby_or_optionby_feedback" class="invalid-feedback">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                </div>
                                                <div class="col-md-2 additional-info mt-3">
                                                    <div class="form-group">
                                                        <label for="target_price"
                                                            class="form-label"><strong>{{ trans('label.Target price') }}</strong></label>
                                                        <input type="number" name="target_price[{{$id}}]" id="target_price"
                                                            min=1 class="form-control"
                                                            value="{{ $value->target_price }}" />
                                                        <div id="target_price_{{$id}}error" class="invalid-feedback"></div>
                                                    </div>
                                                </div>
                                                <div class="col-md-2 additional-info mt-3">
                                                    <div class="form-group">
                                                        <label for="quantity"
                                                            class="form-label"><strong>{{ trans('label.Quantity') }}</strong></label>
                                                        <input type="number" name="quantity[{{$id}}]" id="quantity" min=1
                                                            class="form-control" value="{{ $value->quantity }}" />
                                                        <div id="qty_{{$id}}error" class="invalid-feedback"></div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 text-end mt-3 additional-info">
                                                    <button class="btn btn-sm btn-danger cancel-option"
                                                        id="remove"><i class="bi bi-trash"
                                                            aria-hidden="true"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach

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
                    <button type="submit" class="btn form_button">{{ trans('label.Update') }}</button>
                </div>
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

        $(document).ready(function() {

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

            // Validate each appended set of data
            $('.added-option').each(function() {
                var optionIndex = $(this).index('.added-option');

                if ($("input[name='start_time[" + optionIndex + "]']").val().trim() === '') {
                    allFieldsFilled = false;
                    $("#start_time_" + optionIndex + "error").text("Start Time is required.").show();
                } else {
                    $("#start_time_" + optionIndex + "error").hide();
                }

                if ($("input[name='end_time[" + optionIndex + "]']").val().trim() === '') {
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

            var optionIndex = $('.added-option').length; // Start index from 1

            console.log('Current Index:', optionIndex);

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
                    '<button id="remove" class="btn btn-sm mx-3 btn-danger cancel-option"><i class="bi bi-trash" aria-hidden="true"></i></button>' +
                    '</div>' +
                    '</div>' +
                    '</div>' +
                    '</div>' +
                    '</div>';

                  

                $('.appending_div').append(field);

                optionIndex++; // Increment index for the next option
            });

            // Event delegation for the cancel button
            $('#data').on('click', '.cancel-option', function(e) {
                e.preventDefault();

                // Hide only the specific row containing the "Option Name" and "Icon" fields
                $(this).closest('.added-option').remove();

                $('.added-option').each(function(index) {
                    $(this).find('[name^="intra_id"]').attr('name', 'intra_id[' + index +
                        ']');
                    $(this).find('[name^="start_time"]').attr('name', 'start_time[' + index +
                        ']');
                    $(this).find('[name^="end_time"]').attr('name', 'end_time[' + index + ']');
                    $(this).find('[name^="buy_or_sale"]').attr('name', 'buy_or_sale[' + index +
                        ']');
                    $(this).find('[name^="nifty_or_banknifty"]').attr('name',
                        'nifty_or_banknifty[' + index + ']');
                    $(this).find('[name^="featureby_or_optionby"]').attr('name',
                        'featureby_or_optionby[' + index + ']');
                    $(this).find('[name^="target_price"]').attr('name', 'target_price[' + index +
                        ']');
                    $(this).find('[name^="quantity"]').attr('name', 'quantity[' + index + ']');

                    $(this).find('[id^="start_time_"]').attr('id', 'start_time_' + index +
                        'error');
                    $(this).find('[id^="end_time_"]').attr('id', 'end_time_' + index + 'error');
                    $(this).find('[id^="buy_or_sale_"]').attr('id', 'buy_or_sale_' + index +
                        '_feedback');
                    $(this).find('[id^="nifty_or_banknifty_"]').attr('id', 'nifty_or_banknifty_' +
                        index + '_feedback');
                    $(this).find('[id^="featureby_or_optionby_"]').attr('id',
                        'featureby_or_optionby_' + index + '_feedback');
                    $(this).find('[id^="target_price_"]').attr('id', 'target_price_' + index +
                        'error');
                    $(this).find('[id^="qty_"]').attr('id', 'qty_' + index + 'error');
                });
                optionIndex--;
            });


        });

        // remove line
        // function removeOption(button) {
        //     // Get the parent div of the clicked button and remove it
        //     $(button).closest('.added-option').remove();

        //     $('.added-option').each(function(index) {
                   
        //             $(this).find('[name^="id"]').attr('name', 'id[' + index +
        //             ']');
        //             $(this).find('[name^="start_time"]').attr('name', 'start_time[' + index +
        //                 ']');
        //             $(this).find('[name^="end_time"]').attr('name', 'end_time[' + index + ']');
        //             $(this).find('[name^="buy_or_sale"]').attr('name', 'buy_or_sale[' + index +
        //                 ']');
        //             $(this).find('[name^="nifty_or_banknifty"]').attr('name',
        //                 'nifty_or_banknifty[' + index + ']');
        //             $(this).find('[name^="featureby_or_optionby"]').attr('name',
        //                 'featureby_or_optionby[' + index + ']');
        //             $(this).find('[name^="target_price"]').attr('name', 'target_price[' + index +
        //                 ']');
        //             $(this).find('[name^="quantity"]').attr('name', 'quantity[' + index + ']');

        //             $(this).find('[id^="start_time_"]').attr('id', 'start_time_' + index +
        //                 'error');
        //             $(this).find('[id^="end_time_"]').attr('id', 'end_time_' + index + 'error');
        //             $(this).find('[id^="buy_or_sale_"]').attr('id', 'buy_or_sale_' + index +
        //                 '_feedback');
        //             $(this).find('[id^="nifty_or_banknifty_"]').attr('id', 'nifty_or_banknifty_' +
        //                 index + '_feedback');
        //             $(this).find('[id^="featureby_or_optionby_"]').attr('id',
        //                 'featureby_or_optionby_' + index + '_feedback');
        //             $(this).find('[id^="target_price_"]').attr('id', 'target_price_' + index +
        //                 'error');
        //             $(this).find('[id^="qty_"]').attr('id', 'qty_' + index + 'error');
        //         });
        //         optionIndex--;
        // }
    </script>

@endsection