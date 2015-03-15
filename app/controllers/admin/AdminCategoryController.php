<?php

class AdminCategoryController extends AdminController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
    protected $category;

    public function __construct(Category $category)
    {
        parent::__construct();
        $this->category = $category;
    }

    public function getIndex()
    {
        // Title
        $title = "Sentiment Categories";
        // Grab all the users
        $categories = $this->category;
        // Show the page
        return View::make('admin/category/index', compact('categories', 'title'));
    }
    public function getData()
    {
        $categories = Category::select(array('categories.id', 'categories.meaning','categories.is_active', 'categories.created_at'))->orderBy('categories.id','asc');//,'category.review'

        return Datatables::of($categories)       

         ->edit_column('is_active','@if($is_active == "1")
                            {{ "Yes" }}
                        @else
                            {{ "No" }}
                        @endif')

         ->edit_column('created_at','{{{ date("Y-m-d",strtotime($created_at)) }}}')
      

        ->add_column('actions', '<a href="{{{ URL::to(\'admin/category/\' . $id . \'/edit\' ) }}}" class="iframe btn btn-xs btn-default">{{{ Lang::get(\'button.edit\') }}}</a>
                                
                                    <a href="{{{ URL::to(\'admin/category/\' . $id . \'/delete\' ) }}}" class="btn btn-xs btn-danger">{{{ Lang::get(\'button.delete\') }}}</a>
                              
            ')

        ->remove_column('id')
        ->remove_column('image')
        ->make();
    }

    public function getCreate()
    {
        $title = "Add Sentiment Category";

        // Mode
        $mode = 'create';

        // Show the page
        return View::make('admin/category/add', compact('title'));
    }
    
    public function postCreate()
    {

        $rules = array(
            'meaning' => 'required',            
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
            $this->category->meaning = $inputs['meaning'];            
            $this->category->is_active = $inputs['is_active'];
            $this->category->save();
            if ($this->category->id)
            {
                return Redirect::to('admin/category/' . $this->category->id . '/edit')->with('success',"Category added");
            }
           
        }
        else
        {
          
            return Redirect::to('admin/category/create')->withInput()
                ->withErrors($validator);
        }
    }

    public function getEdit($category)
    {

        $title = "Update Sentiment Category";
        return View::make('admin/category/edit', compact('category', 'title'));
    }
    public function postEdit($category)
    {
        $rules = array(
            'meaning' => 'required',                        
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
            $category->meaning = $inputs['meaning'];           
            $category->is_active = $inputs['is_active'];
            $category->save();
            if ($category->id)
            {
                return Redirect::to('admin/category/' . $category->id . '/edit')->with('success',"Category updated");
            }            
        }
        else
        {
          
            return Redirect::to('admin/category/create')->withInput()
                ->withErrors($validator);
        }
    }
    public function getDelete($category)
    {
        $moviename = $category->name;
        if($category->delete()) {
            // Redirect to the role management page
            return Redirect::to('admin/category')->with('success', $moviename." Category deleted");
        }

        // There was a problem deleting the role
        return Redirect::to('admin/category')->with('error',"Category could not be deleted");
    }
}