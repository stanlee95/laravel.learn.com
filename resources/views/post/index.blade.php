@extends('layouts.app')

@section('content')
<div class="container" align="center">
    <h1>Karunya University. Log Attendance System</h1>
</div>
@if (Auth::guest())
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Login</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">
                        {!! csrf_field() !!}

                        <div class="form-group{{ $errors->has('card_id') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">ID-Number</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="card_id" value="{{ old('card_id') }}">

                                @if ($errors->has('card_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('card_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">ID-Password</label>

                            <div class="col-md-6">
                                <input type="password" class="form-control" name="password">

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember"> Remember Me
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-sign-in"></i>Login
                                </button>

                                <a class="btn btn-link" href="{{ url('/password/reset') }}">Forgot Your Password?</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@else
<form method="post" action="/" enctype="multipart/form-data">
    <div class="container" style="width: 500px;">
        {!! csrf_field() !!}
        <h3 align="center" style="color: red">{{ session('status') }}</h3>
        <h3 class="form-signin-heading">
            Ask question, "{{ Auth::user()->card_id }}"
        </h3>

        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach

        </ul>

        <input type="text" class="form-control" name="title" placeholder="Insert Project Name">
        <br>
        <p><b>Insert your Question:</b></p>
        <div>
            <textarea name="content_full" id="content" rows="10" cols="65" required autofocus> </textarea>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="input-group">
                         <span class="input-group-addon">
                             <input type="hidden" name="published" value="0">
                            <input type="checkbox" name="published" value="1" checked>
                         </span>
                    <input type="text" class="form-control" value="Published?" disabled>
                    <br>
                </div>
            </div>

            <ul class="menu">
                <input type="hidden" id="cat_id" name="category_id" value="">
                <input type="hidden" id="cat_id_parent" name="category_sub_id" value="">
                <hr>
                <div>
                    <b>Upload images:</b>
                    <input type="file" name="photo[]" accept="image/*,image/jpeg" multiple size="4"><br>
                </div>
                <div style="margin-left:250px; margin-top:-60px">
                    <b>Upload files:</b>
                    <input type="file" name="files[]" multiple size="4">
                </div
                <br>
                <button style="width: 150px; margin-left: 180px; margin-top: 50px"
                        class="btn btn-lg btn-primary btn-block" type="submit">Submit
                </button>
                <br>
        </div>
    </div>

</form>
@endif
@endsection
