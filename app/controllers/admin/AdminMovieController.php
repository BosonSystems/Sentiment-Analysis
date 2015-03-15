<?php

class AdminMovieController extends AdminController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
    protected $movie;
    protected $word;
    public function __construct(Movie $movie,Word $word)
    {
        parent::__construct();
        $this->movie = $movie;
        $this->word = $word;
    }
    public function getView($movie)
    {
        // Title
        $title = $movie->name;
        // Grab all the users
        $movies = $this->movie;
        // Show the page
        return View::make('admin/movie/view', compact('movie', 'title'));
    }
    public function getIndex()
    {
        // Title
        $title = "Movies";
        // Grab all the users
        $movies = $this->movie;
        // Show the page
        return View::make('admin/movie/index', compact('movies', 'title'));
    }
    public function getData()
    {
        $image_path = public_path().'\img\\';
        $movies = Movie::select(array('movie.id', 'movie.name','movie.image','movie.review','movie.is_active', 'movie.created_at'))->orderBy('movie.id','asc');//,'movie.review'

        return Datatables::of($movies)
         ->edit_column('name','@if($image != "")
                        <img src="{{ asset(\'/img/\') }}/{{ $image }}" width="50" /> {{ $name }}
                        @else
                            <img src="{{ asset(\'/img/\') }}/defalut-avatar.png" width="50" /> {{$name}}
                        @endif
                        ')
         
         ->edit_column('review','{{{ mb_substr($review,0,250)."..." }}}')

         ->edit_column('is_active','@if($is_active == "1")
                            {{ "Yes" }}
                        @else
                            {{ "No" }}
                        @endif')

         ->edit_column('created_at','{{{ date("Y-m-d",strtotime($created_at)) }}}')
      

        ->add_column('actions', '<a href="{{{ URL::to(\'admin/movie/\' . $id . \'/view\' ) }}}" class="btn btn-xs btn-success">View</a>
            <a href="{{{ URL::to(\'admin/movie/\' . $id . \'/edit\' ) }}}" class="iframe btn btn-xs btn-default">{{{ Lang::get(\'button.edit\') }}}</a>
                                
                                    <a href="{{{ URL::to(\'admin/movie/\' . $id . \'/delete\' ) }}}" class="btn btn-xs btn-danger">{{{ Lang::get(\'button.delete\') }}}</a>
                              
            ')

        ->remove_column('id')
        ->remove_column('image')
        ->make();
    }

    public function getCreate()
    {
        $title = "Add Movie";

        // Mode
        $mode = 'create';

        // Show the page
        return View::make('admin/movie/add', compact('title'));
    }
    
    public function postCreate()
    {

        $rules = array(
            'name' => 'required',            
            'review' => 'required',
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
            return Redirect::to('admin/movie/' . $this->movie->id . '/edit')->with('success',"Movie added");
        }
        else
        {
          
            return Redirect::to('admin/movie/create')
                ->withErrors($validator);
        }
    }

    public function getEdit($movie)
    {

        $title = "Update Movie";
        return View::make('admin/movie/edit', compact('movie', 'title'));
    }
    public function postEdit($movie)
    {
        $rules = array(
            'name' => 'required',            
            'review' => 'required',//|min:250
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
            return Redirect::to('admin/movie/' . $movie->id . '/edit')->with('success',"Movie updated");
        }
        else
        {
          
            return Redirect::to('admin/movie/create')
                ->withErrors($validator);
        }
    }
    public function getDelete($movie)
    {
        $moviename = $movie->name;
        if($movie->delete()) {
            // Redirect to the role management page
            return Redirect::to('admin/movie')->with('success', $moviename." Movie deleted");
        }

        // There was a problem deleting the role
        return Redirect::to('admin/movie')->with('error',"Movie could not be deleted");
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
        return View::make('admin/movie/analyse', compact('movie', 'title','sentimentCategories','totalFind','totalSentFind','totalNagFind','totalNewWords','total'));
    }
}