@extends('admin.layouts.admin-layout')

@section('title', 'Gann Stokes')

@section('content')

    <div class="pagetitle">
        <h1>Gann Stokes</h1>
        <div class="row">
            <div class="col-md_8">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active"> <a
                                href="{{ route('dashboard') }}">{{ trans('label.Dashboard') }}</a>
                        </li>
                        <li class="breadcrumb-item active">Gann Stokes</li>
                    </ol>
                </nav>
            </div>
            <div class="col-md_4" style="text-align: right;">
                <a href="{{ route('gannStokes.create') }}" class="btn btn-sm new-category custom-btn">
                    <i class="bi bi-plus-lg"></i>
                </a>
            </div>
        </div>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="row">

            {{-- Clients Card --}}
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <label for="daterange_45"><strong>* Search Date 45 Degree</strong></label>
                                <input type="text" name="daterange_45" id="daterange_45" class="form-control mt-2" />
                            </div>
                            <div class="col-md-3">
                                <label for="daterange_90"><strong>* Search Date 90 Degree</strong></label>
                                <input type="text" name="daterange_90" id="daterange_90" class="form-control mt-2" />
                            </div>
                            <div class="col-md-3">
                                <label for="daterange_135"><strong>* Search Date 135 Degree</strong></label>
                                <input type="text" name="daterange_135" id="daterange_135" class="form-control mt-2" />
                            </div>
                            <div class="col-md-3">
                                <label for="daterange_180"><strong>* Search Date 180 Degree</strong></label>
                                <input type="text" name="daterange_180" id="daterange_180" class="form-control mt-2" />
                            </div>
                        </div>
                        <div class="table-responsive custom_dt_table mt-4">
                            <div class="form_box">
                                <div class="form_box_inr">
                                    <div class="box_title">
                                        <h2>Gann Stokes</h2>
                                    </div>
                                    <div class="form_box_info">
                                        <div class="table-responsive">
                                            <table class="table w-100 dataTable no-footer" id="GannDataTable"
                                                aria-describedby="UsersTable_info" style="width: 948px;">
                                                <thead>
                                                    <tr>
                                                        <th>{{ trans('label.Id') }}</th>
                                                        <th>Stokes</th>
                                                        <th data-angle="45">45 Degree</th>
                                                        <th data-angle="90">90 Degree</th>
                                                        <th data-angle="135">135 Degree</th>
                                                        <th data-angle="180">180 Degree</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody></tbody>
                                            </table>
                                        </div>
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

            function setupDateRangePicker(selector) {
                $(selector).daterangepicker({
                    opens: 'left',
                    autoUpdateInput: false,
                    locale: {
                        format: 'DD-MM-YYYY',
                        cancelLabel: 'Clear'
                    }
                });

                $(selector).on('apply.daterangepicker', function(ev, picker) {
                    $(this).val(picker.startDate.format('DD-MM-YYYY') + ' - ' + picker.endDate.format('DD-MM-YYYY'));
                    table.draw();
                });

                $(selector).on('cancel.daterangepicker', function(ev, picker) {
                    $(this).val('');
                    table.draw();
                });
            }

              // Initialize date range pickers
                setupDateRangePicker('#daterange_45');
                setupDateRangePicker('#daterange_90');
                setupDateRangePicker('#daterange_135');
                setupDateRangePicker('#daterange_180');

            var table = $('#GannDataTable').DataTable({
                processing: true,
                serverSide: true,
                pageLength: 100,
                ajax: {
                    url: "{{ route('gannStokes.index') }}",
                    data: function(d) {
                        d.start_date_45 = $('#daterange_45').val() ? $('#daterange_45').data('daterangepicker').startDate.format('DD-MM-YYYY') : '';
                        d.end_date_45 = $('#daterange_45').val() ? $('#daterange_45').data('daterangepicker').endDate.format('DD-MM-YYYY') : '';
                        
                        d.start_date_90 = $('#daterange_90').val() ? $('#daterange_90').data('daterangepicker').startDate.format('DD-MM-YYYY') : '';
                        d.end_date_90 = $('#daterange_90').val() ? $('#daterange_90').data('daterangepicker').endDate.format('DD-MM-YYYY') : '';
                        
                        d.start_date_135 = $('#daterange_135').val() ? $('#daterange_135').data('daterangepicker').startDate.format('DD-MM-YYYY') : '';
                        d.end_date_135 = $('#daterange_135').val() ? $('#daterange_135').data('daterangepicker').endDate.format('DD-MM-YYYY') : '';
                        
                        d.start_date_180 = $('#daterange_180').val() ? $('#daterange_180').data('daterangepicker').startDate.format('DD-MM-YYYY') : '';
                        d.end_date_180 = $('#daterange_180').val() ? $('#daterange_180').data('daterangepicker').endDate.format('DD-MM-YYYY') : '';
                    }
                },
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'stokes',
                        name: 'stokes'
                    },
                    {
                        data: 'd_45',
                        name: 'd_45'
                    },
                    {
                        data: 'd_90',
                        name: 'd_90'
                    },
                    {
                        data: 'd_135',
                        name: 'd_135'
                    },
                    {
                        data: 'd_180',
                        name: 'd_180'
                    },
                    {
                        data: 'actions',
                        name: 'actions',
                        'searchable': false,
                        'orderable': false
                    }
                ]
               
            });

            $('#daterange_45, #daterange_90, #daterange_135, #daterange_180').on('apply.daterangepicker', function(ev, picker) {
                table.ajax.reload();
            });

            function showTooltip(rowData, angleData, element) {
                // Remove any existing tooltip boxes
                $('#dataTooltip').remove();

                // Create the tooltip box
                var tooltipBox = `
            <div id="dataTooltip" style="display: none; position: absolute; background: #fff; border: 1px solid #ccc; padding: 10px; z-index: 1000;">
                <p>Price Low: <span id="priceLow">${angleData.low || 'N/A'}</span></p>
                <p>Price High: <span id="priceHigh">${angleData.high || 'N/A'}</span></p>
                <p>Close: <span id="closePrice">${angleData.close || 'N/A'}</span></p>
            </div>
            `;

                // Append the tooltip box to the body
                $('body').append(tooltipBox);

                // Position the tooltip box next to the cell
                var offset = $(element).offset();
                $('#dataTooltip').css({
                    top: offset.top + $(element).height() + 5,
                    left: offset.left
                }).fadeIn(200);
            }

            // Event delegation to handle cell mouseenter
            $('#GannDataTable tbody').on('mouseenter', 'td', function() {
                var cellIndex = table.cell(this).index().column;
                var rowData = table.row(this).data();
                var columnName = table.column(cellIndex).dataSrc();

                var angleData = {};

                switch (columnName) {
                    case 'd_45':
                        angleData = {
                            low: rowData.price_low_45,
                            high: rowData.price_high_45,
                            close: rowData.close_45
                        };
                        break;
                    case 'd_90':
                        angleData = {
                            low: rowData.price_low_90,
                            high: rowData.price_high_90,
                            close: rowData.close_90
                        };
                        break;
                    case 'd_135':
                        angleData = {
                            low: rowData.price_low_135,
                            high: rowData.price_high_135,
                            close: rowData.close_135
                        };
                        break;
                    case 'd_180':
                        angleData = {
                            low: rowData.price_low_180,
                            high: rowData.price_high_180,
                            close: rowData.close_180
                        };
                        break;
                    default:
                        $('.tooltip-row').remove();
                        return; // Exit if the hovered cell is not one of the degree columns
                }

                showTooltip(rowData, angleData, this);
            });

            // Hide tooltip on mouse leave
            $('#GannDataTable tbody').on('mouseleave', 'td', function() {
                $('.tooltip-row').remove();
            });
        });


        // Function for Delete Table
        function deleteUsers(gannstockId) {
            swal({
                    title: "Are you sure You want to Delete It ?",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDeleteUsers) => {
                    if (willDeleteUsers) {
                        $.ajax({
                            type: "POST",
                            url: '{{ route('gannStocks.delete') }}',
                            data: {
                                "_token": "{{ csrf_token() }}",
                                'id': gannstockId,
                            },
                            dataType: 'JSON',
                            success: function(response) {
                                console.log(response);
                                if (response.success == 1) {
                                    //    toastr.success(response.message);
                                    swal(response.message, "", "success");
                                    $('#GannDataTable').DataTable().ajax.reload();
                                } else {
                                    swal(response.message, "", "error");
                                }
                            }
                        });
                    } else {
                        swal("Cancelled", "", "error");
                    }
                });
        }
    </script>
@endsection
