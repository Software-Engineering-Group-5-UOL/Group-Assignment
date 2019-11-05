@extends('/layout')

@section('content')
<div class="ice-panel">
    <h1 class="title text-center">Log in</h1>
    <form action="/track" method="post">
        @csrf
        <div class="form-group">
            <input type="email" class="form-control" id="username" aria-describedby="emailHelp" placeholder="Username or Email address">
        </div>
        <div class="form-group">
            <input type="password" class="form-control" id="password" name="password" placeholder="Password">
        </div>
        <div class="form-group">
            <input type="submit" class="btn login-btn"></input>
        </div>
    </form>
</div>
@endsection