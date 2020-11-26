@extends('layouts.auth')

@section('content')


    {{--        @if (Route::has('login'))--}}
    {{--            <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block">--}}
    {{--                @auth--}}
    {{--                    <a href="{{ url('/dashboard') }}" class="text-sm text-gray-700 underline">Dashboard</a>--}}
    {{--                @else--}}
    {{--                    <a href="{{ route('login') }}" class="text-sm text-gray-700 underline">Login</a>--}}

    {{--                    @if (Route::has('register'))--}}
    {{--                        <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 underline">Register</a>--}}
    {{--                    @endif--}}
    {{--                @endauth--}}
    {{--            </div>--}}
    {{--        @endif--}}






            @auth
                @if(\Illuminate\Support\Facades\Auth::user()->isAdmin === 1)
                    <a href="{{route('receipt.index')}}"><button class="btn btn-dark">كل أوامر الدفع</button></a>
                    <a href="{{route('MyReceipt.index')}}"><button class="btn btn-dark">أوامر الدفع</button></a>

                @elseif( \Illuminate\Support\Facades\Auth::user()->isManager === 0)
                    <a href="{{route('MyReceipt.index')}}"><button class="btn btn-dark">أوامر الدفع</button></a>
                @else
                    <a href="{{route('receipt.index')}}"><button class="btn btn-dark">كل أوامر الدفع</button></a>

                @endif
            @else
                <a href="{{route('login')}}"><button class="btn btn-dark">تسجيل الدخول</button></a>
            @endauth





<script>
    import Button from "@/Jetstream/Button";
    export default {
        components: {Button}
    }
</script>
