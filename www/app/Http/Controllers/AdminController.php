<?php

namespace App\Http\Controllers;

use App\User;
use GuzzleHttp\Psr7\Request;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Routing\ControllerMiddlewareOptions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Redirect;

class AdminController extends Controller
{

    public function selectUser()
    {

        $data = DB::table('users')->select(array('id', 'name', 'surname', 'password', 'rights', 'email'))->get();
        return view("admin/userAdmin")->with('user', $data);

    }

    public function createUser()
    {


        $right = request()->input("rights");
        $maxId = DB::table('users')->max('id') + 1;

        if ($right == "admin" || $right == 1) {
            $right = 1;
            $this->createRole($right, $maxId);
        } else if ($right == "user" || $right == 2) {
            $right = 2;
            $this->createRole($right, $maxId);
        } else if ($right == "uctovnik" || $right == 3) {
            $right = 3;
            $this->createRole($right, $maxId);
        } else {
            echo "Zle vložené práva!";
            exit;
        }

        session()->put('toast', 'add');

        if($right==3){
            DB::table('users')->insertGetId(

                ['id' => $maxId, 'rel_user_role' => $maxId, 'name' => request()->input("name"), 'surname' => request()->input("surname"), 'email' => request()->input("email"), 'rights' => $right, 'password' => \Hash::make(request()->input("pass"))]
            );

        }
        else  DB::table('users')->insertGetId(

            ['id' => $maxId, 'ucto_code'=> $this->crateCodeUser($maxId),'rel_user_role' => $maxId, 'name' => request()->input("name"), 'surname' => request()->input("surname"), 'email' => request()->input("email"), 'rights' => $right, 'password' => \Hash::make(request()->input("pass"))]
        );

        echo "Data vložene!";
//        return view("admin/userAdmin")->with('user',$data);

    }

    private function crateCodeUser($maxId){

        $firstTwoLetterName=substr(request()->input("name"),0,2);
        $firstTwoLetterSurname=substr(request()->input("surname"),0,2);
        $randomNumber=rand(10,100)+$maxId;
        $code=$maxId.$firstTwoLetterName.$firstTwoLetterSurname.$randomNumber;
        return $code;
}


    private function createRole($right, $maxId)
    {

        $this->priviledge($right, $maxId);

        DB::table('role')->insert(
            ['name' => $right,
                'rel_user_role' => $maxId,
                'rel_role_priviledge' => $maxId]
        );


    }

    private function priviledge($right, $maxId)
    {

        if ($right == 2) {
            DB::table('priviledge')->insert(
                ['name' => 'CREATE_DOC',
                    'rel_role_priviledge' => $maxId]
            );
            DB::table('priviledge')->insert(
                ['name' => 'UPDATE_DOC',
                    'rel_role_priviledge' => $maxId]
            );
            DB::table('priviledge')->insert(
                ['name' => 'CREATE_TAG',
                    'rel_role_priviledge' => $maxId]
            );
            DB::table('priviledge')->insert(
                ['name' => 'UPDATE_TAG',
                    'rel_role_priviledge' => $maxId]
            );
            DB::table('priviledge')->insert(
                ['name' => 'GET_TAG',
                    'rel_role_priviledge' => $maxId]
            );
        } else if ($right == 3) {
            DB::table('priviledge')->insert(
                ['name' => 'GET_USER',
                    'rel_role_priviledge' => $maxId]
            );
            DB::table('priviledge')->insert(
                ['name' => 'CREATE_TAG',
                    'rel_role_priviledge' => $maxId]
            );
            DB::table('priviledge')->insert(
                ['name' => 'GET_TAG',
                    'rel_role_priviledge' => $maxId]
            );
            DB::table('priviledge')->insert(
                ['name' => 'UPDATE_TAG',
                    'rel_role_priviledge' => $maxId]
            );
            DB::table('priviledge')->insert(
                ['name' => 'UPDATE_DOC_3',
                    'rel_role_priviledge' => $maxId]
            );
        }
        else if ($right == 1 ) {
            DB::table('priviledge')->insert(
                ['name' => 'all',
                    'rel_role_priviledge' => $maxId]
            );
        }

    }


    public function deleteUser()
    {  session()->put('toast', 'delete');
        DB::table('rel_user_user')->where('user_id', request()->input("id"))->delete();
        DB::table('priviledge')->where('rel_role_priviledge', request()->input("id"))->delete();
        DB::table('role')->where('rel_user_role', request()->input("id"))->delete();
        DB::table('users')->where('id', request()->input("id"))->delete();


    }

    public function deleteUctoClient()
    { session()->put('toast', 'delete');
        DB::table('rel_user_user')->where('ucto_id', request()->input("idUcto"))->where('user_id', request()->input("idClient"))->delete();
        DB::table('users')->where('id', request()->input("idUcto"))->update(['rel_user_user' => request()->input("idUcto")]);

    }

    public function editUser()
    {
        session()->put('toast', 'change');
        $user = User::findOrFail(request()->input("id"));
        if (request()->input("colum") == "password") {
            $user->update([request()->input("colum") => \Hash::make(request()->input("text"))]);
        } else         $user->update([request()->input("colum") => request()->input("text")]);

    }

    public function userAddUc()
    {

        $usersUc = DB::table("users")->select('users.id', 'users.name', 'users.surname', 'users.email')->leftJoin("role", "role.rel_user_role", '=', 'users.rel_user_role')->where('role.name', '=', "3")->get();
        $usersClents = DB::table("users")->select('users.id', 'users.name', 'users.surname', 'users.email')->leftJoin("role", "role.rel_user_role", '=', 'users.rel_user_role')->where('role.name', '=', "2")->get();


        $users = DB::table("users")->select(['users.id'])->leftJoin("role", "role.rel_user_role", '=', 'users.rel_user_role')->where('role.name', '=', "2")->get();
        //var_dump($usersUc);
        $clientIdForUser = array();
        $cliet = array();
        $index = 0;
        $indexId = 0;
        $usersName = "";
        $clientsName = "";


        foreach ($usersUc as $userUc) {
            $clientIdForUser[$index] = DB::table('rel_user_user')->select(["rel_user_user.user_id", "rel_user_user.id", "rel_user_user.ucto_id"])->leftJoin("users", 'rel_user_user.rel_user_user', '=', 'users.rel_user_user')->where('ucto_id', '=', $userUc->id)->get();
            $usersName .= "'" . $userUc->name . " " . $userUc->surname . "(" . $userUc->email . ")'" . ",";
//           foreach ($users as $user){
//           }
//
////           $clientIdForUser[0][0]=
//           )

            $index = $index + 1;
        }

        foreach ($usersClents as $usersClent) {
            $clientsName .= "'" . $usersClent->name . " " . $usersClent->surname . "(" . $usersClent->email . ")'" . ",";

        }

        //    var_dump($clientIdForUser);
        //  echo $clientIdForUser[0][1]->user_id;

        $clients = array();
        $index = 0;
        $indexId = 0;

        for ($index = 0; $index < sizeof($clientIdForUser); $index++) {

            if (sizeof($clientIdForUser[$index]) > 1) {
                for ($index2 = 0; $index2 < sizeof($clientIdForUser[$index]); $index2++) {
                    $clientIdForUser[$index][$index2]->id = $email = $clientIdForUser[$index][$index2]->user_id;
                    $clientIdForUser[$index][$index2]->user_id = $email = DB::table('users')->where('id', $clientIdForUser[$index][$index2]->user_id)->value('name') . " " . DB::table('users')->where('id', $clientIdForUser[$index][$index2]->user_id)->value('surname');

                }
            } else {
                if (isset($clientIdForUser[$index][0]->id)) {
                    $clientIdForUser[$index][0]->id = $email = $clientIdForUser[$index][0]->user_id;
                    $clientIdForUser[$index][0]->user_id = $email = DB::table('users')->where('id', $clientIdForUser[$index][0]->user_id)->value('name') . " " . DB::table('users')->where('id', $clientIdForUser[$index][0]->user_id)->value('surname');
                }
            }
        }

        return view("admin/addUserUc")->with('users', $usersUc)->with("clients", $clientIdForUser)->with("name", $usersName)->with("nameClients", $clientsName);
    }

    public function addUserToUc()
    {



        $economy = substr(request()->input('economy'), strpos(request()->input('economy'), "(") + 1, -1);
        $client = substr(request()->input('client'), strpos(request()->input('client'), "(") + 1, -1);
        $idEconomy = DB::table('users')->where("email", $economy)->value("id");
        $idClient = DB::table('users')->where("email", $client)->value("id");

        DB::table("rel_user_user")->insert([
            "user_id" => $idClient,
            "ucto_id" => $idEconomy,
            "rel_user_user" => $idEconomy
        ]);



        if(DB::table('users')->where('id', $idEconomy)->value('rel_user_user')==""){
            DB::table('users')->where('id',$idEconomy)->update(['rel_user_user'=>$idEconomy]);
        }

        session()->put('toast', 'add');

        return Redirect::back();
    }


}
