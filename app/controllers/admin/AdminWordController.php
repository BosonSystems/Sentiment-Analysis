<?php

class AdminWordController extends AdminController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
    protected $word;

    protected $category;
    protected $movie;

    public function __construct(Word $word,Category $category,Movie $movie)
    {
        parent::__construct();
        $this->word = $word;
        $this->category = $category;
        $this->movie = $movie;
    }
    public function getIndex()
    {
        // Title
        /*$words = DB::table('words')
            ->leftJoin('categories', 'words.category_id', '=', 'categories.id')            
            ->select('words.id', 'words.word','words.category_id','words.word_type_id','categories.meaning')->orderBy('words.id','asc')
            ->get();*/
         /*   $words = Word::select(array('words.id', 'words.word','words.category_id','words.word_type_id','categories.meaning'))->leftJoin('categories', 'words.category_id', '=', 'categories.id')->limit(10)->orderBy('words.id','asc')->get();
    echo "<Pre>";print_r( $words);exit;*/
        $title = "Words";
        // Grab all the users
        $words = $this->word;
        // Show the page
        return View::make('admin/words/index', compact('words', 'title'));
    }
    public function getData()
    {
        $words =$words = Word::select(array('words.id', 'words.word','words.category_id','words.word_type_id','categories.meaning'))->leftJoin('categories', 'words.category_id', '=', 'categories.id')->limit(10)->orderBy('words.id','asc');
        //Word::select(array('words.id', 'words.word','words.category_id','words.word_type_id','categories.id'))->orderBy('words.id','asc');//,'category.review'->where('words.word_type_id','=',1)

        return Datatables::of($words)       
        ->edit_column('word_type_id','@if($word_type_id == 1)
                            Sentiment
                        @elseif($word_type_id == 2)
                            Negative                        
                        @endif')
         ->edit_column('meaning','@if($meaning != "")
                            {{$meaning}}
                        @else
                            -                        
                        @endif')

        ->add_column('actions', '<a href="{{{ URL::to(\'admin/words/\' . $id . \'/edit\' ) }}}" class="iframe btn btn-xs btn-default">{{{ Lang::get(\'button.edit\') }}}</a>
                                
                                    <a href="{{{ URL::to(\'admin/words/delete/\' . $id . \'/2\' ) }}}" class="btn btn-xs btn-danger">{{{ Lang::get(\'button.delete\') }}}</a>
                              
            ')
        ->remove_column('category_id')
        ->remove_column('id')
        ->remove_column('image')
        ->make();
    }

    public function getCreate()
    {
        $title = "Add Word";

        $categories = $this->category->all();
        
        // Mode
        $type = 1;

        // Show the page
        return View::make('admin/words/add', compact('title','type','categories'));

    }
    public function postCreate()
    {          
        $type = 1;

        $rules = array(
            'word' => 'required',
            'category_id' => 'required',     
        );
        $messages = array(
            'required' => 'Required',
        );
       
        $validator = Validator::make(Input::all(), $rules,$messages);
        // Check if the form validates with success
        if ($validator->passes())
        {
            $inputs = Input::except('csrf_token');
            $this->word->word = $inputs['word'];
            $this->word->category_id = ($inputs['word_type_id']==1?$inputs['category_id']:0);
            $this->word->word_type_id = $inputs['word_type_id'];
            $this->word->save();
            if ($this->word->id)
            {
                return Redirect::to('admin/words/'.$this->word->id.'/edit')->with('success',"Word added");
            }
            return Redirect::to('admin/words/'.$this->word->id.'/edit')->with('success',"Word added");
        }
        else
        {
          
            return Redirect::to('admin/words/create')
                ->withInput()
                ->withErrors($validator);
        }
    }

    public function getEdit($word)
    {
        $title = "Update Word";
        $categories = $this->category->all();
        $type = 1;
        return View::make('admin/words/edit', compact('word', 'title','categories','type'));
    }
    public function postEdit($word)
    {
        $rules = array(
            'word' => 'required',                        
            'category_id' => 'required',
        );
        $messages = array(
            'required' => 'Required',
        );
       
        $validator = Validator::make(Input::all(), $rules,$messages);
        // Check if the form validates with success
        if ($validator->passes())
        {
            $inputs = Input::except('csrf_token');
            $word->word = $inputs['word'];           
            $word->category_id = ($inputs['word_type_id']==1?$inputs['category_id']:0);
            $word->word_type_id = $inputs['word_type_id'];
            $word->save();
            if ($word->id)
            {
                return Redirect::to('admin/words/' . $word->id . '/edit')->with('success',"Category updated");
            }            
        }
        else
        {
            return Redirect::to('admin/words/' . $word->id . '/edit')->withInput()
                ->withErrors($validator);
        }
    }



    public function getSentiment()
    {
        // Title
        $title = "Sentiment Words";
        // Grab all the users
        $words = $this->word;
        // Show the page
        return View::make('admin/words/sentiment', compact('words', 'title'));
    }
    public function getSentimentData()
    {
        $words = Word::select(array('words.id', 'words.word','words.category_id'))->where('words.word_type_id','=',1)->orderBy('words.id','asc');//,'category.review'

        return Datatables::of($words)       

        ->add_column('actions', '<a href="{{{ URL::to(\'admin/sentiment/\' . $id . \'/edit\' ) }}}" class="iframe btn btn-xs btn-default">{{{ Lang::get(\'button.edit\') }}}</a>
                                
                                    <a href="{{{ URL::to(\'admin/sentiment/delete/\' . $id . \'/2\' ) }}}" class="btn btn-xs btn-danger">{{{ Lang::get(\'button.delete\') }}}</a>
                              
            ')
        ->remove_column('category_id')
        ->remove_column('id')
        ->remove_column('image')
        ->make();
    }
    public function getSentimentCreate()
    {
        $title = "Add Sentiment Word";

        $categories = $this->category->all();
        
        // Mode
        $type = 1;

        // Show the page
        return View::make('admin/words/add', compact('title','type','categories'));

    }
    public function postSentimentCreate()
    {          
        $type = 1;

        $rules = array(
            'word' => 'required',
            'category_id' => 'required',     
        );
        $messages = array(
            'required' => 'Required',
        );
       
        $validator = Validator::make(Input::all(), $rules,$messages);
        // Check if the form validates with success
        if ($validator->passes())
        {
            $inputs = Input::except('csrf_token');
            $this->word->word = $inputs['word'];
            $this->word->category_id = $inputs['category_id'];
            $this->word->word_type_id = $inputs['word_type_id'];
            $this->word->save();
            if ($this->word->id)
            {
                return Redirect::to('admin/sentiment/'.$this->word->id.'/edit')->with('success',"Word added");
            }
            return Redirect::to('admin/sentiment/'.$this->word->id.'/edit')->with('success',"Word added");
        }
        else
        {
          
            return Redirect::to('admin/sentiment/create')
                ->withErrors($validator);
        }
    }

    public function getSentimentEdit($word)
    {
        $title = "Update Sentiment Word";
        $categories = $this->category->all();
        $type = 1;
        return View::make('admin/words/edit', compact('word', 'title','categories','type'));
    }
    public function postSentimentEdit($word)
    {
        $rules = array(
            'word' => 'required',                        
            'category_id' => 'required',
        );
        $messages = array(
            'required' => 'Required',
        );
       
        $validator = Validator::make(Input::all(), $rules,$messages);
        // Check if the form validates with success
        if ($validator->passes())
        {
            $inputs = Input::except('csrf_token');
            $word->word = $inputs['word'];           
            $word->category_id = $inputs['category_id'];
            $word->save();
            if ($word->id)
            {
                return Redirect::to('admin/sentiment/' . $word->id . '/edit')->with('success',"Category updated");
            }            
        }
        else
        {
            return Redirect::to('admin/sentiment/' . $word->id . '/edit')->withInput()
                ->withErrors($validator);
        }
    }
    public function getNegative()
    {
        // Title
        $title = "Negative Words";
        // Grab all the users
        $words = $this->word->where('word_type_id',2)->get();
        // Show the page
        return View::make('admin/words/negative', compact('words', 'title'));
    }
    public function getNegativeData()
    {
        $words = Word::select(array('words.id', 'words.word','words.category_id'))->where('words.word_type_id','=',2)->orderBy('words.id','asc');//,'category.review'

        return Datatables::of($words)       

        ->add_column('actions', '<a href="{{{ URL::to(\'admin/negative/\' . $id . \'/edit\' ) }}}" class="iframe btn btn-xs btn-default">{{{ Lang::get(\'button.edit\') }}}</a>
                                
                                    <a href="{{{ URL::to(\'admin/negative/delete/\' . $id . \'/2\' ) }}}" class="btn btn-xs btn-danger">{{{ Lang::get(\'button.delete\') }}}</a>
                              
            ')
        ->remove_column('category_id')
        ->remove_column('id')
        ->remove_column('image')
        ->make();
    }
    public function getNegativeCreate()
    {
        $title = "Add Negative Word";

        $categories = $this->category->all();
        
        // Mode
        $type = 2;

        // Show the page
        return View::make('admin/words/add', compact('title','type','categories'));

    }
    public function postNegativeCreate()
    {          
        $type = 2;

        $rules = array(
            'word' => 'required',
           
        );
        $messages = array(
            'required' => 'Required',
        );
       
        $validator = Validator::make(Input::all(), $rules,$messages);
        // Check if the form validates with success
        if ($validator->passes())
        {
            $inputs = Input::except('csrf_token');
            $this->word->word = $inputs['word'];
           
            $this->word->word_type_id = $inputs['word_type_id'];
            $this->word->save();
            if ($this->word->id)
            {
                return Redirect::to('admin/negative/'.$this->word->id.'/edit')->with('success',"Word added");
            }
            return Redirect::to('admin/negative/'.$this->word->id.'/edit')->with('success',"Word added");
        }
        else
        {
          
            return Redirect::to('admin/negative/create')
                ->withErrors($validator);
        }
    }

    public function getNegativeEdit($word)
    {
        $title = "Update Negative Word";
        $categories = $this->category->all();
        $type = 2;
        return View::make('admin/words/edit', compact('word', 'title','categories','type'));
    }
    public function postNegativeEdit($word)
    {
        $rules = array(
            'word' => 'required', 
        );
        $messages = array(
            'required' => 'Required',
        );
       
        $validator = Validator::make(Input::all(), $rules,$messages);
        // Check if the form validates with success
        if ($validator->passes())
        {
            $inputs = Input::except('csrf_token');
            $word->word = $inputs['word'];   
            $word->save();
            if ($word->id)
            {
                return Redirect::to('admin/negative/' . $word->id . '/edit')->with('success',"Word updated");
            }            
        }
        else
        {
            return Redirect::to('admin/negative/' . $word->id . '/edit')->withInput()
                ->withErrors($validator);
        }
    }
    public function getDelete($word)
    {
        $wordname = $word->word;
        if($word->delete()) {

            return Redirect::to('admin/words')->with('success',"Word deleted");

            // Redirect to the role management page
           /* if($type == 1)
            {
                return Redirect::to('admin/negative')->with('success', $wordname."Word deleted");
            }
            else
            {
                return Redirect::to('admin/negative')->with('success', $wordname."Word deleted");
            }*/
            
        }
         return Redirect::to('admin/words')->with('success', $wordname."Word could not be deleted");
       /* if($type == 1)
        {
            return Redirect::to('admin/sentiment')->with('success', $wordname."Word could not be deleted");
        }
        else
        {
            return Redirect::to('admin/negative')->with('success', $wordname."Word could not be deleted");
        }*/
    
    }
    public function getNewwords($movie)
    {
        $title = "Add New Word - ".$movie->name;
        $words = $movie->mb_str_word_count($movie->review,2); 
        $categories = DB::table('categories')->get();
        $word_types = DB::table('word_types')->get();
        $newWords = array();
        if(!empty($words))
        {
            foreach ($words as $word) {
                 //$findWord = $this->word->where('word',$word)->first(); 
                 $findWord = $this->word->where('word','like',$word.'%')->first(); 
                 if(empty($findWord))
                 {                   
                    $newWords[] = $word;
                 }
            }
        }
     //print_r($word_types);
       return View::make('admin/words/newwords', compact('title','movie','newWords','categories','word_types'));
    }
    public function postNewwords($movie)
    {
        $title = "Add New Word - ".$movie->name;
        $inputs = Input::except('csrf_token');  

        if(!empty($inputs['word']))
        {
            foreach ($inputs['word'] as $word) 
            {
                if($inputs['word_type_id'] != 4)
                {
                   $data = array();
                   $data['word'] = $word['word'];
                   $data['word_type_id'] = $inputs['word_type_id'];
                   $data['category_id'] = ($inputs['word_type_id'] == 1)?$inputs['category_id']:0;
                   DB::table('words')->insert($data);
                }
               
            }
        }
        //return View::make('admin/words/newwords', compact('title','newWords'));
        return Redirect::to('admin/movie/'.$movie->id.'/view')->with('success', "Word added");
    }
}