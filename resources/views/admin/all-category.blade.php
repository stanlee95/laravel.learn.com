@extends('layouts.admin')

@section('content')
    <form class="form-horizontal" role="form" method="POST" action="add-category">
    {!! csrf_field() !!}

        <ul class="list-group" style="color: black; width:500px;">
            @foreach ($category as $item)
            <li class="list-group-item active"><b>ID:</b> {{$item->id}} <br> <b>Name:</b> {{$item->name}};
                <b>Published:</b>{{$item->published}}; <b>Created:</b>{{$item->created_at}};</li>
            <li class="list-group-item"><p><a class="sta" href = "/admin-panel/delete-category/{{$item->id}}"><button type="button" class="btn btn-xs btn-default">Delete</button></a>
                    {{--<a class="del" href = "#"><button type="button" class="btn btn-xs btn-default">Edit</button></a></p>--}}
                <a href="#id" onclick="document.getElementById('parent_id').value ='{{$item->id}}'"><button type="button"
                                                                                                          class="btn btn-xs btn-default">CreateSubCategory</button> </a>
                </li>
                <li class="list-group-item">
                    {{Helpers::recursionAllCategory($sub_category, $item->id)}}
                </li>

            @endforeach

        </ul>
        <a name="id"></a>
        <ul class="list-group" style="color: black; width:500px;">
            <h2>New category</h2>
            <li class="list-group-item">
                <b>ID:</b><input type="text" value="{{$item->id+1}}" disabled>
                <input type="hidden" name="id" value="{{$item->id+1}}">
                <b>Parent ID:</b><input id="parent_id" type="number" min ="0"; name="parent_id"  value="0">
               <b>Name:</b><input type="text" name="name" placeholder="Insert name" required>
                <div class="input-group" style="width: 200px">
                         <span class="input-group-addon">
                             <input type="hidden" name="published" value="0">
                             <input type="checkbox" name="published" value="1" checked>
                         </span>
                    <input type="text" class="form-control" value="Published?" disabled>
                    <br>
                </div><!-- /input-group -->

            </li>

        </ul>

            <div style="width:200px;" class="tas">
                <button class="btn btn-lg btn-primary btn-block" type="submit">Create</button>
            </div>
    </form>
@endsection