@extends('layouts.auth')


@section('content')

    @include('layouts.title',[
    'url' => 'user.index',
    'urlTitle' => 'Back',
    'title'=>'Edit User'
    ])




        @if ($errors->any())

        <div class="alert alert-danger">

            <strong>Whoops!</strong> There were some problems with your input.<br><br>

        </div>

    @endif



    <form action="{{ route('user.update',$user->id) }}" method="POST">

        @csrf

        @method('PUT')



        <div class="row">



            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Name:</strong>
                    <input type="text" name="name" value="{{ $user->name }}" class="form-control" placeholder="الاسم">
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
                    <input type="text" name="email" value="{{ $user->email }}" class="form-control" placeholder="ُemail">
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
                    <input type="password" name="password"  class="form-control" placeholder="كلمة المرور">
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
                    <input type="password" name="password_confirmation" class="form-control" placeholder="تأكيد كلمة المرور">
                    <ul class="errors">
                        @foreach ($errors->get('password_confirm') as $message)
                            <i>{{ $message }}</i>
                        @endforeach
                    </ul>
                </div>
            </div>


            <div class="col-xs-12 col-sm-12 col-md-12">

                <div class="form-check form-check-inline">

                    <input class="form-check-input" type="radio" id="exampleRadios1" name="isAdmin" value="0" {{$user->isAdmin ===0 ? 'checked' : ''}}>
                    <label class="form-check-label" for="exampleRadios1">
                        User
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" id="exampleRadios2" name="isAdmin" value="1" {{$user->isAdmin ===1 ? 'checked' : ''}}>
                    <label class="form-check-label" for="exampleRadios2">
                        Admin
                    </label>
                </div>

            </div>


            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" id="exampleRadios3" name="isManager" value="0" {{$user->isManager ===0 ? 'checked' : ''}}>
                    <label class="form-check-label" for="exampleRadios3">
                        Employee
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" id="exampleRadios4" name="isManager" value="1" {{$user->isManager ===1 ? 'checked' : ''}}>
                    <label class="form-check-label" for="exampleRadios4">
                        Manager
                    </label>
                </div>

            </div>


            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Company:</strong>
                    <select  class="form-control"  name="company_id">

                        @foreach($company as $com)
                            <option value="{{ $com->id }}" {{ ($user->company_id == $com->id ? "selected":"") }}>{{$com->name}}</option>
                        @endforeach
                    </select>
                    <ul class="errors">
                        @foreach ($errors->get('company_id') as $message)
                            <i>{{ $message }}</i>
                        @endforeach
                    </ul>

                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12 text-center">

                <button type="submit" class="btn btn-primary">Update</button>

            </div>

        </div>



    </form>

@endsection
