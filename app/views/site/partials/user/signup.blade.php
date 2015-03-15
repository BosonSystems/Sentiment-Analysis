<form method="POST" action="{{{ URL::to('user') }}}" accept-charset="UTF-8">
    <input type="hidden" name="_token" value="{{{ Session::getToken() }}}">
    <fieldset>
        <div class="form-group">
            <label for="first_name">{{{ Lang::get('confide::confide.first_name') }}}</label>
            <input class="form-control" placeholder="{{{ Lang::get('confide::confide.first_name') }}}" type="text" name="first_name" id="first_name" value="{{{ Input::old('first_name') }}}">
            {{ $errors->first('first_name', '<span class="help-inline error-message">:message</span>') }}
        </div>
        <div class="form-group">
            <label for="last_name">{{{ Lang::get('confide::confide.last_name') }}}</label>
            <input class="form-control" placeholder="{{{ Lang::get('confide::confide.last_name') }}}" type="text" name="last_name" id="last_name" value="{{{ Input::old('last_name') }}}">
            {{ $errors->first('last_name', '<span class="help-inline error-message">:message</span>') }}
        </div>
        <div class="form-group">
            <label for="username">{{{ Lang::get('confide::confide.username') }}}</label>
            <input class="form-control" placeholder="{{{ Lang::get('confide::confide.username') }}}" type="text" name="username" id="username" value="{{{ Input::old('username') }}}">
            {{ $errors->first('username', '<span class="help-inline error-message">:message</span>') }}           
        </div>
        <div class="form-group">
            <label for="email">{{{ Lang::get('confide::confide.e_mail') }}} <small>{{ Lang::get('confide::confide.signup.confirmation_required') }}</small></label>
            <input class="form-control" placeholder="{{{ Lang::get('confide::confide.e_mail') }}}" type="text" name="email" id="email" value="{{{ Input::old('email') }}}">
            {{ $errors->first('email', '<span class="help-inline error-message">:message</span>') }}
        </div>
        <div class="form-group">
            <label for="password">{{{ Lang::get('confide::confide.password') }}}</label>
            <input class="form-control" placeholder="{{{ Lang::get('confide::confide.password') }}}" type="password" name="password" id="password">
            {{ $errors->first('password', '<span class="help-inline error-message">:message</span>') }}
        </div>
        <div class="form-group">
            <label for="password_confirmation">{{{ Lang::get('confide::confide.password_confirmation') }}}</label>
            <input class="form-control" placeholder="{{{ Lang::get('confide::confide.password_confirmation') }}}" type="password" name="password_confirmation" id="password_confirmation">
            {{ $errors->first('password_confirmation', '<span class="help-inline error-message">:message</span>') }}
        </div>

        @if (Session::get('error'))
            <div class="alert alert-error alert-danger">
                @if (is_array(Session::get('error')))
                    {{ head(Session::get('error')) }}
                @endif
            </div>
        @endif

        @if (Session::get('notice'))
            <div class="alert">{{ Session::get('notice') }}</div>
        @endif

        <div class="form-actions form-group">
          <button type="submit" class="btn btn-primary">{{{ Lang::get('confide::confide.signup.submit') }}}</button>
        </div>

    </fieldset>
</form>
