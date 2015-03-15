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
                    <label for="inputName" class="control-label col-xs-2">Word</label>
                    <div class="col-xs-10">
                        <input type="text" class="form-control" id="inputName" name="word" placeholder="Word"  value="{{{ Input::old('word', $word->word) }}}" >
                        {{ $errors->first('word', '<span class="help-inline error-message">:message</span>') }}
                    </div>
                </div>
                @if($type == 1)
                <div class="form-group">
                    <label for="inputImg" class="control-label col-xs-2">Sentiment Category</label>
                    <div class="col-xs-10">
                       <select class="form-control" name="category_id" id="category_id">
                            
                                 @foreach ($categories as $category)
                                    <option value="{{{ $category->id }}}" {{{ ( $category->id == Input::old('category_id', $word->category_id) ? ' selected="selected"' : '') }}} >{{{ $category->meaning }}}</option>
                                @endforeach
                        </select>
                    </div>
                </div>
                @endif
                <div class="form-group">
                    <div class="col-xs-offset-2 col-xs-10">
                        <input type="hidden" name="id" value="{{$word->id}}">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@stop
