<!DOCTYPE html>
<html lang="en">
<head>
    <!-- App css -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}"  type="text/css" />
    <link rel="stylesheet" href="{{ asset('css/icons.min.css') }}"  type="text/css" />
    <link rel="stylesheet" href="{{ asset('css/app.min.css') }}"  type="text/css" />
    <link rel="stylesheet" href="{{ asset('css/datatables.min.css') }}" type="text/css">
    @include('components.sweetalert2')

    @yield('seo')
    @yield('styles')
</head>
<body>
    @yield('content')

    <script type="text/javascript" src="{{ asset('js/vendor.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/datatables.min.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        });
    </script>
    @yield('scripts')
</body>
</html>
