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

    <form method="post" action="/uploadMoreFiles/{{$posts->id}}" enctype="multipart/form-data">
        {!! csrf_field() !!}
    <h3 align="center" style="color: red">{{ session('status') }}</h3>
    <header class="jumbotron hero-spacer" align="center">
        <h1>{{ $posts->title }}</h1>
        <div class="block1">
            <p>{{ $posts->content }}</p>
        </div>

        <p>{{$posts->published_at}}</p>
            @if (!Auth::guest())
            <p><a href="/deleteById/{{$posts->id }}" class="btn btn-primary btn-large">Delete?</a>
                @endif

        @foreach($posts->photos as $item)

            <div class="row text-center">

                <div class="col-md-3 col-sm-6 hero-feature">
                    <div class="thumbnail">
                        <img src="/{{ $item->path}}" width="150px" height="150px" alt="">
                        <div class="caption">
                            <h3>Feature Label</h3>
                    <p>@if (!Auth::guest())
                        <a href="/delete/{{ $item->name}}" class="btn btn-primary">Delete!</a> @endif <a href="/{{ $item->path}}" target="_blank" class="btn btn-default">Show Full</a>
                    </p>

                     </div>
                </div>

        </div>
        @endforeach

</header>
        <div class="col-lg-3" style="margin-top: -30px">
            <h3>Attachments:</h3>
            @foreach($posts->files as $item)
                <ul class="list-unstyled">
                    <li><a href="/{{$item->path}}" target="_blank">Name: {{$item->name}}</a>
                        @if (!Auth::guest())
                            <a href="/deleteFile/{{ $item->name}}" onclick="alert('File Deleted!!!')"><img src="/uploads/img/4829-18x18x4.png"></a>
                        @endif
                    </li>
                </ul>
            @endforeach
        </div>
        <div style="margin-left:20px">
            @if (Auth::guest())
                <b>Guest isn't ulpload images :(</b>
            @else
                <b>Upload more images:</b>
                <input type="file" name="photo[]" accept="image/*,image/jpeg" multiple size="4"><br>
                <b>Upload more files:</b>
                <input type="file" name="files[]" multiple size="4">
            @endif

        </div>
        <button style="width: 150px; margin-left:30px;margin-top:30px" class="btn btn-lg btn-primary btn-block" type="submit">Upload</button><br>
</form>


@endsection