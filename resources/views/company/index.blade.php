@extends('layouts.auth')

@section('content')


    @include('layouts.title',[
    'url' => 'companies.create',
    'urlTitle' => 'Create New Company',
    'title'=>'Manage Company',
    ])




    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

    <table class="table table-bordered">
        <thead class="thead-dark">
        <tr>
            <th scope="col">#</th>
            <th scope="col">Company</th>
            <th width="280px" scope="col">Action</th>

        </tr>
        </thead>

        <?php $i = 0?>
        @foreach ($companies as $company)
            <tr>
                <td>{{ ++$i }}</td>
                <td>{{ $company->name }}</td>

                <td>
                    <div class="btn-group" role="group">
                        <button id="btnGroupDrop1" type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Actions
                        </button>
                        <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
{{--                            <a class="dropdown-item" href="{{ route('companies.show',$company->id) }}">Show</a>--}}
                            <a class="dropdown-item" href="{{ route('companies.edit',$company->id) }}">Edit</a>

                            <form action="{{ route('companies.destroy',$company->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="dropdown-item">Delete</button>
                            </form>
                        </div>
                    </div>

                </td>
            </tr>
        @endforeach
    </table>
    <div class="d-flex justify-content-center">
    {!! $companies->links() !!}
    </div>

@endsection
