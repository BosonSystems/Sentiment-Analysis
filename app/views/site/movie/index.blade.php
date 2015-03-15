@extends('site.layouts.default')

{{-- Content --}}
@section('content')
@if(Auth::user())
 	<div class="clearfix">
 		<a href="{{{ URL::to('movie/create') }}}" class="pull-right"><i class="glyphicon glyphicon-plus"></i> Add Movie</a>
 	</div>
@endif
@foreach ($movies as $movie)
<div class="row">
	<div class="col-md-8">
		
		<div class="row">
			<div class="col-md-8">
				<h4><strong><a href="{{{ $movie->url() }}}">{{ String::title($movie->name) }}</a></strong></h4>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6">
				<a href="{{{ $movie->url() }}}" class="thumbnail"><img src="{{ './img/'.$movie->image }}" alt=""></a>
			</div>
			<div class="col-md-6">
				<p>
					{{ String::tidy(Str::limit($movie->review, 200)) }}
				</p>
				<p>
					<a class="btn btn-mini btn-default" href="{{{ $movie->url() }}}">Read more</a>
					@if(Auth::user())
						@if(Auth::user()->id == $movie->user_id)
							<a class="btn btn-mini btn-success" href="{{{ URL::to('movie/'.$movie->id.'/edit') }}}">Edit</a>
						@endif
					@endif
				</p>
			</div>
		</div>
		
		<div class="row">
			<div class="col-md-8">
				<p></p>
				<p>
					<span class="glyphicon glyphicon-user"></span> by <span class="muted">{{{ $movie->author->username }}}</span>
					| <span class="glyphicon glyphicon-calendar"></span> <!--Sept 16th, 2012-->{{{ $movie->date() }}}
					
				</p>
			</div>
		</div>
	</div>
</div>

<hr />
@endforeach

{{ $movies->links() }}

@stop
