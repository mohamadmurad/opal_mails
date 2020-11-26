@extends('layouts.auth')

@section('content')


{{--    @include('layouts.title',[--}}
{{--    'url' => 'receipt.create',--}}
{{--    'urlTitle' => 'Create New Receipt',--}}
{{--    'title'=>'Manage My Receipt',--}}
{{--    ])--}}



    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

<form action="{{route('receipt.index')}}" method="get">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <input class="form-control " type="date" name="date"/>
        </div>


    </div>
    <div class="col-xs-4 col-sm-4 col-md-4">
        <div class="form-group">
            <input class="btn btn-success" type="submit"  value="تصفية"/>
            <a href="{{route('receipt.index')}}">
                <button class="btn btn-primary">الكل</button></a>
        </div>
    </div>

</form>

    <table class="table table-bordered">
        <tr>
            <th>#</th>
            <th>اسم المستلم</th>
            <th>المبلغ</th>
            <th>الشركة</th>
            <th>حالة الطلب</th>
            <th>الموظف</th>
            <th width="280px">خيارات</th>
        </tr>
        <?php $i = 0?>
        @foreach ($receipts as $receipt)
            <tr>
                <td>{{ ++$i }}</td>

                <td>{{ $receipt->recipient_name }}</td>
                <td>{{ $receipt->amount }}</td>
                <td>{{ $receipt->company->name }}</td>

                    @if($receipt->status === 1)
                    <td style="color: forestgreen">
                        تم القبول
                    </td>
                        @elseif($receipt->status === 0)
                    <td style="color: red">
                        تم الرفض
                    </td>
                    @else
                    <td >
                        في الانظار
                    </td>
                    @endif

                <td>{{ $receipt->employee->name }}</td>


                <td>
                    <a class="btn btn-success" href="{{ route('receipt.show',$receipt->id) }}">تفاصيل</a>
{{--                    @if($receipt->status === 0)--}}
{{--                        <div class="btn-group" role="group">--}}
{{--                            <button id="btnGroupDrop1" type="button" class="btn btn-secondary dropdown-toggle"--}}
{{--                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">--}}
{{--                                Actions--}}
{{--                            </button>--}}
{{--                            <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">--}}

{{--                                <button type="button" class="btn btn-primary" data-toggle="modal"--}}
{{--                                         data-target="#accept_modal" data-whatever="{{$receipt->id}}">--}}
{{--                                    <i class="fa fa-check-circle"></i>--}}
{{--                                   Accept--}}
{{--                                </button>--}}

{{--                                <button type="button" class="btn btn-danger" data-toggle="modal"--}}
{{--                                         data-target="#refuse_modal" data-whatever="{{$receipt->id}}">--}}
{{--                                    <i class="fa fa-times-circle"></i>--}}
{{--                                   Refuse--}}
{{--                                </button>--}}


{{--                                <a class="dropdown-item" href="{{ route('receipt.edit',$receipt->id) }}">Edit</a>--}}

{{--                                <form action="{{ route('receipt.destroy',$receipt->id) }}" method="POST">--}}
{{--                                    @csrf--}}
{{--                                    @method('DELETE')--}}
{{--                                    <button type="submit" class="dropdown-item">Delete</button>--}}
{{--                                </form>--}}


{{--                            </div>--}}
{{--                        </div>--}}
{{--                    @endif--}}
                </td>
            </tr>
        @endforeach
    </table>
    <div class="d-flex justify-content-center">
        {!! $receipts->links() !!}
    </div>


{{--<div class="modal" id="accept_modal" tabindex="-1" role="dialog">--}}
{{--    <div class="modal-dialog" role="document">--}}
{{--        <div class="modal-content">--}}
{{--            <div class="modal-header">--}}
{{--                <h5 class="modal-title">Accept</h5>--}}
{{--                <button type="button" class="close" data-dismiss="modal" aria-label="Close">--}}
{{--                    <span aria-hidden="true">&times;</span>--}}
{{--                </button>--}}
{{--            </div>--}}
{{--            <div class="modal-body">--}}

{{--                <form action="{{ route('accept') }}" method="POST" id="accept_form">--}}
{{--                    @csrf--}}
{{--                    <input type="hidden" name="receipt_id" id="receipt_id" value="{{$receipt->id}}">--}}
{{--                    <div class="col-xs-12 col-sm-12 col-md-12">--}}
{{--                        <div class="form-group">--}}
{{--                            <strong>Notes:</strong>--}}
{{--                            <textarea form="accept_form" type="text" name="notes" class="form-control"--}}
{{--                                      rows="5" placeholder="Notes">{{old('notes')}}</textarea>--}}
{{--                            <ul class="errors">--}}
{{--                                @foreach ($errors->get('notes') as $message)--}}
{{--                                    <i>{{ $message }}</i>--}}
{{--                                @endforeach--}}
{{--                            </ul>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <button type="submit" class="btn btn-primary">Accept</button>--}}
{{--                </form>--}}

{{--            </div>--}}
{{--            <div class="modal-footer">--}}
{{--                --}}{{--                <button type="button" class="btn btn-primary">Save changes</button>--}}
{{--                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}










{{--<div class="modal" id="refuse_modal" tabindex="-1" role="dialog">--}}
{{--    <div class="modal-dialog" role="document">--}}
{{--        <div class="modal-content">--}}
{{--            <div class="modal-header">--}}
{{--                <h5 class="modal-title">Refuse</h5>--}}
{{--                <button type="button" class="close" data-dismiss="modal" aria-label="Close">--}}
{{--                    <span aria-hidden="true">&times;</span>--}}
{{--                </button>--}}
{{--            </div>--}}
{{--            <div class="modal-body">--}}

{{--                <form action="{{ route('refuse') }}" method="POST" id="refuse_form">--}}
{{--                    @csrf--}}
{{--                    <input type="hidden" name="receipt_id" id="receipt_id" value="{{$receipt->id}}">--}}
{{--                    <div class="col-xs-12 col-sm-12 col-md-12">--}}
{{--                        <div class="form-group">--}}
{{--                            <strong>Notes:</strong>--}}
{{--                            <textarea form="refuse_form" type="text" name="notes" class="form-control"--}}
{{--                                      rows="5" placeholder="Notes">{{old('notes')}}</textarea>--}}
{{--                            <ul class="errors">--}}
{{--                                @foreach ($errors->get('notes') as $message)--}}
{{--                                    <i>{{ $message }}</i>--}}
{{--                                @endforeach--}}
{{--                            </ul>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <button type="submit" class="btn btn-danger">Refuse</button>--}}
{{--                </form>--}}

{{--            </div>--}}
{{--            <div class="modal-footer">--}}
{{--                --}}{{--                <button type="button" class="btn btn-primary">Save changes</button>--}}
{{--                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}


@endsection
<script>
    import Input from "@/Jetstream/Input";
    import Button from "@/Jetstream/Button";
    export default {
        components: {Button, Input}
    }
</script>
