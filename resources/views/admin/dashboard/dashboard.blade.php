@extends('admin.layouts.admin-layout')

@section('title', 'D A S H B O A R D')

@section('content')

    <div class="pagetitle">
        <h1>Dashboard</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="row">
            @if (session()->has('errors'))
                <div class="col-md-12">
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('errors') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            @endif

            <div class="col-md-5">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive custom_dt_table">
                            <div class="form_box">
                                <div class="form_box_inr">
                                    <div class="box_title">
                                        <h2>Important Time</h2>
                                    </div>
                                    <div class="form_box_info">
                                        <div class="table-responsive">
                                            <table class="table w-100 dataTable no-footer" id="GannDataTable">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">Date</th>
                                                        <th class="text-center">Grah Name</th>
                                                        <th class="text-center">Time</th>
                                                        <th class="text-center">Trade Time</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if ($importantGrahs->isNotEmpty())
                                                        @php
                                                            $all_end_times = [];

                                                            // Collect all end_time values and convert to sortable format
                                                            foreach ($importantGrahs as $important) {
                                                                $grahwisedatas = $important->grahWiseData;

                                                                foreach ($grahwisedatas as $grahwise) {
                                                                    // Convert end_time to sortable format (24-hour time)

                                                                    $carbonTime = \Carbon\Carbon::parse(
                                                                        $grahwise->end_time,
                                                                    );
                                                                    $sortableEndTime = $carbonTime->format('H:i'); // 24-hour format
                                                                    $all_end_times[] = [
                                                                        'original' => $grahwise->end_time,
                                                                        'sortable' => $sortableEndTime,
                                                                        'important' => $important,
                                                                        'grahwise' => $grahwise,
                                                                    ];
                                                                }
                                                            }

                                                            // Sort the array based on sortable end_time
                                                            usort($all_end_times, function ($a, $b) {
                                                                return strcmp($a['sortable'], $b['sortable']);
                                                            });

                                                            // Collect grah names by id for easy lookup
                                                            $grahNamesById = $grahs->pluck('name', 'id');
                                                        @endphp

                                                        @foreach ($all_end_times as $time)
                                                            @php
                                                                $endTime = \Carbon\Carbon::parse(
                                                                    $time['original'],
                                                                )->subMinutes(15);
                                                                $diff = \Carbon\Carbon::parse(
                                                                    $time['original'],
                                                                )->diffInMinutes(\Carbon\Carbon::now());
                                                                $class = 'color-' . (($diff % 10) + 1); // Cycle through 10 colors based on minute difference

                                                                $important = $time['important'];
                                                                $grahwise = $time['grahwise'];
                                                                $grahname =
                                                                    $grahNamesById[$grahwise->grah_id] ?? 'Unknown';
                                                            @endphp

                                                            <tr>
                                                                <td class="text-center">{{ $important->date }}</td>
                                                                <td class="text-center">{{ $grahname }}</td>
                                                                <td class="text-center">{{ $time['original'] }}</td>
                                                                <td class="text-center important-time {{ $class }}">
                                                                    {{ $endTime->format('h:i A') }}</td>
                                                            </tr>
                                                        @endforeach
                                                    @else
                                                        <tr>
                                                            <td class="text-center" colspan="3">No Data Found</td>
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

                <!-- Bhadra Time Section -->

                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive custom_dt_table">
                            <div class="form_box">
                                <div class="form_box_inr">
                                    <div class="box_title">
                                        <h2>Bhadra Time</h2>
                                    </div>
                                    <div class="form_box_info">
                                        <div class="table-responsive">
                                            <table class="table w-100 dataTable no-footer" id="GannDataTable">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">Start Date & Time</th>
                                                        <th class="text-center">End Date & Time</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        @if ($bhdraStartTime !== '')
                                                                @php
                                                                    $diff = \Carbon\Carbon::parse(
                                                                        $bhdraStartTime->start_date_time,
                                                                    )->diffInMinutes(\Carbon\Carbon::now());
                                                                    $class = 'color-' . (($diff % 10) + 1); // Cycle through 10 colors based on minute difference

                                                                    $startDateTime = Carbon\Carbon::parse(
                                                                        $bhdraStartTime->start_date_time,
                                                                    );
                                                                @endphp

                                                                <td
                                                                    class="text-center bhdrastart-end-time {{ $class }}" style="font-size: 14px;">
                                                                    {{ $startDateTime->format('d-m-Y h:i A') }}</td>

                                                        @else
                                                            <td class="text-center">--</td>

                                                        @endif
                                                        @if ($bhdraEndTime !== '')
                                                            @php
                                                                $diff = \Carbon\Carbon::parse(
                                                                    $bhdraEndTime->end_date_time,
                                                                )->diffInMinutes(\Carbon\Carbon::now());
                                                                $class = 'color-' . (($diff % 10) + 1); // Cycle through 10 colors based on minute difference

                                                                $endDateTime = Carbon\Carbon::parse(
                                                                    $bhdraEndTime->end_date_time,
                                                                );
                                                            @endphp
                                                            <td class="text-center bhdraend-end-time {{ $class }}" style="font-size: 14px;">
                                                                {{ $endDateTime->format('d-m-Y h:i A') }}</td>
                                                        @else
                                                            <td class="text-center">--</td>
                                                        @endif
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- trayodashi Start Time Section -->

                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive custom_dt_table">
                            <div class="form_box">
                                <div class="form_box_inr">
                                    <div class="box_title">
                                        <h2>Trayodashi Time</h2>
                                    </div>
                                    <div class="form_box_info">
                                        <div class="table-responsive">
                                            <table class="table w-100 dataTable no-footer" id="GannDataTable">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">Start Date & Time</th>
                                                        <th class="text-center">End Date & Time</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        @if ($trayodashiStartTime !== '')

                                                                @php
                                                                    $diff = \Carbon\Carbon::parse(
                                                                        $trayodashiStartTime->start_date_time,
                                                                    )->diffInMinutes(\Carbon\Carbon::now());
                                                                    $class = 'color-' . (($diff % 10) + 1); // Cycle through 10 colors based on minute difference

                                                                    $startDateTime = Carbon\Carbon::parse(
                                                                        $trayodashiStartTime->start_date_time,
                                                                    );
                                                                @endphp

                                                                <td
                                                                    class="text-center trayodashiStart-end-time {{ $class }}" style="font-size: 14px;">
                                                                    {{ $startDateTime->format('d-m-Y h:i A') }}</td>

                                                        @else
                                                            <td class="text-center">--</td>

                                                        @endif
                                                        @if ($trayodashiEndTime !== '')

                                                                @php
                                                                    $diff = \Carbon\Carbon::parse(
                                                                        $trayodashiEndTime->end_date_time,
                                                                    )->diffInMinutes(\Carbon\Carbon::now());
                                                                    $class = 'color-' . (($diff % 10) + 1); // Cycle through 10 colors based on minute difference

                                                                    $endDateTime = Carbon\Carbon::parse(
                                                                        $trayodashiEndTime->end_date_time,
                                                                    );

                                                                @endphp

                                                                <td
                                                                    class="text-center trayodashiEnd-end-time {{ $class }}" style="font-size: 14px;">
                                                                    {{ $endDateTime->format('d-m-Y h:i A') }}</td>

                                                        @else
                                                            <td class="text-center">--</td>
                                                        @endif
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- amavasya Start Time Section -->

                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive custom_dt_table">
                            <div class="form_box">
                                <div class="form_box_inr">
                                    <div class="box_title">
                                        <h2>Amavasya Time</h2>
                                    </div>
                                    <div class="form_box_info">
                                        <div class="table-responsive">
                                            <table class="table w-100 dataTable no-footer" id="GannDataTable">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">Start Date & Time</th>
                                                        <th class="text-center">End Date & Time</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        
                                                        @if ($amavasyaStartTime !== '')

                                                                @php
                                                                    $diff = \Carbon\Carbon::parse(
                                                                        $amavasyaStartTime->start_time,
                                                                    )->diffInMinutes(\Carbon\Carbon::now());
                                                                    $class = 'color-' . (($diff % 10) + 1); // Cycle through 10 colors based on minute difference

                                                                    $startDateTime = Carbon\Carbon::parse(
                                                                        $amavasyaStartTime->start_time,
                                                                    );
                                                                @endphp

                                                                <td
                                                                    class="text-center amavasyaStartTime-end-time {{ $class }}" style="font-size: 14px;">
                                                                    {{ $startDateTime->format('d-m-Y h:i A') }}</td>

                                                        @else
                                                            <td class="text-center">--</td>

                                                        @endif
                                                        @if ($amavasyaEndTime !== '')

                                                                @php
                                                                    $diff = \Carbon\Carbon::parse(
                                                                        $amavasyaEndTime->end_time,
                                                                    )->diffInMinutes(\Carbon\Carbon::now());
                                                                    $class = 'color-' . (($diff % 10) + 1); // Cycle through 10 colors based on minute difference

                                                                    $endDateTime = Carbon\Carbon::parse(
                                                                        $amavasyaEndTime->end_time,
                                                                    );

                                                                @endphp

                                                                <td
                                                                    class="text-center amavasyaEnd-end-time {{ $class }}" style="font-size: 14px;">
                                                                    {{ $endDateTime->format('d-m-Y h:i A') }}</td>

                                                        @else
                                                            <td class="text-center">--</td>
                                                        @endif
                                                    </tr>
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

            <div class="col-md-7">
                <div class="card">
                    <div class="card-body">
                        <form id="niftyForm">
                            <div class="row align-items-center mb-3">
                                <div class="col-md-4 text-center mb-3">
                                    <div class="form-group">
                                        <label for="serachGrahName"><strong>Select Stock : </strong></label>
                                    </div>
                                </div>
                                <div class="col-md-4 text-center mb-3">
                                    <div class="form-group">
                                        <select class="form-control" name="stock" id="Stokes">
                                            <option value="">-- Select Stock --</option>
                                            <option value="NIFTY">NIFTY</option>
                                            <option value="BANKNIFTY">BANKNIFTY</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4 text-center mb-3">
                                    <div class="form-group">
                                        <input class="form-control" name="stock" id="Stokes2"></input>
                                    </div>
                                </div>
                                <div class="col-md-5 text-center">
                                    <div class="form-group">
                                        <label for="serachGrahName" style="font-size: 15px"><strong>Enter Current Nifty
                                                Price : </strong></label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <input name="currentinput" class="form-control" id="currentinput">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary" id="submit">submit</button>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <button class="btn bg-success" id="save">Save</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="table-responsive custom_dt_table">
                            <div class="form_box">
                                <div class="form_box_inr">
                                    <div class="box_title">
                                        <div class="row">
                                        <div class="col-md-4 text-center mt-3 text-white">
                                            <div class="form-group">
                                                <label for="serachGrahName"><strong>Current Level : </strong></label>
                                            </div>
                                        </div>
                                        <div class="col-md-5 text-center mt-2">
                                            <div class="form-group">
                                                <select class="form-control" name="stock" id="stockwiseData">
                                                    <option value="">-- Select Stock --</option>
                                                    @foreach ($stocks as $stock)
                                                        <option value="{{ $stock->stock }}">{{ $stock->stock }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    </div>
                                    <div class="form_box_info">
                                        <div class="table-responsive">
                                            <table class="table w-100 dataTable no-footer" id="niftyCurrentTable">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">Stock</th>
                                                        <th class="text-center">Grah Name</th>
                                                        <th class="text-center">Deg absolute</th>
                                                        <th class="text-center">NiftyPrice</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if ($currentNifty->isNotEmpty())
                                                        @foreach ($currentNifty as $value)
                                                            @php
                                                                $date = \Carbon\Carbon::parse($value->date);
                                                                $dateformat = $date->format('d-m-Y');
                                                            @endphp

                                                            <tr
                                                                class="data-row @foreach ($grahnames as $grahname){{ substr($value->grah_name, 0, 3) === substr($grahname, 0, 3) ? 'table-success' : '' }} @endforeach">
                                                                <td class="text-center stock">{{ $value->stock }}
                                                                </td>
                                                                <td class="text-center grahname">{{ $value->grah_name }}
                                                                </td>
                                                                <td class="text-center deg_absolute">
                                                                    {{ $value->deg_absolute }}</td>
                                                                <td class="text-center nifty_price">
                                                                    {{ $value->nifty_price }}</td>
                                                            </tr>
                                                        @endforeach
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

@section('page-js')

    <!-- jQuery script to update color every second -->
    <script>

        //stock wise data show
        $('#stockwiseData').change(function() {
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
                                    '<td class="text-center stock">' + item.stock +
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

        //important value
        $('#submit').on('click', function(e) {
            e.preventDefault();
            var inputnifty = $('#currentinput').val(); // Get input value
            var stock1 = $('#Stokes').val();
            var stock2 = $('#Stokes2').val();


            var stock;
            if (stock1) {
                stock = stock1;
            } else if (stock2) {
                stock = stock2;
            } else {
                stock = ''; // Default to empty if both are not provided
            }

            if(!stock){
                alert('Please select stock.'); // Alert user if input is empty
                return;
            }
            // Check if input is not empty
            if (!inputnifty) {
                alert('Please enter a Nifty price.'); // Alert user if input is empty
                return;
            }

            $.ajax({
                type: 'POST',
                url: '{{ route('importantValue') }}',
                data: {
                    nifty: inputnifty,
                    stock: stock,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    var tbody = $('#niftyCurrentTable tbody');
                    tbody.empty(); // Clear previous data

                    // Check if the response is valid
                    if (Array.isArray(response) && response.length) {
                        response.forEach(function(item) {

                            var rawClass = '';

                            if (item.grah_name.substring(0, 3) === item.grahname.substring(0,
                                    3)) {
                                rawClass =
                                    'table-success'; // Change to whatever class you want to use for green
                            }
                            var row = '<tr class="data-row ' + rawClass + '">' +
                                '<td class="text-center stock">' + item.stock + '</td>' +
                                '<td class="text-center grahname">' + item.grah_name + '</td>' +
                                '<td class="text-center deg_absolute">' + item.deg_absolute +
                                '</td>' +
                                '<td class="text-center nifty_price">' + item.niftyprice +
                                '</td>' +
                                '</tr>';
                            tbody.append(row);
                        });
                    } else {
                        // Show message if no data is returned
                        tbody.append(
                            '<tr><td colspan="3" class="text-center">No data available</td></tr>');
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText); // Log any errors for debugging
                }
            });
        });


        $('#save').on('click', function(e) {
            e.preventDefault();
            var dataToSave = []; // Array to hold the data

            var stock1 = $('#Stokes').val();
            var stock2 = $('#Stokes2').val();

            // Determine which stock value to pass
            var stock;
            if (stock1) {
                stock = stock1;
            } else if (stock2) {
                stock = stock2;
            } else {
                stock = ''; // Default to empty if both are not provided
            }

            // Loop through each row of the table
            $('#niftyCurrentTable tbody .data-row').each(function() {

                var stocks = $(this).find('.stock').text();
                var grahname = $(this).find('.grahname').text();
                var deg_absolute = $(this).find('.deg_absolute').text();
                var nifty_price = $(this).find('.nifty_price').text();

                // Push the data into the array
                dataToSave.push({
                    stocks: stocks,
                    gname: grahname,
                    d_absolute: deg_absolute,
                    n_price: nifty_price
                });
            });
            $.ajax({
                type: 'POST',
                url: '{{ route('currentsavedata') }}',
                data: {
                    data: dataToSave,
                    stock: stock,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    console.log('success', response);
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText); // Log any errors for debugging
                }
            });
        });


        //bhadra start Time
        $(document).ready(function() {
            var colors = ['bg-danger text-white', 'bg-warning text-dark']; // List of colors
            var colorIndex = 0; // Initial color index

            setInterval(function() {
                $('td.bhdrastart-end-time').each(function() {
                    var endTimeText = $(this).text();
                    var endTime = moment(endTimeText,
                        'h:mm A'); // Assuming 'endTimeText' is in 'h:mm A' format

                    var diffInMinutes = endTime.diff(moment(), 'minutes');
                    var classToAdd = colors[colorIndex]; // Get color from array

                    $(this).removeClass(colors.join(' ')); // Remove all colors
                    $(this).addClass(classToAdd); // Add new class based on index

                    // Increment color index, and wrap around if exceeds array length
                    colorIndex = (colorIndex + 1) % colors.length;
                });
            }, 1000); // Repeat every 1 second
        });

        //stocks
        $('#Stokes').change(function() {
            var selectedValue = $(this).val();

            if (selectedValue !== '') {
                $('#Stokes2').prop('disabled', true);
            } else {
                $('#Stokes2').prop('disabled', false);
            }
        });

        $('#Stokes2').on('input', function() {
            var inputValue = $(this).val();

            if (inputValue !== '') {
                $('#Stokes').prop('disabled', true);
            } else {
                $('#Stokes').prop('disabled', false);
            }
        });

        //bhadra end Time

        $(document).ready(function() {
            var colors = ['bg-danger text-white', 'bg-warning text-dark']; // List of colors
            var colorIndex = 0; // Initial color index

            setInterval(function() {
                $('td.bhdraend-end-time').each(function() {
                    var endTimeText = $(this).text();
                    var endTime = moment(endTimeText,
                        'h:mm A'); // Assuming 'endTimeText' is in 'h:mm A' format

                    var diffInMinutes = endTime.diff(moment(), 'minutes');
                    var classToAdd = colors[colorIndex]; // Get color from array

                    $(this).removeClass(colors.join(' ')); // Remove all colors
                    $(this).addClass(classToAdd); // Add new class based on index

                    // Increment color index, and wrap around if exceeds array length
                    colorIndex = (colorIndex + 1) % colors.length;
                });
            }, 1000); // Repeat every 1 second
        });


        //trayodashi start Time
        $(document).ready(function() {
            var colors = ['bg-danger text-white', 'bg-warning text-dark']; // List of colors
            var colorIndex = 0; // Initial color index

            setInterval(function() {
                $('td.trayodashiStart-end-time').each(function() {
                    var endTimeText = $(this).text();
                    var endTime = moment(endTimeText,
                        'h:mm A'); // Assuming 'endTimeText' is in 'h:mm A' format

                    var diffInMinutes = endTime.diff(moment(), 'minutes');
                    var classToAdd = colors[colorIndex]; // Get color from array

                    $(this).removeClass(colors.join(' ')); // Remove all colors
                    $(this).addClass(classToAdd); // Add new class based on index

                    // Increment color index, and wrap around if exceeds array length
                    colorIndex = (colorIndex + 1) % colors.length;
                });
            }, 1000); // Repeat every 1 second
        });

        //trayodashi end Time

        $(document).ready(function() {
            var colors = ['bg-danger text-white', 'bg-warning text-dark']; // List of colors
            var colorIndex = 0; // Initial color index

            setInterval(function() {
                $('td.trayodashiEnd-end-time').each(function() {
                    var endTimeText = $(this).text();
                    var endTime = moment(endTimeText,
                        'h:mm A'); // Assuming 'endTimeText' is in 'h:mm A' format

                    var diffInMinutes = endTime.diff(moment(), 'minutes');
                    var classToAdd = colors[colorIndex]; // Get color from array

                    $(this).removeClass(colors.join(' ')); // Remove all colors
                    $(this).addClass(classToAdd); // Add new class based on index

                    // Increment color index, and wrap around if exceeds array length
                    colorIndex = (colorIndex + 1) % colors.length;
                });
            }, 1000); // Repeat every 1 second
        });

        //amavasya start Time
        $(document).ready(function() {
            var colors = ['bg-danger text-white', 'bg-warning text-dark']; // List of colors
            var colorIndex = 0; // Initial color index

            setInterval(function() {
                $('td.amavasyaStartTime-end-time').each(function() {
                    var endTimeText = $(this).text();
                    var endTime = moment(endTimeText,
                        'h:mm A'); // Assuming 'endTimeText' is in 'h:mm A' format

                    var diffInMinutes = endTime.diff(moment(), 'minutes');
                    var classToAdd = colors[colorIndex]; // Get color from array

                    $(this).removeClass(colors.join(' ')); // Remove all colors
                    $(this).addClass(classToAdd); // Add new class based on index

                    // Increment color index, and wrap around if exceeds array length
                    colorIndex = (colorIndex + 1) % colors.length;
                });
            }, 1000); // Repeat every 1 second
        });

        //amavasya end Time

        $(document).ready(function() {
            var colors = ['bg-danger text-white', 'bg-warning text-dark']; // List of colors
            var colorIndex = 0; // Initial color index

            setInterval(function() {
                $('td.amavasyaEnd-end-time').each(function() {
                    var endTimeText = $(this).text();
                    var endTime = moment(endTimeText,
                        'h:mm A'); // Assuming 'endTimeText' is in 'h:mm A' format

                    var diffInMinutes = endTime.diff(moment(), 'minutes');
                    var classToAdd = colors[colorIndex]; // Get color from array

                    $(this).removeClass(colors.join(' ')); // Remove all colors
                    $(this).addClass(classToAdd); // Add new class based on index

                    // Increment color index, and wrap around if exceeds array length
                    colorIndex = (colorIndex + 1) % colors.length;
                });
            }, 1000); // Repeat every 1 second
        });

        $(document).ready(function() {
            var colors = ['bg-danger text-white', 'bg-primary text-white', 'bg-info text-white',
                'bg-warning text-dark', 'bg-success text-white', 'bg-secondary text-white',
                'bg-dark text-white', 'bg-light text-dark', 'bg-primary text-white', 'bg-info text-white'
            ]; // List of colors
            var colorIndex = 0; // Initial color index

            setInterval(function() {
                $('td.important-time').each(function() {
                    var endTimeText = $(this).text();
                    var endTime = moment(endTimeText,
                        'h:mm A'); // Assuming 'endTimeText' is in 'h:mm A' format

                    var diffInMinutes = endTime.diff(moment(), 'minutes');
                    var classToAdd = colors[colorIndex]; // Get color from array

                    $(this).removeClass(colors.join(' ')); // Remove all colors
                    $(this).addClass(classToAdd); // Add new class based on index

                    // Increment color index, and wrap around if exceeds array length
                    colorIndex = (colorIndex + 1) % colors.length;
                });
            }, 1000); // Repeat every 1 second
        });
    </script>

@endsection
