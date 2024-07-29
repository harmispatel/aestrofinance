@extends('admin.layouts.admin-layout')

@section('title', 'Night GrahWiseData')

@section('content')

    <div class="pagetitle">
        <h1>Night GrahWiseData</h1>
        <div class="row">
            <div class="col-md-8">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active"> <a
                                href="{{ route('dashboard') }}">{{ trans('label.Dashboard') }}</a>
                        </li>
                        <li class="breadcrumb-item active">Night GrahWiseData</li>
                    </ol>
                </nav>
            </div>
            <div class="col-md-4" style="text-align: right;">
                <a href="{{ route('nightgrahsdata.create') }}" class="btn btn-sm new-category custom-btn">
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
                            <div class="col-md-4">
                                <label for="serachGrahName"><strong>* Search Grah Name</strong></label>
                                <select name="grahname" class="form-control mt-2" id="grahname_filter">
                                    <option value="">-- Select GrahName --</option>
                                    @foreach ($grahs as $grah)
                                        <option value="{{ $grah->id }}">{{ $grah->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="serachGrahName"><strong>* Search Date</strong></label>
                                <input type="text" name="daterange" id="daterange" class="form-control mt-2" />
                            </div>
                            <div class="col-md-2">
                                <label for="searchStartTime"><strong>* Start Time</strong></label>
                                <input type="time" name="start_time" id="start_time" class="form-control mt-2" />
                            </div>
                            <div class="col-md-2">
                                <label for="searchEndTime"><strong>* End Time</strong></label>
                                <input type="time" name="end_time" id="end_time" class="form-control mt-2" />
                            </div>
                        </div>
                        <div class="table-responsive custom_dt_table mt-4">
                            <div class="form_box">
                                <div class="form_box_inr">
                                    <div class="box_title">
                                        <h2>Night GrahWiseData</h2>
                                    </div>
                                    <div class="form_box_info">
                                        <div class="table-responsive">
                                            <table class="table w-100 dataTable no-footer" id="nightGrahWiseDataTable"
                                                aria-describedby="UsersTable_info" style="width: 948px;">
                                                <thead>
                                                    <tr>
                                                        <th>{{ trans('label.Id') }}</th>
                                                        <th>{{ trans('label.Date') }}</th>
                                                        <th>{{ trans('label.Grah Name') }}</th>
                                                        <th>{{ trans('label.Start Time') }}</th>
                                                        <th>{{ trans('label.End Time') }}</th>
                                                        <th>{{ trans('label.Actions') }}</th>
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
    </section>

@endsection

{{-- Custom Script --}}
@section('page-js')

    <script type="text/javascript">
       
       $(document).ready(function() {

            $('#daterange').daterangepicker({
                opens: 'left',
                autoUpdateInput: false,
                locale: {
                    format: 'DD-MM-YYYY',
                    cancelLabel: 'Clear'
                }
            });

            $('#daterange').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('DD-MM-YYYY') + ' - ' + picker.endDate.format('DD-MM-YYYY'));
                table.draw();
            });

            $('#daterange').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
                table.draw();
            });

            var table = $('#nightGrahWiseDataTable').DataTable({
                processing: true,
                serverSide: true,
                pageLength: 100,
                ajax: {
                    url: "{{ route('nightgrahsdata.index') }}",
                    data: function(d) {
                        d.grahname_filter = $('#grahname_filter').val();
                        d.start_date = $('#daterange').val() ? $('#daterange').data('daterangepicker').startDate.format('DD-MM-YYYY') : '';
                        d.end_date = $('#daterange').val() ? $('#daterange').data('daterangepicker').endDate.format('DD-MM-YYYY') : '';
                        d.start_time = $('#start_time').val(); // Add start_time filter
                        d.end_time = $('#end_time').val();
                    }
                },
                columns: [{
                        data: 'id',
                        name: 'id',
                    },
                    {
                        data: 'date',
                        name: 'date',
                    },
                    {
                        data: 'grah_id',
                        name: 'grah_id',
                    },
                    {
                        data: 'start_time',
                        name: 'start_time',
                    },
                    {
                        data: 'end_time',
                        name: 'end_time',
                    },
                    {
                        data: 'actions',
                        name: 'actions',
                        'searchable': false,
                        'orderable': false,
                    },

                ]
            });

            $('#daterange').on('apply.daterangepicker', function(ev, picker) {
              table.ajax.reload();
            });

            $('#start_time, #end_time').change(function() {
              table.draw();
            });

            $('#grahname_filter').change(function() {
                table.draw();
            });
        });

        // Function for Delete Table
        function deleteUsers(grahId) {
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
                            url: '{{ route('nightgrahdata.destroy') }}',
                            data: {
                                "_token": "{{ csrf_token() }}",
                                'grahsdata': grahId,
                            },
                            dataType: 'JSON',
                            success: function(response) {
                                console.log(response);
                                if (response.success == 1) {
                                    //    toastr.success(response.message);
                                    swal(response.message, "", "success");
                                    $('#nightGrahWiseDataTable').DataTable().ajax.reload();
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
