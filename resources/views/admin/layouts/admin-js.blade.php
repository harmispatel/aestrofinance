<!-- Vendor JS Files -->
<script src="{{ asset('public/assets/vendor/apexcharts/apexcharts.min.js') }}"></script>
<script src="{{ asset('public/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('public/assets/vendor/chart.js/chart.min.js') }}"></script>
<script src="{{ asset('public/assets/vendor/echarts/echarts.min.js') }}"></script>
<script src="{{ asset('public/assets/vendor/quill/quill.min.js') }}"></script>
<script src="{{ asset('public/assets/vendor/tinymce/tinymce.min.js') }}"></script>
<script src="{{ asset('public/assets/vendor/php-email-form/validate.js') }}"></script>

<!-- Template Main JS File -->
<script src="{{ asset('public/assets/vendor/js/main.js') }}"></script>

{{-- Jquery --}}
<script src="{{ asset('public/assets/admin/js/jquery/jquery.min.js') }}"></script>

{{-- Sweet Alert --}}
<script src="{{ asset('public/assets/vendor/js/sweet-alert.js') }}"></script>

{{-- Data Table --}}
<script src="{{ asset('public/assets/vendor/simple-datatables/simple-datatables.js') }}"></script>

{{-- Jquery UI --}}
<script src="{{ asset('public/assets/vendor/js/jquery-ui.js') }}"></script>

{{-- Date & Time Picker --}}
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

{{-- common --}}
<script src="{{ asset('public/assets/vendor/js/common.js') }}"></script>

<script src="//cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
<script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>
<script type="text/javascript" src="http://oss.sheetjs.com/js-xlsx/xlsx.core.min.js"></script>
<script type="text/javascript" src="http://sheetjs.com/demos/FileSaver.js"></script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-timepicker/1.10.0/jquery.timepicker.min.js"></script>

<script type="text/javascript" src="{{ asset('public/assets/vendor/js/moment.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('public/assets/vendor/js/daterangepicker.min.js') }}"></script>



<script type="text/javascript">


@if(Session::has('message'))
  toastr.options =
  {
  	"closeButton" : true,
  	"progressBar" : true
  }
  		toastr.success("{{ session('message') }}");
  @endif

  @if(Session::has('error'))
  toastr.options =
  {
  	"closeButton" : true,
  	"progressBar" : true
  }
  		toastr.error("{{ session('error') }}");
  @endif

</script>
