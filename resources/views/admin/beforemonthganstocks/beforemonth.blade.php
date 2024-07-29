@extends('admin.layouts.admin-layout')

@section('title', 'Before 1 month GanStocks')

@section('content')

    <div class="pagetitle">
        <h1>Before 1 month GanStocks</h1>
        <div class="row">
            <div class="col-md_8">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active"> <a
                                href="{{ route('dashboard') }}">{{ trans('label.Dashboard') }}</a>
                        </li>
                        <li class="breadcrumb-item active">Before 1 month GanStocks</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="row">

            {{-- Buy --}}
            <div class="col-md-6">
                <div class="card">
                    <div class="card_body">
                        <div class="table-responsive custom_dt_table mt-4">
                            <div class="form_box">
                                <div class="form_box_inr">
                                    <div class="box_title">
                                        <h2>Before 1 month Buy GanStocks</h2>
                                    </div>
                                    <div class="form_box_info">
                                        <div class="table-responsive">
                                            <table class="table w-100 dataTable no-footer" id="beforebuyGannDataTable"
                                                aria-describedby="UsersTable_info" style="width: 948px;">
                                                <thead>
                                                    <tr>
                                                        <th>Stock Name</th>
                                                        <th>Buy Stocks</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if($GannBuyData->isNotEmpty())
                                                    @foreach ($GannBuyData as $buy)
                                                    <tr>
                                                        <td>{{ $buy->stokes }}</td>
                                                        <td>{{ $buy->d_90 }}</td>
                                                    </tr>
                                                    @endforeach  
                                                    @else
                                                    <tr>
                                                        <td>No Data Found</td>
                                                    </tr>
                                                    @endif
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

            {{-- Sell --}}
            <div class="col-md-6">
                <div class="card">
                    <div class="card_body">
                        <div class="table-responsive custom_dt_table mt-4">
                            <div class="form_box">
                                <div class="form_box_inr">
                                    <div class="box_title">
                                        <h2>Before 1 month Sell GanStocks</h2>
                                    </div>
                                    <div class="form_box_info">
                                        <div class="table-responsive">
                                            <table class="table w-100 dataTable no-footer" id="beforesellGannDataTable"
                                                aria-describedby="UsersTable_info" style="width: 948px;">
                                                <thead>
                                                    <tr>
                                                        <th>Stock Name</th>
                                                        <th>Sell Stocks</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if($GannSellData->isNotEmpty())
                                                    @foreach ($GannSellData as $sell)
                                                    <tr>                 
                                                        <td>{{ $sell->stokes }}</td>
                                                        <td>{{ $sell->d_45 }}</td>
                                                        
                                                    </tr>
                                                    @endforeach          
                                                    @else
                                                    <tr>
                                                        <th>No Data Found</th>         
                                                    </tr>
                                                    @endif
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

    {{-- <script type="text/javascript">
        $(document).ready(function() {

            var table = $('#beforebuyGannDataTable').DataTable({
                processing: true,
                serverSide: true,
                pageLength: 100,
                ajax: "{{ route('gannStokes.beforemotnh') }}",
                columns: [{
                        data: 'id',
                        name: 'id',
                    },
                    {
                        data: 'stokes',
                        name: 'stokes',
                    },
                    {
                        data: 'd_90',
                        name: 'd_90',
                    },
                ]
            });

            var table = $('#beforesellGannDataTable').DataTable({
                processing: true,
                serverSide: true,
                pageLength: 100,
                ajax: "{{ route('gannStokes.beforemotnh') }}",
                columns: [{
                        data: 'id',
                        name: 'id',
                    },
                    {
                        data: 'stokes',
                        name: 'stokes',
                    },
                    {
                        data: 'd_45',
                        name: 'd_45',
                    },
                ]
            });

        });
    </script> --}}
@endsection
