<!DOCTYPE html>
<html>
<head>
  
    @include('partials._header')

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    @yield('css')

    @stack('scripts')

</head>


<body class="bg-light">
  <div id="app" >
      <div id="wrapper">
        @include('partials._sidebar')
        @include('partials._navbar')
        <div class="content-wrapper">
            @yield('content')
        </div>
        @include('partials._footer') 
      </div>
  </div>

  <script src="{{ asset('js/app.js') }}" ></script>

  <script type="text/javascript">
    $('.datatable').DataTable({
      "language": {
        "sEmptyTable":   "{{ __('lang.sEmptyTable') }}",
        "sProcessing":   "{{ __('lang.sProcessing') }}",
        "sLengthMenu":   "{{ __('lang.sLengthMenu') }}",
        "sZeroRecords":  "{{ __('lang.sZeroRecords') }}",
        "sInfo":         "{{ __('lang.sInfo') }}",
        "sInfoEmpty":    "{{ __('lang.sInfoEmpty') }}",
        "sInfoFiltered": "{{ __('lang.sInfoFiltered') }}",
        "sInfoPostFix":  "{{ __('lang.sInfoPostFix') }}",
        "sSearch":       "{{ __('lang.sSearch') }}",
        "oPaginate": {
          "sFirst":    "{{ __('lang.sFirst') }}",
          "sPrevious": "{{ __('lang.sPrevious') }}",
          "sNext":     "{{ __('lang.sNext') }}",
          "sLast":     "{{ __('lang.sLast') }}"
        }
      }
    });
  </script>

  <script type="text/javascript">

    $(".wbd-form").submit(function (e) {
      
      e.preventDefault();

      swal.fire({
        title: "{{__('lang.are_you_sure')}}",
        text: "{{__('lang.this_will_proceed')}}",
        type: 'warning',
        showCancelButton: true,
        confirmButtonText: "{{__('lang.yes_change_it')}}",
        cancelButtonText: "{{__('lang.no_keep_it')}}",
        }).then((result) => {
          if (result.value) {
            $(this).closest(".wbd-form").off("submit").submit();
          }else{
            swal.fire("{{__('lang.cancelled')}}","{{__('lang.your_request_safe')}}",'error')
          }
      });

    });
    var table = $('#print-table').DataTable({
        autoWidth: false,
        columns : [
            { width : '50px' },
            { width : '50px' },
            { width : '50px' },
            { width : '50px' },        
            { width : '50px' },
            { width : '50px' }        
        ] 
    });
  </script>

  @yield('script')

  @if (session('message'))
    <script type="text/javascript">
      toastr.options = {
        "positionClass": "toast-top-left"
      }
      toastr.success('{{ session("message") }}');
    </script>
  @endif

</body>
@stack('footer')
</html>