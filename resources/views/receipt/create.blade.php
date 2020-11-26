@extends('layouts.auth')

@section('content')

    @include('layouts.title',[
    'url' => 'MyReceipt.index',
    'urlTitle' => 'Back',
    'title'=>'Create New Receipt'
    ])

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
        </div>
    @endif

    <form action="{{ route('MyReceipt.store') }}" method="POST" id="receipt_form">
        @csrf

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Recipient Name:</strong>
                    <input type="text" name="recipient_name" class="form-control" placeholder="Recipient Name">
                    <ul class="errors">
                        @foreach ($errors->get('recipient_name') as $message)
                            <i>{{ $message }}</i>
                        @endforeach
                    </ul>
                </div>
            </div>


            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Amount:</strong>
                    <input type="number" name="amount" class="form-control" placeholder="amount">
                    <ul class="errors">
                        @foreach ($errors->get('amount') as $message)
                            <i>{{ $message }}</i>
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Reason:</strong>
                    <textarea form="receipt_form" type="text" name="reason" class="form-control"
                              rows="5" placeholder="Reason">{{old('reason')}}</textarea>
                    <ul class="errors">
                        @foreach ($errors->get('reason') as $message)
                            <i>{{ $message }}</i>
                        @endforeach
                    </ul>
                </div>
            </div>












            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <button type="submit" class="btn btn-success">Save</button>
            </div>
        </div>

    </form>
@endsection
