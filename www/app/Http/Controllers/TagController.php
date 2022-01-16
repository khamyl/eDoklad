<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Tag;
use Illuminate\Http\Request;
use Session;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function index(){

        $tags_q = Tag::where('user_id', Auth::id());
        if(request()->has('sort')){
            $tags_q->sortable(); //Sortable is scope from kyslik\columnsortable vendored package
        }else{
            $tags_q->orderBy('id', 'desc');
        } 
        
        $tags = $tags_q->get(); 
        return view("tags.index")->with(compact('tags'));
     }

    // public function index($sortby, $ord='asc')
    // {
    //     $tags_q = Tag::where('user_id', Auth::id());

    //     $sortable = ['tag', 'docs'];
    //     if($ord != 'desc') $ord = 'asc';        

    //     if(in_array($sortby, $sortable)){            
    //         $tags_q->orderBy($sortby, $ord);
    //     }else{
    //         $tags_q->orderBy('id');
    //     }

    //     $tags = $tags_q->get();

    //     return view("tags.index")->with(compact('tags'));
    // }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated_data = $request->validate([
            'tag' => 'required|max:30', /* db: varchar(45) */
            'color' => 'max:7',
            'decdription' => 'max:255'
        ]);
        
        //Role
        $tag = new Tag();
        $tag->user_id = Auth::id();
        $tag->tag = $request->tag;
        $tag->color = $request->color;
        $tag->description = $request->description;
        $tag->save();
            
        $status = ['success' => 'Tag successfully created.'];        
        Session::flash('status', $status); 
        return $status;  
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tag $tag)
    {        
        //Validate
        $validated_data = $request->validate([
            'tag' => 'required|max:30', /* db: varchar(45) */
            'color' => 'max:7',
            'decdription' => 'max:255'
        ]);

        //Update       
        $tag->tag = $request->tag;
        $tag->color = $request->color;
        $tag->description = $request->description;     
        $tag->save();  

        //Finish
        $status = ['success' => 'Tag successfully updated.'];        
        Session::flash('status', $status);     
        return $status;   
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tag $tag)
    {
        $this->authorize('delete', $tag);
        
        $tag->delete();
        $status = ['success' => 'Tag deleted successfully.'];        
        return redirect('/tags')->with('status', $status);
    }
}
