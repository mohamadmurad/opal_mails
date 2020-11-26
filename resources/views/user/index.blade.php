@extends('layouts.auth')

@section('content')


    @include('layouts.title',[
    'url' => 'user.create',
    'urlTitle' => 'Create New User',
    'title'=>'Manage Users',
    ])



    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

    <table class="table table-bordered">
        <tr>
            <th>No</th>
            <th>Name</th>
            <th>Email</th>
            <th>Manager</th>
            <th>Admin</th>
            <th>Company</th>

            <th width="280px">خيارات</th>
        </tr>
        <?php $i = 0?>
        @foreach ($users as $user)
            <tr>
                <td>{{ ++$i }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->username }}</td>
                <td>{{ $user->isManager == 0 ? 'employee' : 'Manager' }}</td>
                <td>{{ $user->isAdmin == 0 ? 'User' : 'Admin' }}</td>
                <td>{{ $user->company !== null ? $user->company->name: 'non' }}</td>

                <td>
                <div class="btn-group" role="group">
                    <button id="btnGroupDrop1" type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Actions
                    </button>
                    <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                        {{--                            <a class="dropdown-item" href="{{ route('companies.show',$company->id) }}">Show</a>--}}
                        <a class="dropdown-item" href="{{ route('user.edit',$user->id) }}">Edit</a>

                        <form action="{{ route('user.destroy',$user->id) }}" method="POST">
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
        {!! $users->links() !!}
    </div>

@endsection
