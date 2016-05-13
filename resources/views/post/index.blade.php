@extends('layouts.app')

@section('content')

    <form method="post" action="/" enctype="multipart/form-data">
        <div  class="container" style="width: 500px; margin-top: 5%">
            {!! csrf_field() !!}
                <h3 align="center" style="color: red">{{ session('status') }}</h3>
            <h2 class="form-signin-heading">
                @if (Auth::guest())
                    Insert message as "Guest"
                @else
                    Insert message as "{{ Auth::user()->name }}"
                @endif
            </h2>

            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach

            </ul>

            <label for="inputEmail" class="sr-only">Title</label>
            <input type="text" class="form-control" name="title" placeholder="Insert Title">
            <br>
            <div>
                <textarea name="content_full" rows="10" cols="65" required autofocus > </textarea>
            </div>
            <div  class="row">
                <div  class="col-lg-6">
                    <div class="input-group">
                         <span class="input-group-addon">
                             <input type="hidden" name="published" value="0">
                            <input type="checkbox" name="published" value="1" checked>
                         </span>
                        <input type="text" class="form-control" value="Published?" disabled>
                        <br>
                    </div><!-- /input-group -->
                </div><!-- /.col-lg-6 -->

                <ul class="menu">
                    <li><a href="" class="active">Select category<span class="fa fa-angle-down"></span></a>
                        <ul class="submenu">
                            @foreach($category as $item)
                                <li><a href="#" onmouseover="this.style.color='black'"
                                                              onclick="document.getElementById('cat_id').value ='{{$item->id}}'; this.style.color='red';">
                                        {{$item->name}}</a>

                                    {{Helpers::recursionSelect($sub_category, $item->id)}}
                                </li>
                            @endforeach
                        </ul>
                    </li>
                </ul>
                <input type="hidden" id ="cat_id" name="category_id" value="">
                <input type="hidden" id ="cat_id_parent" name="category_sub_id" value="">
                <hr>
                <div style="margin-left:20px">
                    @if (Auth::guest())
                        <br>
                        <b>Guest isn't ulpload images :(</b>
                    @else
                        <b>Upload images:</b>
                        <input type="file" name="photo[]" accept="image/*,image/jpeg" multiple size="4"><br>
                        <b>Upload files:</b>
                        <input type="file" name="files[]" multiple size="4">
                    @endif

                </div>
                <br>
                <button style="width: 150px; margin-left: 180px" class="btn btn-lg btn-primary btn-block" type="submit">Submit</button><br>
            </div>
        </div>

    </form>




    <h2 align="center">Messages</h2>
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


@endsection
