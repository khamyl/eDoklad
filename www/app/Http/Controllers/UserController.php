<?php
/**
 * Created by PhpStorm.
 * User: Erik Bohony
 * Date: 28.10.2018
 * Time: 15:27
 */

namespace App\Http\Controllers;


use App\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Redirect;
use PhpParser\Node\Expr\Array_;


class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function changeInf(Request $request)
    {
        $user = User::findOrFail(Auth::user()->id);

        $user->email = request()->input("mail");

        $user->update();

        return Redirect::back();


    }

    public function changePassword(Request $request)
    {
        $user = new User;
        $oldPass = User::findOrFail(Auth::user()->id);
        if (\Hash::check($request->input('oldPass'), $oldPass->password) == 1) {
            if ($request->input('newPass') == $request->input('confPass')) {


                $newPass = \Hash::make(request()->input("newPass"));
                $request->session()->put('goodPass', 'Hesla úspešne zmenené !');
                //     $user->name="Erik";
                $user->where('name', Auth::user()->name)->update(['password' => $newPass]);

                return Redirect::back();
            } else {
                $request->session()->put('wrongPass', 'Hesla sa nezhoduju !');
                return Redirect::back();

            }
            //    $user->save();

        } else {
            $request->session()->put('wrongPass', 'Neplatné staré heslo !');
            return Redirect::back();
        }


    }

    public function showTags(Request $request)
    {
        $tags = DB::table('tag')->where('rel_tag_user', Auth::user()->id)->get();
        $countDocument=[];
        $document=DB::table('document')
            ->select(DB::raw('count(*) as tag_count,tag'))
            ->where('owner', Auth::user()->id)
            ->groupBy("tag")
            ->get()
            ->keyBy('tag');
        foreach ($tags as $tag){
           // array_push($countDocument,$tag->tag);
            $countDocument[] = [
                "name"=>$tag->tag,
                "count"=>isset($document[$tag->tag]) ? $document[$tag->tag]->tag_count : 0
            ];
        }
        $countTags=sizeof($tags);
        return view('user/tags')->with('tags', $tags)->with('countTags',$countTags)->with('document',$countDocument);
    }


    public function createTag(Request $request)
    {
        session()->put('toast', 'add');
        DB::table('tag')->insertGetId(
            ['tag' => request()->input("tag"), 'color' => request()->input("color"), 'rel_tag_user' => Auth::user()->id,'description'=>request()->input('description')]
        );
        if (DB::table('tag')->where('id', request()->input("id"))->value('rel_tag_user') == "") {
            DB::table('users')->where('id', Auth::user()->id)->update(['rel_tag_user' => Auth::user()->id]);
        }
        return Redirect::back();

    }

    public function deleteTag($id)
    {
        $rel_tag_user = DB::table('tag')->where('id', $id)->value('rel_tag_user');
        session()->put('toast', 'delete');
        DB::table('tag')->where('id', $id)->delete();
        DB::table('users')->where('id', Auth::user()->id)->update(['rel_tag_user' => $rel_tag_user]);
        return Redirect::back();
    }

    public function editTag()
    {

        DB::table('tag')->where("id", request()->input("id"))->update([request()->input("colum") => request()->input("text")]);
        session()->put('toast', 'change');

    }

    public function showUserUcUc()
    {


        $userId = DB::table('rel_user_user')->select('user_id')->where("ucto_id", Auth::user()->id)->get();
        $userInfo = array();
        $pushIndex = 0;
        foreach ($userId as $user) {
            $userInfo[$pushIndex] = ["name" => DB::table('users')->where('id', $user->user_id)->value('name') . " " . DB::table('users')->where('id', $user->user_id)->value('surname')] + ["email" => DB::table('users')->where('id', $user->user_id)->value('email')] + ["id" => $user->user_id];
            $pushIndex++;
        }



        return view("user/addUserUcUc")->with('users',$userInfo);
    }

    public function delUSerUcUc($id)
    {
        session()->put('toast', 'delete');
        DB::table("rel_user_user")->where('user_id',$id)->delete();
        return Redirect::back();
    }
    public function addUSerUcUc()
    {
        $maxId=DB::table('rel_user_user')->max('id')+1;
     $userid=DB::table('users')->where('ucto_code',request()->input('code'))->value('id');
     if($userid==""){
         session()->put('toast', 'wrong');
         return Redirect::back();
     }


        session()->put('toast', 'add');
        DB::table("rel_user_user")->insert([
            'id'=>$maxId,
            'user_id'=>$userid,
            'ucto_id'=>Auth::user()->id,
            'rel_user_user'=>Auth::user()->id
        ]);
        DB::table('users')->where('id', Auth::user()->id)->update(['rel_user_user' => Auth::user()->id]);

        return Redirect::back();
    }


}