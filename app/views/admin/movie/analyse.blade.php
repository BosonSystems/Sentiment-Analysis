@extends('admin.layouts.default')

{{-- Web site Title --}}
@section('title')
{{{ String::title($title) }}} ::
@parent
@stop


{{-- Content --}}
@section('content')
<div class="page-header">
    <h3>
        {{ $title }}
        <div class="pull-right">
            <a class="btn btn-default btn-small btn-inverse close_popup" href="{{{ URL::to('admin/movie/'.$movie->id.'/view') }}}"><span class="glyphicon glyphicon-circle-arrow-left"></span> Back</a>
        </div>
    </h3>
</div>
<p>
<!-- 
<img src="{{ '../../img/'.$movie->image }}" alt="" class="pull-left" style="padding: 0px 10px;">
<span>
	{{ $movie->content() }}
</span> 
-->
<div>
	<div class="textb">Total Word: {{ $total }}</div><br>
	<div class="textb">Total Word Found: {{ $totalFind }}</div><br>
	<div class="textb">Total Sentiment Word Found: {{ $totalSentFind }}</div><br>	
	<div class="textb">Total Negative Word Found: {{ $totalNagFind }}</div><br>	
	<div class="textb">Total New Word Found: {{ $totalNewWords }} <a class="btn btn-success btn-small btn-inverse" href="{{{ URL::to('admin/word/'.$movie->id.'/newwords') }}}"><span class="glyphicon glyphicon-plus-sign"></span> Add New Words</a></div><br>	
</div>
<div>
	@if(!empty($sentimentCategories))
		<h3>Sentiment Percentage</h3>
		@foreach($sentimentCategories as $category)
			<div>
				<?php  
					
					$percent = $category['count']/$totalFind;
					$percent_friendly = number_format( $percent * 100, 2 ) . '%';
					echo $percent_friendly.' '; 
				?> {{ $category['name'] }} Sentiment 
			</div>
		@endforeach
	@endif
				<?php  
					
					$percent = $totalNagFind/$totalFind;
					$percent_friendly = number_format( $percent * 100, 2 ) . '%';
					echo $percent_friendly.' '; 
				?> Negative Sentiment 
</div>
</p>
@stop
