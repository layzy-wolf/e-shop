@extends("admin.layout")
@section("content")
    <main class="mx-5 my-5 w-100">
        <h2>
            Пользователи
        </h2>
        <hr>
        <div>
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">Id</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                </tr>
                </thead>
                <tbody>
                @foreach($users as $user)
                    <tr>
                        <th scope="row">{{$user->id}}</th>
                        <th class="fw-medium">{{$user->name}}</th>
                        <th class="fw-medium">{{$user->email}}</th>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </main>
@endsection
