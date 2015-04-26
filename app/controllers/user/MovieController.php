<?php

class MovieController extends BaseController {

    /**
     * Post Model
     * @var Post
     */
    protected $movie;
    protected $word;

    /**
     * User Model
     * @var User
     */
  
    public function __construct(Movie $movie,Word $word)
    {
        parent::__construct();

        $this->movie = $movie; 
        $this->word = $word;       
    }
    
	/**
	 * Returns all the blog posts.
	 *
	 * @return View
	 */
	public function getIndex()
	{
		// Get all the blog posts
		$movies = $this->movie->orderBy('created_at', 'DESC')->paginate(10);

		// Show the page
		return View::make('site/movie/index', compact('movies'));
	}
	 public function getCreate()
    {
        $title = "Add Movie";

        // Mode
        $mode = 'create';

        // Show the page
        return View::make('site/movie/add', compact('title'));
    }
    
    public function postCreate()
    {

        $rules = array(
            'name' => 'required',            
            'review' => 'required|min:250',
            'is_active' => 'required',
        );
        $messages = array(
            'required' => 'Required',
        );
       
        $validator = Validator::make(Input::all(), $rules,$messages);
        // Check if the form validates with success
        if ($validator->passes())
        {
            $inputs = Input::except('csrf_token');
            $this->movie->name = $inputs['name'];
            $this->movie->review = $inputs['review'];
            $this->movie->is_active = $inputs['is_active'];
            $this->movie->user_id = $inputs['user_id'];
            $this->movie->save();
            if ($this->movie->id)
            {
                 if (Input::hasFile('image')) {
                    $file            = Input::file('image');
                    $destinationPath = public_path().'/img/';
                    $filename        = $this->movie->randomPrefix() . '.' . $file->getClientOriginalExtension();
                    $uploadSuccess   = $file->move($destinationPath, $filename);
                    $this->movie->resizeImage($destinationPath.$filename);
                    $this->movie->image =$filename;
                    $this->movie->save();
                }
            }
            return Redirect::to('/')->with('success',"Movie added");
            //return Redirect::to('movie/' . $this->movie->id . '/edit')->with('success',"Movie added");
        }
        else
        {
          
            return Redirect::to('movie/create')
                ->withErrors($validator);
        }
    }

    public function getEdit($movie)
    {

        $title = "Update Movie";
        return View::make('site/movie/edit', compact('movie', 'title'));
    }
    public function postEdit($movie)
    {
        $rules = array(
            'name' => 'required',            
            'review' => 'required|min:250',
            'is_active' => 'required',
        );
        $messages = array(
            'required' => 'Required',
        );
       
        $validator = Validator::make(Input::all(), $rules,$messages);
        // Check if the form validates with success
        if ($validator->passes())
        {
            $inputs = Input::except('csrf_token');
            $movie->name = $inputs['name'];
            $movie->review = $inputs['review'];
            $movie->is_active = $inputs['is_active'];
            $movie->save();
            if ($movie->id)
            {
                 if (Input::hasFile('image')) {
                    $file            = Input::file('image');
                    $destinationPath = public_path().'/img/';
                    $filename        = $movie->randomPrefix() . '.' . $file->getClientOriginalExtension();
                    $uploadSuccess   = $file->move($destinationPath, $filename);
                    $movie->resizeImage($destinationPath.$filename);
                    $movie->image =$filename;
                    $movie->save();
                }
            }
            return Redirect::to('/')->with('success',"Movie updated");
        }
        else
        {
          
            return Redirect::to('movie/create')
                ->withErrors($validator);
        }
    }
    public function getView($movie)
    {
    	$title = $movie->name;
    	return View::make('site/movie/view', compact('movie','title'));
    }
    public function getAnalyse($movie)
    {
        $title = "Result - ".$movie->name;
        $words = $movie->mb_str_word_count($movie->review,2); 
        $categories = DB::table('categories')->select('id','meaning')->get();
        $sentimentCategories = array();
        if(!empty($categories))
        {
            foreach ($categories as $category) {
                $sentimentCategories[$category->id]['name'] = $category->meaning;
                $sentimentCategories[$category->id]['count'] = 0;
            }
        }        
        $findWord = array();
        $nagativeWords = array();
        $sentimentWords = array();    
        $total = count($words);  
        $totalFind = 0;
        $totalNagFind = 0; 
        $totalSentFind = 0;
        $text = $movie->review; 
        if(!empty($words))
        {
            
            foreach ($words as $word) {
                 //$findWord = $this->word->where('word',$word)->first(); 
                  $findWord = $this->word->where('word','like',$word.'%')->first(); 
                 if(!empty($findWord))
                 {
                  
                    if($findWord->word_type_id == 2)
                    {
                        $text = $this->highlight( $text,$findWord->word,"style='background:#f68686'");
                        $nagativeWords[] = $findWord->word;
                        $totalFind++;
                    }
                    elseif($findWord->word_type_id == 1)
                    {
                        //print_r($findWord->category);
                        $text = $this->highlight($text,$findWord->word,"style='background:#".$findWord->category->color."'");
                        $sentimentWords[] = $findWord->word;
                        $sentimentCategories[$findWord->category_id]['count'] = $sentimentCategories[$findWord->category_id]['count'] + 1;
                        $sentimentCategories[$findWord->category_id]['color'] =  $findWord->category->color;
                        $totalFind++;
                    }
                 }
            }
        }
       // exit;
       

        $totalSentFind = count($sentimentWords);
        $totalNagFind = count($nagativeWords);
        $totalNewWords = $total - $totalFind;      
        return View::make('site/movie/analyse', compact('movie','text', 'title','sentimentCategories','totalFind','totalSentFind','totalNagFind','totalNewWords','total','sentimentWords','nagativeWords'));
    }
    function highlight($text='', $word='',$highlightClass = 'sentiment')
    {
      if(strlen($text) > 0 && strlen($word) > 0)
      {
        return (str_ireplace($word, "<span class='highlight' ".$highlightClass."'>{$word}</span>", $text));
      }
       return ($text);
    }

}
