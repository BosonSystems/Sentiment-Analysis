<?php
use Illuminate\Support\Facades\URL;

class Word extends Eloquent {
   
   public function comments()
	{
		return $this->hasMany('Comment');
	}
	public function wordtype()
	{
		return $this->belongsTo('WordTypes', 'word_type_id');
	}
	public function category()
	{
		return $this->belongsTo('Category', 'category_id');
	}
	public function delete()
	{
		
		// Delete the blog post
		return parent::delete();
	}
}