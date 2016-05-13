@extends('layouts.app')

    @section('content')
        <div style="margin-top: 100px;">
            @if($posts!=NULL)
                @foreach($posts as $post)
                    {{--------------------------------ParentPosts-------------------------------------------------------}}
                    <ul class="media-list">
                        <li class="media">
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


                                <div align="right">

                                    <button class="btn btn-primary" type="button">
                                        <a href="view/{{$post->id }}" style="color: white">View Post</a>
                                    </button>

                                    <button class="btn btn-primary" type="button">
                                        <a href="response/{{$post->id }}" style="color: white">Send Response</a>
                                    </button>

                                    @if (!Auth::guest())
                                        <button class="btn btn-primary" type="button">
                                            <a href="deleteById/{{$post->id }}" onclick="alert('Post Deleted!!!')" style="color: white">Delete message</a>
                                        </button>
                                    @endif
                                </div>


                                {{--------------------------------ChildrenPosts-------------------------------------------------------}}
                                {{Helpers::recursionComments($comments, $post->id)}}
                                {{-------------------------------------------------------------------------------------------------------}}
                            </div>

                        </li>

                    </ul>
                @endforeach
                @else
            <h2>Nothing to search</h2>
                @endif
        </div>
    @endsection