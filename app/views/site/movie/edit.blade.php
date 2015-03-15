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
        {{ Session::get('msg') }}
        <div class="row">
            <form class="form-horizontal" method="post" enctype="multipart/form-data">
                <!-- CSRF Token -->
                <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
                <!-- ./ csrf token -->
                <div class="form-group">
                    <label for="inputName" class="control-label col-xs-2">Name</label>
                    <div class="col-xs-10">
                        <input class="form-control" type="text" name="name" id="name" value="{{{ Input::old('name', $movie->name) }}}" />
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
                        <textarea class="form-control" rows="15" name="review">{{{ Input::old('name', $movie->review) }}}</textarea>
                         {{ $errors->first('review', '<span class="help-inline error-message">:message</span>') }}
                    </div>
                </div>
                <div class="required form-group {{{ $errors->has('is_active') ? 'error' : '' }}}">
                    <label class="col-md-2 control-label" for="is_active">Active?</label>
                    <div class="col-md-10">
                        <select class="form-control" id="is_active" name="is_active">
                            
                            <option value="1" {{$movie->is_active == 1?"selected='selected'":"" }}  >Active</option>
                            <option value="0" {{$movie->is_active == 0?"selected='selected'":"" }}  >Inactive</option>
                        </select>
                    </div>
                </div>
                
                <div class="form-group">
                    <div class="col-xs-offset-2 col-xs-10">
                        <input type="hidden" name="id" value="{{$movie->id}}">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@stop
