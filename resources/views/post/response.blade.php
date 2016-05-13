@extends('layouts.app')

@section('content')
    <form method="post" action="/response-post" enctype="multipart/form-data">
            {!! csrf_field() !!}
        <hr>
        <div class="media-list">
            <li class="media">
                <div class="media-left">
                    @if(isset($post->photo))
                        <img class="media-object" src="/{{$post->photo}}" style="width:120px; height: 120px">
                    @else
                        <img class="media-object" src="/uploads/user_image/no_avatar.jpg" style="width:120px; height: 120px">
                    @endif
                </div>
                <div class="media-body">
                    <h4 class="media-heading">{{ $post->title }}</h4>
                    <h4 class="media-heading">{{ $post->user_name }}</h4>
                    <b><p>{{ $post->content }}</p></b>
                    <div class="panel-heading">{{$post->published_at}}</div>

                    </div>
                </div>
            </ul>
        <hr>
        <div class="container" style="margin-left: 400px">
            <h3 align="center" style="color: red" >{{ session('status') }}</h3>
            <h2 class="form-signin-heading">
                @if (Auth::guest())
                    Insert message as "Guest"
                @else
                    Send response as "{{ Auth::user()->name }}"
                @endif
            </h2>
                <div>
                   <input type="hidden" name="parent_id" value="{{$post->id}}">
                </div>
            <br>
                <div>
                    <textarea name="content_full" rows="10" cols="65" required autofocus > </textarea>
                </div>
                <div  class="row">
                    <div  class="col-lg-6">
                        <button style="width: 150px; margin-left: 180px" class="btn btn-lg btn-primary btn-block" type="submit">Submit</button><br>
                    </div><!-- /.col-lg-6 -->
                </div>
        </div>
    </form>

@endsection