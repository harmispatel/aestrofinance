@extends('admin.layouts.admin-layout')

@section('title', 'Bhadra Data')

@section('content')

    <div class="pagetitle">
        <h1>Bhadra Data</h1>
        <div class="row">
            <div class="col-md_8">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active"> <a
                                href="{{ route('dashboard') }}">{{ trans('label.Dashboard') }}</a>
                        </li>
                        <li class="breadcrumb-item active">Bhadra Data</li>
                    </ol>
                </nav>
            </div>
           
        </div>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="row">

            {{-- Clients Card --}}
            <div class="col-md_12">
                <div class="card">
                    <div class="card_body">
                        <div class="table-responsive custom_dt_table mt-4">
                            <div class="form_box">
                                <div class="form_box_inr">
                                    <div class="box_title">
                                        <h2>Bhadra Data</h2>
                                    </div>
                                    <div class="form_box_info">
                                        <div class="table-responsive">
                                            <table class="table w-100 dataTable no-footer" id="BhadraDataTable"
                                                aria-describedby="UsersTable_info" style="width: 948px;">
                                                <thead>
                                                    <tr>
                                                        <th>{{ trans('label.Id') }}</th>
                                                        <th>Start Date & Time</th>
                                                        <th>End Date & Time</th>
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
    </section>

@endsection

{{-- Custom Script --}}
@section('page-js')

    <script type="text/javascript">
       
       $(document).ready(function() {

            var table = $('#BhadraDataTable').DataTable({
                processing: true,
                serverSide: true,
                pageLength: 100,
                ajax: "{{ route('bhadra.index') }}",
                columns: [{
                        data: 'id',
                        name: 'id',
                    },
                    {
                        data: 'start_date_time',
                        name: 'start_date_time',
                    },
                    {
                        data: 'end_date_time',
                        name: 'end_date_time',
                    },
                    {
                        data: 'actions',
                        name: 'actions',
                        'searchable': false,
                        'orderable': false,
                    },

                ]
            });

        });

        // Function for Delete Table
        function deleteUsers(bhadraId) {
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
                            url: '{{ route('bhadra.delete') }}',
                            data: {
                                "_token": "{{ csrf_token() }}",
                                'id': bhadraId,
                            },
                            dataType: 'JSON',
                            success: function(response) {
                                console.log(response);
                                if (response.success == 1) {
                                    //    toastr.success(response.message);
                                    swal(response.message, "", "success");
                                    $('#BhadraDataTable').DataTable().ajax.reload();
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
