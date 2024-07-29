@extends('admin.layouts.admin-layout')

@section('title', 'Current Level')

@section('content')

    <div class="pagetitle">
        <h1>Current Level</h1>
        <div class="row">
            <div class="col-md_8">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active"> <a
                                href="{{ route('dashboard') }}">{{ trans('label.Dashboard') }}</a>
                        </li>
                        <li class="breadcrumb-item active">Nifty Price</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="row">

            {{-- Buy --}}
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-2 text-center mt-2">
                                <div class="form-group">
                                    <label for="serachGrahName"><strong>Select Stock : </strong></label>
                                </div>
                            </div>
                            <div class="col-md-4 text-center mb-3">
                                <div class="form-group">
                                    <select class="form-control" name="stock" id="Stokes">
                                        <option value="">-- Select Stock --</option>
                                        @foreach ($stocks as $stock)
                                            <option value="{{ $stock->stock }}">{{ $stock->stock }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive custom_dt_table mt-4">
                            <div class="form_box">
                                <div class="form_box_inr">
                                    <div class="box_title">
                                        <h2>Current Level</h2>
                                    </div>
                                    <div class="form_box_info">
                                        <div class="table-responsive">
                                            <table class="table w-100 dataTable no-footer" id="niftyCurrentTable"
                                                aria-describedby="UsersTable_info" style="width: 948px;">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">Date</th>
                                                        <th class="text-center">Grah Name</th>
                                                        <th class="text-center">Deg Absolute</th>
                                                        <th class="text-center">Nifty Price</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </section>

@endsection

{{-- Custom Script --}}
@section('page-js')

    <script type="text/javascript">
        $(document).ready(function() {
            $('#Stokes').change(function() {
                var selected = $(this).val();

                $.ajax({
                    type: 'POST',
                    url: '{{ route('currentNiftyStockWise') }}',
                    data: {
                        stock: selected,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        var tbody = $('#niftyCurrentTable tbody');
                        tbody.empty(); // Clear previous data

                        if (response.stockdata && Array.isArray(response.stockdata) && response
                            .stockdata.length) {
                            response.stockdata.forEach(function(item) {
                                var rowClass = '';

                                var itemPrefix = item.grah_name.substring(0, 3); // First 3 characters of grah_name

                                // Check if the grah_name prefix exists in the grah_names array
                                if (response.grah_names.some(function(grah_name) {
                                    return grah_name.substring(0, 3) === itemPrefix;
                                })) {
                                    rowClass = 'table-success'; // Change to the class you want to use for green
                                }

                                var row = '<tr class="data-row ' + rowClass + '">' +
                                    '<td class="text-center date">' + item.date +
                                    '</td>' +
                                    '<td class="text-center grahname">' + item
                                    .grah_name + '</td>' +
                                    '<td class="text-center deg_absolute">' + item
                                    .deg_absolute + '</td>' +
                                    '<td class="text-center nifty_price">' + item
                                    .nifty_price + '</td>' +
                                    '</tr>';
                                tbody.append(row);
                            });
                        } else {
                            // Show message if no data is returned
                            tbody.append(
                                '<tr><td colspan="4" class="text-center">No data available</td></tr>'
                            );
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText); // Log any errors for debugging
                    }
                });
            });
        });
    </script>
@endsection
