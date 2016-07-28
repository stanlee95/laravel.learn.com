@extends('layouts.admin')

@section('content')
<form method="post" action="/admin-panel/update-announcement">
    {!! csrf_field() !!}
        <div class="row">
        <div class="col-xs-16">
            <h2 class="page-header">Projects</h2>
        </div>
        @foreach($projects as $project)
        <div class="media" align="left" style="margin-left: 180px">
            <div class="media-left" style="color: black">
                    <meta name="assign-csrf-token" content="{{ csrf_token() }}"/>
                    <select id="admin-assign-{{$project->project_id}}"
                            onchange="assignUser({{$project->project_id}}); return false">
                        @foreach($users as $user)
                        <option value="{{$user->id}}">
                            {{$user->card_id}}
                        </option>
                        @endforeach
                    </select>
            </div>
            <div class="media-body">
                <h3 class="media-heading"><b>{{ucfirst($project->title)}}</b></h3>
                <blockquote>
                    <p><span style="color: red;">ID:</span> {{ucfirst($project->project_id)}}</p>
                    <p><b>Description:</b> {{ucfirst($project->description)}}</p>
                    <p><span style="color: black;">Software Requirements:</span> {{$project->software_requirements}}</p>
                    <p><span>Recomended Literature:</span> {{$project->recomended_literature}}</p>
                    <footer><span style="color: red">{{$project->status}}</span> | <span
                            style="color: red">Assigment: </span> <span id="assigment-{{$project->project_id}}">
                            <b>{{$project->card_id}}</b></span>
                        <cite title="Source Title">
                            <p>Started At: {{$project->started_at}}</p>
                            <p>Finished At: {{$project->finished_at}}</p>
                            <p>Last Updatre: {{$project->updated_at}}</p>
                        </cite>
                    </footer>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bs-example-modal-lg">
                        <a href="#" onclick="getProjectById({{$project->project_id}})" style="color: white">Update</a>
                    </button>
                </blockquote>
            </div>
        </div>
        <hr>
        @endforeach
    </div>
</form>

<a name="bottom"></a>
<div class="center-block" style="width: 400px">
    <form method="post" action="/admin-panel/add-projects">
        {!! csrf_field() !!}
    <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" style="color: black;">
                <h2>Update</h2>
                <input id="id" type="hidden" name="id">

                <input type="text" class="form-control" name="title" placeholder="Insert New Title" required>
                <br>
                <input type="text" class="form-control" name="software" placeholder="Insert Software Requirements">
                <br>
                <input type="text" class="form-control" name="literature" placeholder="Insert Literature">
                <br>
                <div>
                    <h2>Insert Description:</h2>
                    <textarea name="content_full" rows="10" cols="100" required autofocus ></textarea>
                </div>
                <div  class="col-lg-6">
                    <input type="submit" class="btn-danger" value="Update">
                </div>
            </div>
        </div>
    </div>
</div>
</form>
</div>
@endsection