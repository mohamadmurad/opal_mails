@extends('layouts.auth')

@section('content')

    @include('layouts.title',[
    'url' => 'MyReceipt.index',
    'urlTitle' => 'رجوع',
    'title'=>'إنشاء امر دفع جديد'
    ])

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>هناك مشكلة في الحقول<br><br>
        </div>
    @endif

    <form action="{{ route('MyReceipt.store') }}" method="POST" id="receipt_form" enctype="multipart/form-data">
        @csrf

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>اسم المستلم:</strong>
                    <input type="text" name="recipient_name" class="form-control" placeholder="اسم المستلم">
                    <ul class="errors">
                        @foreach ($errors->get('recipient_name') as $message)
                            <i>{{ $message }}</i>
                        @endforeach
                    </ul>
                </div>
            </div>


            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>المبلغ:</strong>
                    <input type="number" name="amount" class="form-control" placeholder="المبلغ">
                    <ul class="errors">
                        @foreach ($errors->get('amount') as $message)
                            <i>{{ $message }}</i>
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>السبب:</strong>
                    <textarea form="receipt_form" type="text" name="reason" class="form-control"
                              rows="5" placeholder="السبب">{{old('reason')}}</textarea>
                    <ul class="errors">
                        @foreach ($errors->get('reason') as $message)
                            <i>{{ $message }}</i>
                        @endforeach
                    </ul>
                </div>
            </div>


            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>الشركة:</strong>
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
                <div class="form-group">
                    <strong>ملحقات:</strong>
                    <input type="file" name="files[]" class="form-control"  multiple>
                    <ul class="errors">
                        @foreach ($errors->get('files') as $message)
                            <i>{{ $message }}</i>
                        @endforeach
                    </ul>
                </div>
            </div>








            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <button type="submit" class="btn btn-success">إنشاء</button>
            </div>
        </div>

    </form>
@endsection
