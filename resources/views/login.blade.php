
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>@yield('title')</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="{{ asset('frontend/css/bootstrap.min.css') }}">
        <script src ="{{ asset('frontend/js/jquery_3.3.js') }}"></script>
        <script src ="{{ asset('frontend/js/bootstrap.bundle.min.js') }}"></script>
    </head>
    <body>


        @section('body-content')
        <section class="body-content">

            <div class="container col-4 mt-4">

                @if ($errors->any())
                <ul>
                    {!! implode('',$errors->all('<li>:message</li>')) !!}
                @endif

                <h2 class="text-center mb-4">Login</h2>
                <form name="frm_login" id="frm_login" method="post" action="validateUser">

                    <div class="form-outline mb-4">
                        <label class="form-label" for="form2Example1">Email address</label>
                        <input type="email" id="form2Example1" name="email" class="form-control" />
                    </div>
                    <div class="form-outline mb-4">
                        <label class="form-label" for="form2Example2">Password</label>
                        <input type="password" id="form2Example2" name="password" class="form-control" />
                    </div>
                    <div class="row mb-4">
                        <div class="col d-flex justify-content-center">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="form2Example31" checked />
                                <label class="form-check-label" for="form2Example31"> Remember me </label>
                            </div>
                        </div>
                        <div class="col">
                            <a href="#!">Forgot password?</a>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary btn-block mb-4">Sign in</button>

                    <div class="text-center">
                        <p>Not a member? <a href="{{'register'}}">Register</a></p>
                    </div>
                    @csrf
                </form>
            </div>
            </section>
        @show

    </body>
</html>




