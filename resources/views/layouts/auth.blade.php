<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('fontawesome/css/all.css') }}">

    <!-- Scripts -->
    <script src="{{ URL::asset('js/jquery-3.5.1.min.js') }}"></script>
    <script src="{{ mix('js/app.js') }}" defer></script>

</head>
<body>
<div class="font-sans text-gray-900 antialiased">


    <nav class="navbar navbar-expand-lg  navbar-dark bg-dark " style="color: white">
        Opal & Go Toys



        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ">
{{--                <li class="nav-item active">--}}
{{--                    <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>--}}
{{--                </li>--}}

                @auth
                    @if(\Illuminate\Support\Facades\Auth::user()->isAdmin === 1)
                        <li class="nav-item active">
                            <a class="nav-link" href="{{route('MyReceipt.index')}}">أوامر الدفع </a>
                        </li>

                        <li class="nav-item active">
                            <a class="nav-link" href="{{route('receipt.index')}}">كل أوامر الدفع</a>
                        </li>

                        <li class="nav-item active">
                            <a class="nav-link" href="{{route('user.index')}}">المستخدمين</a>
                        </li>


                        <li class="nav-item active">
                            <a class="nav-link" href="{{route('companies.index')}}">الشركات</a>
                        </li>

                    @elseif( \Illuminate\Support\Facades\Auth::user()->isManager === 0)
                        <li class="nav-item active">
                            <a class="nav-link" href="{{route('MyReceipt.index')}}">أوامر الدفع </a>
                        </li>
                    @else
                        <li class="nav-item active">
                            <a class="nav-link" href="{{route('receipt.index')}}">كل أوامر الدفع</a>
                        </li>
                    @endif
                @endauth



                @if (Route::has('login'))
                    @auth
{{--                        <li class="nav-item active">--}}
{{--                            <a href="{{ url('/dashboard') }}" class="nav-link">Dashboard</a>--}}
{{--                        </li>--}}







                    @else
                        <li class="nav-item active">
                            <a href="{{ route('login') }}" class="nav-link">تسجيل الدخول</a>
                        </li>
                    @endauth
                @endif
            </ul>
            @auth
            <ul class=" navbar-nav mr-auto float-right">
                <li class="nav-item active float-left">
                    <a class="nav-link" href="#">{{\Illuminate\Support\Facades\Auth::user()->name}}</a>
                </li>
                <li class="nav-item active">
                    <form action="{{ route('logout') }}" method="POST" style="margin: 0">
                        @csrf

                        <a type="submit" class="nav-link" style="color: white"><button type="submit">تسجيل الخروج</button></a>

                    </form>
                </li>
            </ul>
            @endauth



        </div>
    </nav>


    <div class="container mt-5 text-right">

        @yield('content')

    </div>
</div>
    <script>

        $('#accept_modal').on('show.bs.modal', function (event) {
            console.log('fdf');
            var button = $(event.relatedTarget) // Button that triggered the modal
            var recipient = button.data('whatever') // Extract info from data-* attributes
            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
            var modal = $(this)
            // modal.find('.modal-title').text('New message to ' + recipient)
            modal.find('.modal-body #receipt_id').val(recipient)
        })
    </script>

</body>
</html>
{{--<script>--}}
{{--    import Input from "@/Jetstream/Input";--}}
{{--    export default {--}}
{{--        components: {Input}--}}
{{--    }--}}
{{--</script>--}}


<script>
    import Input from "@/Jetstream/Input";
    import Button from "@/Jetstream/Button";
    export default {
        components: {Button, Input}
    }
</script>
