@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Register</div>
                    <div class="panel-body">
                        <form class="form-horizontal" method="post" action="/email-save" enctype="multipart/form-data">
                        {!! csrf_field() !!}
                            <div>
                                 <label class="col-md-4 control-label">{{$user->name}},for finished registration insert your E-mail</label>
                            </div>
                            <br>
                            <div class="col-md-6">
                                <input type="email" class="form-control" name="email" placeholder="E-mail" required>
                                <input type="hidden" class="form-control" name="name" value="{{$user->name}}">
                                @if($social_name == 'facebook_id')
                                <input type="hidden" class="form-control" name="facebook_id" value="{{$user->id}}">
                                    <input type="hidden" class="form-control" name="odno_id" value="0">
                                    @elseif($social_name=='odno_id')
                                    <input type="hidden" class="form-control" name="odno_id" value="{{$user->id}}">
                                    <input type="hidden" class="form-control" name="facebook_id" value="0">
                                @endif
                                <input type="hidden" class="form-control" name="avatar" value="{{$user->avatar}}">
                            </div>
                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-btn fa-user"></i>Register
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                 </div>
             </div>
            </div>
         </div>
@endsection