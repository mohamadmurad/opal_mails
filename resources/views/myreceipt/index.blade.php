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
    <div class="table-responsive">
    <table class="table table-bordered" >
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
                    <td >
                        في الانظار
                    </td>
                @endif
                <td>{{ $receipt->employee->name }}</td>


                <td>
                    <a class="btn btn-success" href="{{ route('MyReceipt.show',$receipt->id) }}">تفاصيل</a>
                    @if($receipt->status === null)
                        <div class="btn-group" role="group">
                            <button id="btnGroupDrop1" type="button" class="btn btn-secondary dropdown-toggle"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                خيارات
                            </button>
                            <div class="dropdown-menu text-right" aria-labelledby="btnGroupDrop1">

                                <a class="dropdown-item" href="{{ route('MyReceipt.edit',$receipt->id) }}">تعديل</a>

                                <form action="{{ route('MyReceipt.destroy',$receipt->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="dropdown-item delete_btn">حذف</button>
                                </form>


                            </div>
                        </div>
                    @endif
                </td>
            </tr>
        @endforeach
    </table>
    </div>
    <div class="d-flex justify-content-center">
        {!! $receipts->links() !!}
    </div>

@endsection
