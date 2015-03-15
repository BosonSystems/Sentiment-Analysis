@extends('admin.layouts.modal')

@section('content')
<div class="col-md-12 main middleWrap">
    <div class="row">      
        <div class="row">
            <form class="form-horizontal" enctype="multipart/form-data" method="post">
                <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
                <div class="form-group">
                    <label for="inputName" class="control-label col-xs-2">Meaning</label>
                    <div class="col-xs-10">
                        <input type="text" class="form-control" id="inputName" name="meaning" placeholder="Meaning">
                        {{ $errors->first('meaning', '<span class="help-inline error-message">:message</span>') }}
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
