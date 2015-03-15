<?php
use Illuminate\Support\Facades\URL;

class WordTypes extends Eloquent {
	
   public function words()
	{
		return $this->hasMany('Word');
	}
}