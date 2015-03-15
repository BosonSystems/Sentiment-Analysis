<?php
use Illuminate\Support\Facades\URL;

class Movie extends Eloquent {

    protected $table = 'movie';

    function randomPrefix() 
	{ 	
		$result = '';
		 $valLength =5;
		$moduleLength = 40;   // we use sha1, so module is 40 chars
		$steps = round(($valLength/$moduleLength) + 0.5);

		for( $i=0; $i<$steps; $i++ ) {
			$result .= sha1( uniqid() . md5( rand() . uniqid() ) );
		}

		return substr( $result, 0, $valLength );
		
	}
	function resizeImage($filename, $max_width =400, $max_height =400)
	{
		list($orig_width, $orig_height) = getimagesize($filename);

		$width = $orig_width;
		$height = $orig_height;

		# taller
		if ($height > $max_height) {
			$width = ($max_height / $height) * $width;
			$height = $max_height;
		}

		# wider
		if ($width > $max_width) {
			$height = ($max_width / $width) * $height;
			$width = $max_width;
		}

		$thumb = imagecreatetruecolor($width, $height);
		imagesavealpha($thumb, true);
		$color = imagecolorallocatealpha($thumb, 0, 0, 0, 127);
		imagefill($thumb, 0, 0, $color);
		if(preg_match("/.jpg/i", $filename)){
		$source = imagecreatefromjpeg($filename);
		}
		if(preg_match("/.jpeg/i", $filename)){
		$source = imagecreatefromjpeg($filename);
		}
		if(preg_match("/.jpeg/i", $filename)){
		$source = Imagecreatefromjpeg($filename);
		}
		if(preg_match("/.png/i", $filename)){
		$source = imagecreatefrompng($filename);
		}
		if(preg_match("/.gif/i", $filename)){
		$source = imagecreatefromgif($filename);
		}
		
		//$image = imagecreatefromjpeg($filename);

		imagecopyresampled($thumb, $source, 0, 0, 0, 0, 
										 $width, $height, $orig_width, $orig_height);
		if(preg_match("/.jpg/i", $filename)){
		return imagejpeg($thumb,$filename);
		}
		if(preg_match("/.jpeg/i", $filename)){
		return imagejpeg($thumb,$filename);
		}
		if(preg_match("/.jpeg/i", $filename)){
		return imagejpeg($thumb,$filename);
		}
		if(preg_match("/.png/i", $filename)){
		return imagepng($thumb,$filename);
		}
		if(preg_match("/.gif/i", $filename)){
		return imagegif($thumb,$filename);
		}
		//imagejpeg($thumb,$filename);
	}
	public function url()
	{
		return Url::to('movie/'.$this->id.'/view');
	}
	public function author()
	{
		return $this->belongsTo('User', 'user_id');
	}
	public function content()
	{
		return nl2br($this->review);
	}
	 public function date($date=null)
    {
        if(is_null($date)) {
            $date = $this->created_at;
        }

        return String::date($date);
    }
    public function created_at()
	{
		return $this->date($this->created_at);
	}
	public function updated_at()
	{
        return $this->date($this->updated_at);
	}

	function mb_str_word_count($string, $format = 0, $charlist = '[]') {
        mb_internal_encoding( 'UTF-8');
        mb_regex_encoding( 'UTF-8');

        //$strlen = mb_strlen($string);
        
        //$words = mb_split('[^\x{0600}-\x{06FF}]', $string);
       
        //$words = preg_split('//u', $string, -1, PREG_SPLIT_NO_EMPTY);
        //$pattern = "#(?:[\x{0600}-\x{06FF}]+(?:\s+[\x{0600}-\x{06FF}]+)*)#u";
        //$pattern = "//u";
        //$words = mb_split($pattern, $string);

        //User to getting latters
        //preg_match_all('/\pL\pM*|./u', $string, $words); 

        //Get words in from string.
        $string = mb_ereg_replace('[,.\'-()*]',' ',$string);
        $words = array_filter(mb_split(' ', $string));
       
        switch ($format) {
            case 0:
                return count($words);
                break;
            case 1:
            case 2:     
                return $words;
                break;
            default:
                return $words;
                break;
        }
    }

    function mb_str_para_count($string, $format = 0, $charlist = '[]') {
        mb_internal_encoding( 'UTF-8');
        mb_regex_encoding( 'UTF-8');

        $words = mb_split('[^\x{0600}-\x{06FF}]', $string);
        switch ($format) {
            case 0:
                return count($words);
                break;
            case 1:
            case 2:
                return $words;
                break;
            default:
                return $words;
                break;
        }
    }

    function mb_str_sent_count($string, $format = 0, $charlist = '[]') {
        mb_internal_encoding( 'UTF-8');
        mb_regex_encoding( 'UTF-8');

        $words = mb_split('[^\x{0600}-\x{06FF}]', $string);
        switch ($format) {
            case 0:
                return count($words);
                break;
            case 1:
            case 2:
                return $words;
                break;
            default:
                return $words;
                break;
        }
    }
}