@extends('layouts.admin')

@section('content')
    <div class="container-admin-announcement" align="left">
        <form method="post" action="/admin-panel/update-announcement">
            {!! csrf_field() !!}
    @foreach($posts as $post)
        {{--------------------------------ParentPosts-------------------------------------------------------}}
        <ul class="media-list">
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
                    @foreach($post->photos as $item)

                        <img src="/{{ $item->path}}" width="150px" height="150px">
                        @if (!Auth::guest())
                            <a href="/delete/{{ $item->name}}" onclick="alert('Image Deleted!!!')"><img src="/uploads/img/Rojo_18x18.png"></a>
                        @endif

                    @endforeach

                    <div align="right">

                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bs-example-modal-lg">
                                    <a href="#" onclick="document.getElementById('id').value ='{{$post->id}}'" style="color: white">Update</a>
                        </button>

                        @if (!Auth::guest())
                            <button class="btn btn-primary" type="button">
                                <a href="/deleteById/{{$post->id }}" onclick="alert('Post Deleted!!!')" style="color: white">Delete message</a>
                            </button>
                        @endif
                    </div>


                    {{--------------------------------ChildrenPosts-------------------------------------------------------}}
                    {{Helpers::recursionComments($comments, $post->id)}}
                    {{-------------------------------------------------------------------------------------------------------}}
                </div>

            </li>
            <hr>
        </ul>
    @endforeach
        <a name="bottom"></a>
        <div class="center-block" style="width: 400px">

                <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content" style="color: black;">
                            <h2>Update</h2>
                            <input id="id" type="hidden" name="id">

                            <input type="text" class="form-control" name="title" placeholder="Insert New Title" required>
                            <br>
                            <div>
                                <h2>Insert content:</h2>
                                <textarea name="content_full" rows="10" cols="100" required autofocus ></textarea>
                            </div>
                            <div  class="col-lg-6">
                                <div class="input-group">
                         <span class="input-group-addon">
                             <input type="hidden" name="published" value="0">
                            <input type="checkbox" name="published" value="1" checked>
                         </span>
                            <input type="text" class="form-control" value="Published?" disabled>
                             <br>
                           </div><!-- /input-group -->
                                <input type="submit" class="btn-danger" value="Update">
                            </div>
                    </div>
                </div>
            </div>
            </div>
        </form>
    </div>
@endsection