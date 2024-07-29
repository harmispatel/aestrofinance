<!-- Favicons -->
<link href="{{ asset('public/admin_images/demo_images/favicons/home.png') }}" rel="icon">

<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

<!-- Vendor CSS Files -->
<link href="{{ asset('public/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
<link href="{{ asset('public/assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
<link href="{{ asset('public/assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
<link href="{{ asset('public/assets/vendor/quill/quill.snow.css') }}" rel="stylesheet">
<link href="{{ asset('public/assets/vendor/quill/quill.bubble.css') }}" rel="stylesheet">
<link href="{{ asset('public/assets/vendor/remixicon/remixicon.css') }}" rel="stylesheet">

{{-- Date & Time Picker --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">


{{-- Toastr --}}
<link href="{{ asset('public/assets/vendor/toastr/css/toastr.min.css') }}" rel="stylesheet">
{{-- DataTable --}}
<link href="{{ asset('public/assets/vendor/simple-datatables/style.css') }}" rel="stylesheet">

<!-- Template Main CSS File -->
<link href="{{ asset('public/assets/vendor/css/style.css') }}" rel="stylesheet">
<link href="{{ asset('public/assets/vendor/css/custom.css') }}" rel="stylesheet">

{{-- sweetAlert 2 --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.min.css">

<link rel="stylesheet" href="//cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">

{{-- Jquey UI --}}
<link rel="stylesheet" href="{{ asset('public/assets/vendor/css/jquery-ui.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"  />

<link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.css">

<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />




<style>


    .datePicker {
        cursor: pointer;
    }
    /* Toggle Status Button */
    .form-check-input:checked{
        background-color: #198754!important;
        border-color: #198754!important;
    }
    .form-check-input{
        background-color: #e47b86!important;
        border-color: #e47b86!important;
    }
    .form-switch .form-check-input
    {
        width: 45px!important;
        height: 25px!important;
    }

    /* AutoComplete */
    .pac-container {
        z-index: 9999;
    }
      /* select 2 css */
      /* .select2 {
        width: 100%!important;
    } */
    .select2-selection{
        min-height: 37px!important;
    }
    .select2-container--default .select2-selection--multiple{
        border: 1px solid #ced4da!important;
    }

    #loader {
        position: fixed;
        left: 0;
        top: 0;
        z-index: 1000;
        background: rgba(0, 0, 0, 0.3);
        padding: 20px;
        border-radius: 5px;
        width: 100%;
        height:100%;
        display: flex;
        align-items: center;
        justify-content:center;
    }
    #loader img{
        width: 100px;
        mix-blend-mode: color;
    }
</style>
<!-- =======================================================
* Template Name: NiceAdmin - v2.3.1
* Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
* Author: BootstrapMade.com
* License: https://bootstrapmade.com/license/
======================================================== -->
