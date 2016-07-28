@extends('layouts.admin')

@section('content')

<form method="post" action="/" enctype="multipart/form-data">
    {!! csrf_field() !!}
    <div class="row">
        <div class="col-xs-8" style="margin-left: 150px">
            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true"
                 style="margin-left: 150px;color: black">
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingOne">
                        <h4 class="panel-title">
                            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne"
                               aria-expanded="true" aria-controls="collapseOne">
                                <b>Insert title</b>
                            </a>
                        </h4>
                    </div>
                    <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                        <div class="panel-body">
                            <input class="form-control" type="text" name="title" placeholder="Insert title" xx required>
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingTwo">
                        <h4 class="panel-title">
                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion"
                               href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                <b>Insert message</b>
                            </a>
                        </h4>
                    </div>
                    <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                        <div class="panel-body">
                            <textarea class="form-control" name="content_full" rows="3"></textarea>
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingThree">
                        <h4 class="panel-title">
                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion"
                               href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                <b>Select published or not</b>
                            </a>
                        </h4>
                    </div>
                    <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                        <div class="panel-body">
                            <div class="col-lg-6">
                                <div class="input-group">
                                 <span class="input-group-addon">
                                     <input type="hidden" name="published" value="0">
                                    <input type="checkbox" name="published" value="1" checked>
                                 </span>
                                    <input type="text" class="form-control" value="Published?" disabled>
                                    <br>
                                </div><!-- /input-group -->
                            </div><!-- /.col-lg-6 -->
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="headingFour">
                            <h4 class="panel-title">
                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion"
                                   href="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                    <b>Select user</b>
                                </a>
                            </h4>
                        </div>
                        <div id="collapseFour" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFour">
                            <div class="panel-body">
                                @foreach($users as $user)
                                <div class="input-group">
                                            <span class="input-group-addon">
                                                <input type="radio" name="name" value="{{$user->card_id}}">
                                            </span>
                                    <input type="text" class="form-control" value="{{$user->card_id}}" disabled>
                                    <br>
                                </div><!-- /input-group -->
                                @endforeach
                                <div class="input-group">
                                            <span class="input-group-addon">
                                                <input type="radio" name="name" value="Guest">
                                            </span>
                                    <input type="text" class="form-control" value="Guest" disabled>
                                    <br>
                                </div><!-- /input-group -->
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="headingFive">
                            <h4 class="panel-title">
                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion"
                                   href="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                    <b>Files</b>
                                </a>
                            </h4>
                        </div>
                        <div id="collapseFive" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                            <div class="panel-body">
                                <b>Upload images:</b>
                                <input class="form-control" type="file" name="photo[]" accept="image/*,image/jpeg" multiple
                                       size="4"><br>
                                <b>Upload files:</b>
                                <input class="form-control" type="file" name="files[]" multiple size="4">
                            </div>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="admin" value="1">

                <br>
                <button class="btn btn-lg btn-primary btn-block" type="submit">Submit</button>
                <br>
            </div>
        </div>
    </div>
</form>
@endsection