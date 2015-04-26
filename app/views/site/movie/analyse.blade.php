@extends('site.layouts.default')

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
            <a class="btn btn-default btn-small btn-inverse close_popup" href="{{{ URL::to('movie/'.$movie->id.'/view') }}}"><span class="glyphicon glyphicon-circle-arrow-left"></span> Back</a>
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
<!-- <div>
	<div class="textb">Total Word: {{ $total }}</div><br>
	<div class="textb">Total Word Found: {{ $totalFind }}</div><br>
	<div class="textb">Total Sentiment Word Found: {{ $totalSentFind }}</div><br>	
	<div class="textb">Total Negative Word Found: {{ $totalNagFind }}</div><br>	
	<div class="textb">Total New Word Found: {{ $totalNewWords }} <a class="btn btn-success btn-small btn-inverse" href="{{{ URL::to('admin/word/'.$movie->id.'/newwords') }}}"><span class="glyphicon glyphicon-plus-sign"></span> Add New Words</a></div><br>	
</div> -->
<div>
	@if(!empty($sentimentCategories))
		
		<h3>Sentiment Percentage</h3>
		<?php 
			$total_percent = 0;
			$mixed = "";
			$count = count($sentimentCategories);
			
			$i = 1;
		?>
		@foreach($sentimentCategories as $category)
			<div>
				<?php 

					$percent = $category['count']/$totalFind;
					$total_percent = $total_percent + $percent;
					$percent_friendly = number_format( $percent * 100, 2 ) . '%';
					//echo $percent_friendly.' ';
					
					if($count <= $i) 
					{
						$mixed =$mixed. ' and '.$percent_friendly.' '.$category['name'];
					}
					else
					{
						if($mixed != "")
						{
							$mixed = $mixed. ', '.$percent_friendly.' '.$category['name'];	
						}
						else
						{
							$mixed = $percent_friendly.' '.$category['name'];
						}
						
					}
				?>
				<span class="sentiment" style="padding: 0px 9px;background:<?php echo '#'.$category['color']; ?>"></span>
				<?php
					echo $percent_friendly.' '.$category['name'];

					$i++;
				?> 
			</div>

		@endforeach
		
				<!-- {{number_format( $total_percent * 100, 2 ) . '%'}} Good Sentiment mixed with {{$mixed}} -->
	@endif
	<br>
	<span class="negative" style="padding: 0px 9px;"></span>			
		<?php  
					
					$percent = $totalNagFind/$totalFind;
					$percent_friendly = number_format( $percent * 100, 2 ) . '%';
					echo $percent_friendly.' '; 
				?> Negative Sentiment 
</div>
<br><br>
{{$text}}
</p>
@stop
