<?php
use Illuminate\Support\Facades\URL;

class Category extends Eloquent {
	public function words()
	{
		return $this->hasMany('Word');
	}
}