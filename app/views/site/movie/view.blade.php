@extends('site.layouts.default')

{{-- Web site Title --}}
@section('title')
{{{ String::title($movie->name) }}} ::
@parent
@stop


{{-- Content --}}
@section('content')
<div class="page-header">
    <h3>
        {{ $title }}
        <div class="pull-right">
        	<a class="btn btn-default btn-small btn-primary" href="{{{ URL::to('movie/'.$movie->id.'/analyse') }}}"><span class="glyphicon glyphicon-eye-open"></span> Analyses the Sentiment</a>            <a class="btn btn-default btn-small btn-inverse close_popup" href="{{{ URL::to('/') }}}"><span class="glyphicon glyphicon-circle-arrow-left"></span> Back</a>
        </div>
    </h3>
</div>
<p>
<img src="{{ '../../img/'.$movie->image }}" alt="" class="pull-left" style="padding: 0px 10px;">
<span>
	{{ $movie->content() }}
</span>
</p>

<div>
	<span class="badge badge-info">Created {{{ $movie->date() }}}</span>
</div>
@stop
