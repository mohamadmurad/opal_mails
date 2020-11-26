@extends('layouts.auth')



@section('content')


    @include('layouts.title',[
    'url' => 'companies.index',
    'urlTitle' => 'Back',
    'title'=>'Edit Company'
    ])


        @if ($errors->any())

        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
        </div>

    @endif



    <form action="{{ route('companies.update',$company->id) }}" method="POST">

        @csrf

        @method('PUT')



        <div class="row">

            <div class="col-xs-12 col-sm-12 col-md-12">

                <div class="form-group">

                    <strong>Company:</strong>

                    <input type="text" name="name" value="{{ $company->name }}" class="form-control" placeholder="Name">
                    <ul class="errors">
                        @foreach ($errors->get('name') as $message)
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
