@extends('layouts.admin')

    @section('content')

                        <table class="table table-bordered table-hover" style="margin: 50px; width: 800px" >
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Avatar</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?
                            foreach($users as $item){?>

                            <tr>
                                <td><p>{{$item->id}}</p></td>
                                <td><p>{{ucfirst($item->name)}}</p></td>
                                <td><p>{{$item->email}}</p></td>
                                <td><p>{{ucfirst($item->role)}}</p></td>
                                <td>
                                    @if($item->avatar ==NULL)
                                        <p>No Avatar!</p>
                                        @else
                                            <img src="/{{$item->avatar}}"  width="120px" height="120px">
                                    @endif

                                </td>
                            </tr>

                            <?}?>
                            </tbody>
                        </table>

    @endsection