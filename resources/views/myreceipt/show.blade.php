@extends('layouts.auth')


@section('content')

    @include('layouts.title',[
    'url' => 'MyReceipt.index',
    'urlTitle' => 'رحوع',
    'title'=>'أمر دفع'
    ])


    <div class="company_img rounded mx-auto d-block">
        @if(Storage::disk('logo')->exists($MyReceipt->company->logo))
            <img src="data:image/jpeg;base64,{{ base64_encode(Storage::disk('logo')->get($MyReceipt->company->logo)) }}"
                 class="rounded" alt="{{$MyReceipt->recipient_name}}">
        @endif
    </div>


        <div class="text-center">
            <h4>شركة{{$MyReceipt->company->name}}   </h4>
            <p>امر دفع</p>
        </div>






<div dir="rtl" class="text-center">
    <div class="row">
        <div class="col">
            <p>المستلم : </p>
        </div>
        <div class="col">
            <p>{{$MyReceipt->recipient_name}}</p>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <p>ارجو الموافقة على دفع مبلغ : </p>
        </div>
        <div class="col">
            <p><b>{{$MyReceipt->amount}}</b>  ل.س  / {{$text}} ليرة سورية فقط</p>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <p> وذلك لقاء : </p>

        </div>
        <div class="col">
            <p>{!! nl2br(str_replace(" ", " &nbsp;",$MyReceipt->reason)) !!}</p>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <p>منشأ الأمر : {{$MyReceipt->employee->name}}</p>
        </div>
        <div class="col">
            <p> التاريخ : {{$MyReceipt->created_at->format('Y-m-d')}}</p>
        </div>
    </div>

    <div class="row">

            @if($MyReceipt->status === null)
                <div class="col">
                    <p>في الانتظار...</p>
                </div>
            @else
                @if($MyReceipt->status === 0)
                    <i class="fa fa-times-circle" style="color: red"></i>
                تم الرفض
                @else
                    <i class="fa fa-check-circle" style="color: green"></i>
                تمت الموافقة

                @endif
            @endif

    </div>

    @foreach($MyReceipt->files as $file)
        <div class=" rounded mx-auto d-block" >
            @if(Storage::disk('files')->exists($file->name))
                @if($file->type !== 'application/pdf')
                    <img src="data:image/jpeg;base64,{{ base64_encode(Storage::disk('files')->get($file->name)) }}"
                         width="200px"  class="rounded" alt="{{$file->name}}">
                @else

                    <div class="">
                        <i class="fa fa-file-pdf"></i>
                        <p>{{$file->name}}</p>
                        <a href="{{route('downloadFile',['id'=>$file->id])}}" target="_blank">
                            <i class="fa fa-download"></i>
                        </a>

                    </div>
                    @endif

            @endif
        </div>
    @endforeach
</div>


    @if($MyReceipt->status !== null)
        <div class="accordion mt-lg-5" id="accordionExample">
            <div class="card">
                <div class="card-header" id="heading1">
                    <h2 class="mb-0">
                        <button class="btn btn-link btn-block text-right" type="button" data-toggle="collapse" data-target="#collapse1" aria-expanded="true" aria-controls="collapse1">

                            @if($MyReceipt->status === 0)
                                <i class="fa fa-times-circle" style="color: red"></i>
                            @else
                                <i class="fa fa-check-circle" style="color: green"></i>
                            @endif

                            {{$MyReceipt->manager->name}}
                        </button>
                    </h2>
                </div>

                <div id="collapse1" class="collapse" aria-labelledby="heading1" data-parent="#accordionExample">
                    <div class="card-body">

                        {{$MyReceipt->notes}}
                        <br>
                        {{$MyReceipt->updated_at->format('Y-m-d h:m')}}


                    </div>
                </div>
            </div>


        </div>


    @endif




@endsection
