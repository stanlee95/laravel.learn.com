@extends('layouts.app')
<style>


    .block1 {
        width: 70em;
        /*background: #ccc;*/
        padding: 50px;
        padding-left: 450px;
        border: none;
        float: center;
        word-wrap: break-word;
    }

</style>
@section('content')
    <h2 align="center">Posts</h2>
    @foreach($posts as $post)
        <div  class="panel panel-default">
            <!-- Default panel contents -->
            <div class="panel-heading"><b>Title:</b> {{ $post->title }}</div>
            <div class="panel-heading"><b>User:</b> {{ $post->user_name }}</div>
            <div class ="panel-heading">
                @if(isset($post->photo))
                    <img class="media-object" src="/{{$post->photo}}" style="width:120px; height: 120px">
                @else
                    <img class="media-object" src="/uploads/user_image/no_avatar.jpg" style="width:120px; height: 120px">
                @endif
            </div>
            <div class="panel-body">
                <b><p>{{ $post->content }}</p></b>

                @foreach($post->photos as $item)

                    <img src="{{ $item->path}}" width="150px" height="150px">
                    @if (!Auth::guest())
                        <a href="/delete/{{ $item->name}}" onclick="alert('Image Deleted!!!')"><img src="/uploads/img/Rojo_18x18.png"></a>
                    @endif

                @endforeach
                <div align="right">

                    <button class="btn btn-primary" type="button">
                        <a href="/view/{{$post->id }}" style="color: white">View Post</a>
                    </button>

                    @if (!Auth::guest())
                        <button class="btn btn-primary" type="button">
                            <a href="/deleteById/{{$post->id }}" onclick="alert('Post Deleted!!!')" style="color: white">Delete message</a>
                        </button>
                    @endif
                </div>
            </div>
            <div class="panel-heading">{{$post->published_at}}</div>
        </div>
    @endforeach
@endsection