
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>@yield('title')</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="{{ asset('frontend/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('frontend/css/style.css') }}">
        <script src ="{{ asset('frontend/js/jquery_3.3.js') }}"></script>
        <script src ="{{ asset('frontend/js/bootstrap.bundle.min.js') }}"></script>

        <link rel="stylesheet" href="{{ asset('datatable/datatable.min.css') }}">
        <link rel="stylesheet" href="{{ asset('datatable/foundation.css') }}">
        <script src ="{{ asset('datatable/datatable.min.js') }}"></script>
        <script src ="{{ asset('datatable/datatable.buttons.js') }}"></script>
        <script src ="{{ asset('datatable/datatable.html5.buttons.js') }}"></script>
        <script src ="{{ asset('datatable/datatable.pdf.js') }}"></script>
        <script src ="{{ asset('datatable/datatable.excel.js') }}"></script>
        <script src ="{{ asset('datatable/datatable.pdf.font.js') }}"></script>

        <link rel="stylesheet" href="{{ asset('multiselect/multiselect.css') }}">
        <script src ="{{ asset('multiselect/multiselect.js') }}"></script>


        <link rel="stylesheet" href="{{ asset('fontawesome/css/all.min.css') }}">
        <script src ="{{ asset('fontawesome/js/all.min.js') }}"></script>

    </head>
    <body>

        @include('layouts.include.header')

        @section('body-content')
        <section class="body-content">
            <div class="container">
                <h1 >test</h1>
            </div>
        </section>
        @show

        @include('layouts.include.footer')

    </body>
</html>
