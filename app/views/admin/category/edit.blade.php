@extends('admin.layouts.modal')
@section('content')
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
                        <input class="form-control" type="text" name="meaning" id="meaning" value="{{{ Input::old('meaning', $category->meaning) }}}" />
                        {{ $errors->first('meaning', '<span class="help-inline error-message">:message</span>') }}
                    </div>
                </div>
                <div class="required form-group {{{ $errors->has('is_active') ? 'error' : '' }}}">
                    <label class="col-md-2 control-label" for="is_active">Active?</label>
                    <div class="col-md-10">
                        <select class="form-control" id="is_active" name="is_active">
                            
                            <option value="1" {{$category->is_active == 1?"selected='selected'":"" }}  >Active</option>
                            <option value="0" {{$category->is_active == 0?"selected='selected'":"" }}  >Inactive</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputName" class="control-label col-xs-2">Color</label>
                    <div class="col-xs-10">
                        <input type="text" class="form-control" id="inputColor" name="color" placeholder="Color" value="{{{ Input::old('color', $category->color) }}}">
                        {{ $errors->first('color', '<span class="help-inline error-message">:message</span>') }}
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-xs-offset-2 col-xs-10">
                        <input type="hidden" name="id" value="{{$category->id}}">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@stop
