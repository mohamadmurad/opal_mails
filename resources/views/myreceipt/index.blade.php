@extends('layouts.auth')

@section('content')


    @include('layouts.title',[
    'url' => 'MyReceipt.create',
    'urlTitle' => 'إنشاء أمر دفع جديد',
    'title'=>'أوامر الدفع',
    ])



    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

    <form action="{{route('MyReceipt.index')}}" method="get">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>التاريخ:</strong>
                <input class="form-control " type="date" name="date" placeholder="التاريخ"/>
            </div>


        </div>
        <div class="col-xs-4 col-sm-4 col-md-4">
            <div class="form-group">
                <input class="btn btn-success" type="submit" value="تصفية"/>
                <a href="{{route('MyReceipt.index')}}">
                    <button class="btn btn-primary">الكل</button>
                </a>
            </div>
        </div>

    </form>


    @if(count($receipts) > 0)
        <div class="table-responsive">
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
                    <tr class="{{$receipt->status === 0 ? 'table-danger' : '' }}">
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
                            <td>
                                في الانتظار
                            </td>
                        @endif
                        <td>{{ $receipt->employee->name }}</td>


                        <td>
                            <a class="btn btn-success" href="{{ route('MyReceipt.show',$receipt->id) }}">تفاصيل</a>
                            @if(Auth::user()->isAdmin === 1 || Auth::user()->isManager !== 1)
                                @if($receipt->status === null)
                                    <div class="btn-group" role="group">
                                        <button id="btnGroupDrop1" type="button" class="btn btn-secondary dropdown-toggle"
                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            خيارات
                                        </button>
                                        <div class="dropdown-menu text-right" aria-labelledby="btnGroupDrop1">

                                            <a class="dropdown-item"
                                               href="{{ route('MyReceipt.edit',$receipt->id) }}">تعديل</a>

                                            <form action="{{ route('MyReceipt.destroy',$receipt->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item delete_btn">حذف</button>
                                            </form>


                                        </div>
                                    </div>
                                @endif
                            @endif
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    @else
        <div class="text-center">
            <i class="fa fa-search"></i>

            <h5>لا يوجد نتائج</h5>
        </div>
    @endif
    <div class="d-flex justify-content-center">
        {!! $receipts->links() !!}
    </div>

@endsection
