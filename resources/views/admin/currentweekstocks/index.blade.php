@extends('admin.layouts.admin-layout')

@section('title', 'Current Week Data')

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
                        <li class="breadcrumb-item active">Current Week Data</li>
                    </ol>
                </nav>
            </div>

        </div>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="row">

            <div class="col-md-6">
                <div class="card bg-success">
                    <div class="card_body">
                        <div class="table-responsive custom_dt_table mt-4">
                            <div class="form_box">
                                <div class="form_box_inr">
                                    <div class="box_title">
                                        <h2>Current Week Buy Stocks</h2>
                                    </div>
                                    <div class="form_box_info">
                                        <div class="table-responsive">
                                            <table class="table w-100 dataTable no-footer" id="GannDataTable"
                                                aria-describedby="UsersTable_info" style="width: 948px;">
                                                <thead>
                                                    @php
                                                        $startOfWeek = \Carbon\Carbon::now()->startOfWeek();
                                                        $endOfWeek = \Carbon\Carbon::now()->endOfWeek();
                                                    @endphp
                                                    <tr>
                                                        <th class="text-center text-white">Stock Name</th>
                                                        <th class="text-center text-white">Current Week Stocks</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if ($currentWeekBuyData->isNotEmpty())
                                                        @foreach ($currentWeekBuyData as $data)
                                                            @php
                                                                try {
                                                                    $d_90 = $data->d_90;
                                                                } catch (\Throwable $th) {
                                                                    $d_90 = null;
                                                                }

                                                            @endphp
                                                            @if ($d_90)
                                                                <tr onclick="window.location='{{ route('gannStokes.currentstock', ['id' => encrypt($data->id)]) }}';" style="cursor: pointer;">
                                                                    <td class="text-center text-white">{{ $data->stokes }}
                                                                    </td>
                                                                    <td class="text-center text-white">
                                                                        {{ $d_90 }}</td>
                                                                   
                                                                </tr>
                                                            
                                                            @endif
                                                        @endforeach
                                                    @else
                                                        <tr>
                                                            <td class="text-center text-white" colspan="2">No data
                                                                Found
                                                            </td>
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
            <div class="col-md-6">
                <div class="card bg-danger text-white">
                    <div class="card_body">
                        <div class="table-responsive custom_dt_table mt-4">
                            <div class="form_box">
                                <div class="form_box_inr">
                                    <div class="box_title">
                                        <h2>Current Week Sell Stocks</h2>
                                    </div>
                                    <div class="form_box_info">
                                        <div class="table-responsive">
                                            <table class="table w-100 dataTable no-footer" id="GannDataTable"
                                                aria-describedby="UsersTable_info" style="width: 948px;">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center text-white">Stock Name</th>
                                                        <th class="text-center text-white">Current Week Stocks</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if ($currentWeekSellData->isNotEmpty())
                                                        @foreach ($currentWeekSellData as $data)
                                                            @php
                                                                try {
                                                                  
                                                                    $d_45 = $data->d_45;
                                                                    
                                                                } catch (\Throwable $th) {
                                                                    $d_45 = null;
                                                                }

                                                            @endphp
                                                            @if ($d_45)
                                                                <tr onclick="window.location='{{ route('gannStokes.currentstock', ['id' => encrypt($data->id)]) }}';" style="cursor: pointer;">
                                                                    
                                                                    <td class="text-center text-white">{{ $data->stokes }}
                                                                    </td>
                                                               
                                                                <a href="{{ route('gannStokes.currentstock', ['id' => encrypt($data->id)]) }}">
                                                                    <td class="text-center text-white">
                                                                        {{ $d_45 }}</td>
                                                                    </a>

                                                                </tr>
                                                           
                                                            @endif
                                                        @endforeach
                                                    @else
                                                        <tr>
                                                            <td class="text-center text-white" colspan="2">No data
                                                                Found
                                                            </td>
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
        </div>
    </section>

@endsection

{{-- Custom Script --}}
@section('page-js')


@endsection
