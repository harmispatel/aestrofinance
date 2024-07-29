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
                        <li class="breadcrumb-item active">GannStocks Create</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    {{-- Clients Card --}}
    <div class="gann_date_page">
        <div class="row justify-content-center">
            <div class="col-md-9">
                <form action="{{ route('gannStocks.store') }}" method="POST" id="GannForm">
                    @csrf
                    <div class="gann_date_main">
                        <div class="gann_date_head">
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <h4><strong>Enter Any One Field Stocks</strong>
                                        <span class="text-danger">*</span></h4>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <div class="form-group">
                                        <label for="Stokes" class="form-label"><strong>Stocks</strong></label>
                                        <select name="stokes" class="form-control" id="Stokes">
                                            <option value="">-- Select Stock --</option>
                                            @foreach ($stokNames as $stokName)
                                                <option value="{{ $stokName }}">{{ $stokName }}</option>
                                            @endforeach
                                        </select>
                                        <div id="Stokes_error" class="invalid-feedback"></div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <div class="form-group">
                                        <label for="Stokes" class="form-label"><strong>Stocks</strong></label>
                                        <input type="text" name="stokes" class="form-control" id="Stokes2">

                                    </div>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <div class="form-group">
                                        <label for="stock_category" class="form-label"><strong>Stock Category</strong></label>
                                        <select name="stock_category" class="form-control" id="stock_category">
                                            <option value="1">Equities/Stocks</option>
                                            <option value="2">Commodities</option>
                                        </select>
                                        <div id="Stock_category_error" class="invalid-feedback"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="row align-items-center mt-4">
                                <div class="col-md-5">
                                    <div class="gann_date_head_title">
                                        <h4>Enter Any High / Low Date</h4>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="gann_start_date">
                                        <input type="text" class="form-control date" name="d_0" id="date">
                                    </div>
                                    <div id="date_error" style="color: red;"></div>
                                </div>
                                <div class="col-md-3 text-end">
                                    <div class="calculate_btn">
                                        <button id="calculateBtn" class="btn">Calculate</button>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="gann_date_field">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="gann_date_field_inr">
                                        <div class="row align-items-center">
                                            <div class="col-md-3">
                                                <div class="gann_date_degree">
                                                    <h4>30°</h4>
                                                </div>
                                            </div>
                                            <div class="col-md-9">
                                                <div class="gann_date_dates">
                                                    <input type="text" name="d_30" class="form-control" readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="gann_date_field_inr">
                                        <div class="row align-items-center">
                                            <div class="col-md-3">
                                                <div class="gann_date_degree">
                                                    <h4>45°</h4>
                                                </div>
                                            </div>
                                            <div class="col-md-9">
                                                <div class="gann_date_dates">
                                                    <input type="text" name="d_45" class="form-control" readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="gann_date_field_inr">
                                        <div class="row align-items-center">
                                            <div class="col-md-3">
                                                <div class="gann_date_degree">
                                                    <h4>60°</h4>
                                                </div>
                                            </div>
                                            <div class="col-md-9">
                                                <div class="gann_date_dates">
                                                    <input type="text" name="d_60" class="form-control" readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="gann_date_field_inr">
                                        <div class="row align-items-center">
                                            <div class="col-md-3">
                                                <div class="gann_date_degree">
                                                    <h4>72°</h4>
                                                </div>
                                            </div>
                                            <div class="col-md-9">
                                                <div class="gann_date_dates">
                                                    <input type="text" name="d_72" class="form-control" readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="gann_date_field_inr">
                                        <div class="row align-items-center">
                                            <div class="col-md-3">
                                                <div class="gann_date_degree">
                                                    <h4>90°</h4>
                                                </div>
                                            </div>
                                            <div class="col-md-9">
                                                <div class="gann_date_dates">
                                                    <input type="text" name="d_90" class="form-control" readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="gann_date_field_inr">
                                        <div class="row align-items-center">
                                            <div class="col-md-3">
                                                <div class="gann_date_degree">
                                                    <h4>120°</h4>
                                                </div>
                                            </div>
                                            <div class="col-md-9">
                                                <div class="gann_date_dates">
                                                    <input type="text" name="d_120" class="form-control" readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="gann_date_field_inr">
                                        <div class="row align-items-center">
                                            <div class="col-md-3">
                                                <div class="gann_date_degree">
                                                    <h4>135°</h4>
                                                </div>
                                            </div>
                                            <div class="col-md-9">
                                                <div class="gann_date_dates">
                                                    <input type="text" name="d_135" class="form-control" readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="gann_date_field_inr">
                                        <div class="row align-items-center">
                                            <div class="col-md-3">
                                                <div class="gann_date_degree">
                                                    <h4>150°</h4>
                                                </div>
                                            </div>
                                            <div class="col-md-9">
                                                <div class="gann_date_dates">
                                                    <input type="text" name="d_150" class="form-control" readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="gann_date_field_inr">
                                        <div class="row align-items-center">
                                            <div class="col-md-3">
                                                <div class="gann_date_degree">
                                                    <h4>180°</h4>
                                                </div>
                                            </div>
                                            <div class="col-md-9">
                                                <div class="gann_date_dates">
                                                    <input type="text" name="d_180" class="form-control" readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="gann_date_field_inr m-0">
                                        <div class="row align-items-center">
                                            <div class="col-md-3">
                                                <div class="gann_date_degree">
                                                    <h4>210°</h4>
                                                </div>
                                            </div>
                                            <div class="col-md-9">
                                                <div class="gann_date_dates">
                                                    <input type="text" name="d_210" class="form-control" readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="gann_date_field_inr">
                                        <div class="row align-items-center">
                                            <div class="col-md-3">
                                                <div class="gann_date_degree">
                                                    <h4>225°</h4>
                                                </div>
                                            </div>
                                            <div class="col-md-9">
                                                <div class="gann_date_dates">
                                                    <input type="text" name="d_225" class="form-control" readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="gann_date_field_inr">
                                        <div class="row align-items-center">
                                            <div class="col-md-3">
                                                <div class="gann_date_degree">
                                                    <h4>240°</h4>
                                                </div>
                                            </div>
                                            <div class="col-md-9">
                                                <div class="gann_date_dates">
                                                    <input type="text" name="d_240" class="form-control" readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="gann_date_field_inr">
                                        <div class="row align-items-center">
                                            <div class="col-md-3">
                                                <div class="gann_date_degree">
                                                    <h4>252°</h4>
                                                </div>
                                            </div>
                                            <div class="col-md-9">
                                                <div class="gann_date_dates">
                                                    <input type="text" name="d_252" class="form-control" readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="gann_date_field_inr">
                                        <div class="row align-items-center">
                                            <div class="col-md-3">
                                                <div class="gann_date_degree">
                                                    <h4>270°</h4>
                                                </div>
                                            </div>
                                            <div class="col-md-9">
                                                <div class="gann_date_dates">
                                                    <input type="text" name="d_270" class="form-control" readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="gann_date_field_inr">
                                        <div class="row align-items-center">
                                            <div class="col-md-3">
                                                <div class="gann_date_degree">
                                                    <h4>288°</h4>
                                                </div>
                                            </div>
                                            <div class="col-md-9">
                                                <div class="gann_date_dates">
                                                    <input type="text" name="d_288" class="form-control" readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="gann_date_field_inr">
                                        <div class="row align-items-center">
                                            <div class="col-md-3">
                                                <div class="gann_date_degree">
                                                    <h4>300°</h4>
                                                </div>
                                            </div>
                                            <div class="col-md-9">
                                                <div class="gann_date_dates">
                                                    <input type="text" name="d_300" class="form-control" readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="gann_date_field_inr">
                                        <div class="row align-items-center">
                                            <div class="col-md-3">
                                                <div class="gann_date_degree">
                                                    <h4>315°</h4>
                                                </div>
                                            </div>
                                            <div class="col-md-9">
                                                <div class="gann_date_dates">
                                                    <input type="text" name="d_315" class="form-control" readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="gann_date_field_inr">
                                        <div class="row align-items-center">
                                            <div class="col-md-3">
                                                <div class="gann_date_degree">
                                                    <h4>330°</h4>
                                                </div>
                                            </div>
                                            <div class="col-md-9">
                                                <div class="gann_date_dates">
                                                    <input type="text" name="d_330" class="form-control" readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="gann_date_field_inr m-0">
                                        <div class="row align-items-center">
                                            <div class="col-md-3">
                                                <div class="gann_date_degree">
                                                    <h4>360°</h4>
                                                </div>
                                            </div>
                                            <div class="col-md-9">
                                                <div class="gann_date_dates">
                                                    <input type="text" name="d_360" class="form-control" readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-center mt-5">
                            <button type="submit" class="btn form_button">{{ trans('label.Save') }}</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>

@endsection

@section('page-js')

    <script>
        $(document).ready(function() {
            $('#date').datepicker({
                dateFormat: 'dd-mm-yy', // Set the desired date format
                autoclose: true, // Close the datepicker when a date is selected
                todayHighlight: true // Highlight today's date
            });

            $('#Stokes').change(function (){
               var selectedValue = $(this).val();

               if(selectedValue !== ''){
                $('#Stokes2').prop('disabled',true);
               }else{
                $('#Stokes2').prop('disabled',false);
               }
            });

            $('#Stokes2').on('input',function (){
               var inputValue = $(this).val();

               if(inputValue !== ''){
                $('#Stokes').prop('disabled',true);
               }else{
                $('#Stokes').prop('disabled',false);
               }
            });


            $('#GannForm').on('submit', function(event) {
                event.preventDefault();

                stock = $('#Stokes').val();
                stock2 = $('#Stokes2').val();
                date = $('#date').val();

                if (stock === '' || stock2 === '') {
                    $('#Stokes_error').text('Please fill up any one field Stocks').show();;
                } else {
                    $('#Stokes_error').hide();

                }

                if (date === '') {
                    $('#date_error').text('Please Select Date').show();;
                } else {
                    $('#date_error').hide();
                }

                if ((stock !== '' || stock2 !== '') && date !== '') {
                    this.submit();
                }

            });


            // $('#gannDatesForm').on('submit', function(event) {
            //     event.preventDefault();
            //     var formData = $(this).serialize();
            //     $.ajax({
            //         url: $(this).attr('action'),
            //         type: 'POST',
            //         data: formData,
            //         success: function(response) {
            //             // Assuming response is an array of Gann dates corresponding to degrees
            //             response.forEach(function(item, index) {
            //                 var degree = (index + 1) *
            //                 30; // Calculate degree dynamically
            //                 $('.gann_date_dates input').eq(index).val(
            //                 item); // Populate corresponding input field
            //             });
            //         },
            //         error: function(xhr, status, error) {
            //             console.error('Error:', error);
            //             // Handle error if needed
            //         }
            //     });
            // });

            $('#calculateBtn').click(function(event) {
                event.preventDefault();

                // Retrieve the start date input value
                var startDate = $('#date').val();

                // Validate the start date format (optional, since datepicker enforces format)
                // Example: You can check if startDate matches 'dd-mm-yyyy' format

                // Calculate Gann dates based on the input date
                var start = moment(startDate, 'DD-MM-YYYY'); // Use moment.js for date manipulation

                if (start.isValid()) {
                    // Array of days for each degree
                    var days = [
                        30, 15, 15, 13, 18, 30, 15, 16, 30, 30,
                        16, 15, 12, 18, 19, 12, 15, 15, 31
                    ];

                    var response = [];

                    // Calculate each Gann date based on days array
                    days.forEach(function(daysCount, index) {
                        var nextDate = start.add(daysCount, 'days').format('DD/MM/YYYY');
                        response.push(nextDate);

                        // Assuming each degree input has a unique ID or class, update them here
                        // Example: $('#degree-30').val(nextDate);
                        // Replace '#degree-30' with your actual selector
                        $('.gann_date_dates input').eq(index).val(nextDate);
                    });

                    // Optionally, you can do something after all calculations are done
                    console.log('Gann dates calculated:', response);
                } else {
                    console.error('Invalid start date format or date.');
                    // Handle invalid date format or date here
                }
            });
        });
    </script>

@endsection
