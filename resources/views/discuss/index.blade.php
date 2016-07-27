@extends('layouts.app')

@section('content')
<div class="container">
    <h3 align="center" style="color: red">{{ session('status') }}</h3>
        <h2 align="center">Discuss Room</h2>
    @foreach($posts as $post)

                <ul class="media-list">
                <li class="media" id="media">
                    <div class="media-left">
                        @if(isset($post->photo))
                            <img class="media-object" src="{{$post->photo}}" style="width:120px; height: 120px">
                        @else
                            <img class="media-object" src="uploads/user_image/no_avatar.jpg" style="width:120px; height: 120px">
                        @endif
                    </div>
                    <div class="media-body">
                        <h4 class="media-heading">{{ $post->title }}</h4>
                        <h4 class="media-heading">{{ $post->user_name }}</h4>
                        <b><p>{{ $post->content }}</p></b>
                        <div class="panel-heading">{{$post->published_at}}</div>
                        @foreach($post->photos as $item)

                            <img src="{{ $item->path}}" width="150px" height="150px">
                            @if (!Auth::guest())
                                <a href="delete/{{ $item->name}}" onclick="alert('Image Deleted!!!')"><img src="/uploads/img/Rojo_18x18.png"></a>
                            @endif

                        @endforeach

                        <div align="right">

                            <button class="btn btn-primary" type="button">
                                <a href="view/{{$post->id }}" style="color: white">View Post</a>
                            </button>

                            <button class="btn btn-primary" type="button">
                                <a href="response/{{$post->id }}" style="color: white">Send Response</a>
                            </button>

                            @if (!Auth::guest())
                                <button class="btn btn-primary" id="deletePost" type="button">
                                    <a href="#" onclick="ajaxDelete({{$post->id}}); return false;" style="color: white">Delete message</a>
                                </button>
                            @endif
                        </div>
                        {{Helpers::recursionComments($comments, $post->id)}}
                    </div>

                </li>

        </ul>
    @endforeach
    </div>
@endsection