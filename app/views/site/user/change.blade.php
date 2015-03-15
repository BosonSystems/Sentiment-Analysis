@extends('site.layouts.default')

{{-- Web site Title --}}
@section('title')
	{{{ $title }}} :: @parent
@parent
@stop

{{-- Content --}}
@section('content')
<div class="page-header">
	<h1>{{{ $title }}} </h1>
</div>
	<form class="form-horizontal" method="post" action="{{ URL::to('user/' . $user->id . '/change') }}" autocomplete="off" enctype="multipart/form-data">
		<!-- CSRF Token -->
		<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
		
				<div class="required form-group {{{ $errors->has('password') ? 'error' : '' }}}">
					<label class="col-md-2 control-label" for="password">New Password</label>
                    <div class="col-md-10">
    					<input class="form-control" type="password" name="password" id="password" value="{{{ Input::old('password') }}}" />
    					{{ $errors->first('password', '<span class="help-inline error-message">:message</span>') }}
                    </div>
				</div>
				<div class="required form-group {{{ $errors->has('password_confirmation') ? 'error' : '' }}}">
					<label class="col-md-2 control-label" for="password_confirmation">Password Confirm</label>
                    <div class="col-md-10">
    					<input class="form-control" type="password" name="password_confirmation" id="password_confirmation" value="{{{ Input::old('password_confirmation') }}}" />
    					{{ $errors->first('password_confirmation', '<span class="help-inline error-message">:message</span>') }}
                    </div>
				</div>
				<div class="form-group">
				  <div class="col-md-offset-2 col-md-10">
					<button type="submit" class="btn btn-success">Submit</button>
				</div>
		</div>
	</form>
@stop
