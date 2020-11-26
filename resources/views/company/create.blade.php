@extends('layouts.auth')

@section('content')


    @include('layouts.title',[
    'url' => 'companies.index',
    'urlTitle' => 'Back',
    'title'=>'Create New Company',
    ])

    @if ($errors->any())

        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
{{--            <ul>--}}
{{--                @foreach ($errors->all() as $error)--}}
{{--                    <li>{{ $error }}</li>--}}
{{--                @endforeach--}}
{{--            </ul>--}}
        </div>
    @endif

    <form action="{{ route('companies.store') }}" method="POST"  enctype="multipart/form-data">
        @csrf

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Company:</strong>
                    <input type="text" name="name" class="form-control" placeholder="Company">
                    <ul class="errors">
                    @foreach ($errors->get('name') as $message)
                        <i>{{ $message }}</i>
                    @endforeach
                    </ul>
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-4 text-center">
                <div class="form-group">
                    <strong>logo :</strong>
                    <input type="file" name="logo"  id="logo" class="form-control" accept="image/*" >
                    <ul class="errors">
                        @foreach ($errors->get('logo') as $message)
                            <i>{{ $message }}</i>
                        @endforeach
                    </ul>
                </div>
                <img id="img3" class="imgPreview">
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <button type="submit" class="btn btn-success">Save</button>
            </div>
        </div>

    </form>
@endsection
