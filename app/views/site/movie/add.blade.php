@extends('site.layouts.default')

@section('content')
<div class="page-header">
    <h3>
        {{ $title }}
        <div class="pull-right">
            <a class="btn btn-default btn-small btn-inverse close_popup" href="{{{ URL::to('/') }}}"><span class="glyphicon glyphicon-circle-arrow-left"></span> Back</a>
        </div>
    </h3>
</div>
<div class="col-md-12 main middleWrap">
    <div class="row">      
        <div class="row">
            <form class="form-horizontal" enctype="multipart/form-data" method="post">
                <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
                <div class="form-group">
                    <label for="inputName" class="control-label col-xs-2">Name</label>
                    <div class="col-xs-10">
                         <input type="hidden" class="form-control" id="inputUserID" name="user_id" value='{{ Auth::user()->id }}'>
                        <input type="text" class="form-control" id="inputName" name="name" placeholder="Name">
                        {{ $errors->first('name', '<span class="help-inline error-message">:message</span>') }}
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputImg" class="control-label col-xs-2">Image</label>
                    <div class="col-xs-10">
                        <input type="file" class="form-control" id="inputImg" name="image" placeholder="Image">

                    </div>
                </div>
                <div class="form-group">
                    <label for="inputReview" class="control-label col-xs-2">Review</label>
                    <div class="col-xs-10">
                        <textarea class="form-control" rows="15" name="review"></textarea>
                        {{ $errors->first('review', '<span class="help-inline error-message">:message</span>') }}
                    </div>
                </div>
               <div class="required form-group {{{ $errors->has('is_active') ? 'error' : '' }}}">
                    <label class="col-md-2 control-label" for="is_active">Active?</label>
                    <div class="col-md-10">
                        <select class="form-control" id="is_active" name="is_active" >
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-offset-2 col-xs-10">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@stop
