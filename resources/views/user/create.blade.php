@extends('layouts.auth')

@section('content')

    @include('layouts.title',[
    'url' => 'user.index',
    'urlTitle' => 'Back',
    'title'=>'Create New user'
    ])

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>

        </div>
    @endif

    <form action="{{ route('user.store') }}" method="POST">
        @csrf

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Name:</strong>
                    <input type="text" name="name" class="form-control" placeholder="Name">
                    <ul class="errors">
                        @foreach ($errors->get('name') as $message)
                            <i>{{ $message }}</i>
                        @endforeach
                    </ul>
                </div>
            </div>


            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Email:</strong>
                    <input type="email" name="email" class="form-control" placeholder="email">
                    <ul class="errors">
                        @foreach ($errors->get('email') as $message)
                            <i>{{ $message }}</i>
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Password:</strong>
                    <input type="password" name="password" class="form-control" placeholder="password">
                    <ul class="errors">
                        @foreach ($errors->get('password') as $message)
                            <i>{{ $message }}</i>
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Confirm Password :</strong>
                    <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm Password">
                    <ul class="errors">
                        @foreach ($errors->get('password_confirm') as $message)
                            <i>{{ $message }}</i>
                        @endforeach
                    </ul>
                </div>
            </div>




            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Company:</strong>
                    <select  class="form-control"  name="company_id">

                        @foreach($company as $com)
                            <option value="{{ $com->id }}">{{$com->name}}</option>
                        @endforeach
                    </select>
                    <ul class="errors">
                        @foreach ($errors->get('company_id') as $message)
                            <i>{{ $message }}</i>
                        @endforeach
                    </ul>

                </div>
            </div>



            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" id="exampleRadios1" name="isAdmin" value="0" checked>
                    <label class="form-check-label" for="exampleRadios1">
                        User
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" id="exampleRadios2" name="isAdmin" value="1">
                    <label class="form-check-label" for="exampleRadios2">
                        Admin
                    </label>
                </div>

            </div>

            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" id="exampleRadios3" name="isManager" value="0" checked>
                    <label class="form-check-label" for="exampleRadios3">
                        Employee
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" id="exampleRadios4" name="isManager" value="1">
                    <label class="form-check-label" for="exampleRadios4">
                        Manager
                    </label>
                </div>

            </div>

            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <button type="submit" class="btn btn-success">Save</button>
            </div>
        </div>

    </form>
@endsection
