<?php

class MovieController extends BaseController {

    /**
     * Post Model
     * @var Post
     */
    protected $movie;

    /**
     * User Model
     * @var User
     */
  
    public function __construct(Movie $movie)
    {
        parent::__construct();

        $this->movie = $movie;        
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
        return View::make('user/movie/add', compact('title'));
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
            return Redirect::to('movie/' . $this->movie->id . '/edit')->with('success',"Movie added");
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
        return View::make('movie/edit', compact('movie', 'title'));
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
            return Redirect::to('movie/' . $movie->id . '/edit')->with('success',"Movie updated");
        }
        else
        {
          
            return Redirect::to('movie/create')
                ->withErrors($validator);
        }
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
        if(!empty($words))
        {
            foreach ($words as $word) {
                 $findWord = $this->word->where('word',$word)->first(); 
                 if(!empty($findWord))
                 {
                    if($findWord->word_type_id == 2)
                    {
                        $nagativeWords[] = $findWord->word;
                        $totalFind++;
                    }
                    elseif($findWord->word_type_id == 1)
                    {
                        $sentimentWords[] = $findWord->word;
                        $sentimentCategories[$findWord->category_id]['count'] = $sentimentCategories[$findWord->category_id]['count'] + 1; 
                        $totalFind++;
                    }
                 }
            }
        }

        $totalSentFind = count($sentimentWords);
        $totalNagFind = count($nagativeWords);
        $totalNewWords = $total - $totalFind;      
        return View::make('site/movie/analyse', compact('movie', 'title','sentimentCategories','totalFind','totalSentFind','totalNagFind','totalNewWords','total'));
    }
}
