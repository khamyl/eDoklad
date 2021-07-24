<?php

namespace App\Http\Controllers;

use App\Document;
use App\User;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use thiagoalessio\TesseractOCR\TesseractOCR; ///TODO: asi sa nepouziva - overit, odmazat

class DokumentController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     *
     */


    public function __construct()
    {
        $this->middleware('auth');
    }


    function search()
    {

        $tags = DB::table('tag')->where('rel_tag_user', Auth::user()->id)->get();
        foreach ($tags as $tagValue) {
            $tagValue->color = '#' . $tagValue->color;
        }
        $privilegios = Auth::user()->getRights(Auth::user()->id);
        if (request()->input('tag') != "" && request()->input('dateSearch') != "" && request()->input('user') != "") {
            if ($privilegios == 1 || $privilegios == 3) {
                $document = $document = $this->getDocumentsSearch(request()->input('dateSearch'), request()->input('tag'), request()->input('user') != "");
                return view('evidence/paper')->with('document', $document)->with('date', request()->input('dateSearch'))->with('tags', $tags)->with('clientsName', $this->getUserSearch());
            } else {
                $document = DB::table('document')->select('name', 'id', 'date', 'tag')->where('owner', '=', Auth::user()->id)->where('type', '=', 1)->where('date', '>=', request()->input('dateSearch'))->where('tag', '>=', request()->input('tag'))->get();
                return Redirect::back()->with('document', $document)->with('date', request()->input('dateSearch'))->with('tags', $tags);;
            }

        }
        if (request()->input('tag') != "" && request()->input('dateSearch') != "") {
            if ($privilegios == 1 || $privilegios == 3) {
                $document = $document = $this->getDocumentsSearch(request()->input('dateSearch'), "", request()->input('user') != "");
                return view('evidence/paper')->with('document', $document)->with('date', request()->input('dateSearch'))->with('tags', $tags)->with('clientsName', $this->getUserSearch());
            } else {
                $document = DB::table('document')->select('name', 'id', 'date', 'tag')->where('owner', '=', Auth::user()->id)->where('type', '=', 1)->where('date', '>=', request()->input('dateSearch'))->where('tag', '>=', request()->input('tag'))->get();
                return view('evidence/paper')->with('document', $document)->with('date', request()->input('dateSearch'))->with('tags', $tags);;
            }

        }
        if (request()->input('tag') != "" && request()->input('user') != "") {
            if ($privilegios == 1 || $privilegios == 3) {
                $document = $document = $this->getDocumentsSearch("", request()->input('tag'), request()->input('user') != "");
                return view('evidence/paper')->with('document', $document)->with('date', request()->input('dateSearch'))->with('tags', $tags)->with('clientsName', $this->getUserSearch());
            } else {
                $document = DB::table('document')->select('name', 'id', 'date', 'tag')->where('owner', '=', Auth::user()->id)->where('type', '=', 1)->where('date', '>=', request()->input('dateSearch'))->where('tag', '>=', request()->input('tag'))->get();
                return view('evidence/paper')->with('document', $document)->with('date', request()->input('dateSearch'))->with('tags', $tags);;
            }

        } else if (request()->input('user') != "") {
            if ($privilegios == 1 || $privilegios == 3) {
                $document = $this->getDocumentsSearch("", "", request()->input('user'));
                return view('evidence/paper')->with('document', $document)->with('date', request()->input('dateSearch'))->with('tags', $tags)->with('clientsName', $this->getUserSearch());;
            }
        } else if (request()->input('dateSearch') != "") {

            if ($privilegios == 1 || $privilegios == 3) {
                $document = $this->getDocumentsSearch(request()->input('dateSearch'), "", "");
                return view('evidence/paper')->with('document', $document)->with('date', request()->input('dateSearch'))->with('tags', $tags)->with('clientsName', $this->getUserSearch());;
            } else {
                $document = DB::table('document')->select('name', 'id', 'date', 'tag')->where('owner', '=', Auth::user()->id)->where('type', '=', 1)->where('date', '>=', request()->input('dateSearch'))->get();
                return view('evidence/paper')->with('document', $document)->with('date', request()->input('dateSearch'))->with('tags', $tags);;
            }
        } else {
            return $this->paperShow();
        }


    }

    public function changeBasicInfo($id)
    {

        DB::table('edit_document')->where('edit_id', $id)->update(['company_name' => request()->input('company_name')
            , 'company_address' => request()->input('company_address')
            , 'ico' => request()->input('ico')
            , 'ic_dph' => request()->input('ic_dph')
            , 'date' => request()->input('date')
            , 'dpk' => request()->input('dpk')
            , 'summar' => request()->input('sumar')
//            , 'time' => request()->input('time')

        ]);

        $real_document = DB::table('real_document')->where('real_id', '=', $id)->get();
        $real_item = DB::table('real_item')->where('real_id', '=', $id)->get();
        $edit_document = DB::table('edit_document')->where('edit_id', '=', $id)->get();
        $edit_item = DB::table('edit_item')->where('edit_id', '=', $id)->get();
        $document = DB::table('document')->where('edit_id', '=', $id)->get();
        $document_photo = DB::table('doc_img')->select('name')->where('id', '=', $id)->get();
        $priviledge = DB::table('priviledge')->select('name')->where('rel_role_priviledge', Auth::user()->id)->get();
        $tags = DB::table('tag')->where('rel_tag_user', Auth::user()->id)->get();
        foreach ($tags as $tagValue) {
            $tagValue->color = '#' . $tagValue->color;
        }
        $summar = 0;
        $summarEdit = 0;
        foreach ($real_item as $real_items) {
            $summar = $summar + ($real_items->quantity * $real_items->price);
        }
        foreach ($edit_item as $edit_items) {
            $summarEdit = $summarEdit + ($edit_items->quantity * $edit_items->price);
        }

        return view('evidence/paperId')->with('tags', $tags)->with('priviledge', $priviledge)->with('document', $document)->with('id', $id)->with('document_photo', $document_photo)->with('real_document', $real_document)->with('real_item', $real_item)->with('sumar', $summar)->with('edit_document', $edit_document)->with('edit_item', $edit_item)->with('summarEdit', $summarEdit);
    }

    public function changeItems($id)
    {
        $selectItemsId = DB::table('edit_item')->where('edit_id', $id)->get();
        foreach ($selectItemsId as $idItem)
            DB::table('edit_item')->where('edit_id', $id)->update(['name' => request()->input($idItem->id . '_name')
                , 'price' => request()->input($idItem->id . '_price')
                , 'quantity' => request()->input($idItem->id . '_quantity')
            ]);
        $real_document = DB::table('real_document')->where('real_id', '=', $id)->get();
        $real_item = DB::table('real_item')->where('real_id', '=', $id)->get();
        $edit_document = DB::table('edit_document')->where('edit_id', '=', $id)->get();
        $edit_item = DB::table('edit_item')->where('edit_id', '=', $id)->get();
        $document = DB::table('document')->where('edit_id', '=', $id)->get();
        $document_photo = DB::table('doc_img')->select('name')->where('id', '=', $id)->get();
        $priviledge = DB::table('priviledge')->select('name')->where('rel_role_priviledge', Auth::user()->id)->get();
        $tags = DB::table('tag')->where('rel_tag_user', Auth::user()->id)->get();
        foreach ($tags as $tagValue) {
            $tagValue->color = '#' . $tagValue->color;
        }
        $summar = 0;
        $summarEdit = 0;
        foreach ($real_item as $real_items) {
            $summar = $summar + ($real_items->quantity * $real_items->price);
        }
        foreach ($edit_item as $edit_items) {
            $summarEdit = $summarEdit + ($edit_items->quantity * $edit_items->price);
        }

        return view('evidence/paperId')->with('tags', $tags)->with('priviledge', $priviledge)->with('document', $document)->with('id', $id)->with('document_photo', $document_photo)->with('real_document', $real_document)->with('real_item', $real_item)->with('sumar', $summar)->with('edit_document', $edit_document)->with('edit_item', $edit_item)->with('summarEdit', $summarEdit);
    }

    public function documentInfo($id)
    {
        $colorTag = "";
        if (request()->input('tag') != "") {
            $tagColor = DB::table('tag')->where('rel_tag_user', '=', Auth::user()->id)->where('tag', '=', request()->input('tag'))->get();
            foreach ($tagColor as $color) {
                $colorTag = $color->color;
            }

        }
        DB::table('document')->where('edit_id', $id)->update(['name' => request()->input('documentName')
            , 'date' => request()->input('documentDate')
            , 'tag' => request()->input('tag')
            , 'tag_color' => $colorTag
        ]);

        $real_document = DB::table('real_document')->where('real_id', '=', $id)->get();
        $real_item = DB::table('real_item')->where('real_id', '=', $id)->get();
        $edit_document = DB::table('edit_document')->where('edit_id', '=', $id)->get();
        $edit_item = DB::table('edit_item')->where('edit_id', '=', $id)->get();
        $document = DB::table('document')->where('edit_id', '=', $id)->get();
        $document_photo = DB::table('doc_img')->select('name')->where('id', '=', $id)->get();
        $priviledge = DB::table('priviledge')->select('name')->where('rel_role_priviledge', Auth::user()->id)->get();
        $tags = DB::table('tag')->where('rel_tag_user', Auth::user()->id)->get();
        foreach ($tags as $tagValue) {
            $tagValue->color = '#' . $tagValue->color;
        }
        $summar = 0;
        $summarEdit = 0;
        foreach ($real_item as $real_items) {
            $summar = $summar + ($real_items->quantity * $real_items->price);
        }
        foreach ($edit_item as $edit_items) {
            $summarEdit = $summarEdit + ($edit_items->quantity * $edit_items->price);
        }

        return view('evidence/paperId')->with('tags', $tags)->with('priviledge', $priviledge)->with('document', $document)->with('id', $id)->with('document_photo', $document_photo)->with('real_document', $real_document)->with('real_item', $real_item)->with('sumar', $summar)->with('edit_document', $edit_document)->with('edit_item', $edit_item)->with('summarEdit', $summarEdit);
    }

    public function paperIdShow($id)
    {

        $real_document = DB::table('real_document')->where('real_id', '=', $id)->get();
        $real_item = DB::table('real_item')->where('real_id', '=', $id)->get();
        $edit_document = DB::table('edit_document')->where('edit_id', '=', $id)->get();
        $edit_item = DB::table('edit_item')->where('edit_id', '=', $id)->get();
        $document = DB::table('document')->where('edit_id', '=', $id)->get();
        $document_photo = DB::table('doc_img')->select('name')->where('id', '=', $id)->get();
        $priviledge = DB::table('priviledge')->select('name')->where('rel_role_priviledge', Auth::user()->id)->get();
        $tags = DB::table('tag')->where('rel_tag_user', Auth::user()->id)->get();
        foreach ($tags as $tagValue) {
            $tagValue->color = '#' . $tagValue->color;
        }
        $summar = 0;
        $summarEdit = 0;
        foreach ($real_item as $real_items) {
            $summar = $summar + ($real_items->quantity * $real_items->price);
        }
        foreach ($edit_item as $edit_items) {
            $summarEdit = $summarEdit + ($edit_items->quantity * $edit_items->price);
        }

        return view('evidence/paperId')->with('tags', $tags)->with('priviledge', $priviledge)->with('document', $document)->with('id', $id)->with('document_photo', $document_photo)->with('real_document', $real_document)->with('real_item', $real_item)->with('sumar', $summar)->with('edit_document', $edit_document)->with('edit_item', $edit_item)->with('summarEdit', $summarEdit);

    }


    public function getUserSearch()
    {
        $usersID = DB::table('rel_user_user')->select('user_id')->where('ucto_id', Auth::user()->id)->get();
        $clientName = array();

        $indexDocument = 0;
        foreach ($usersID as $userID) {
            $data = DB::table('document')->select('name', 'id', 'date', 'tag', 'owner')->where('owner', $userID->user_id)->get();


            foreach ($data as $dataName) {
                $dataName->owner = DB::table('users')->where('id', $dataName->owner)->value('name') . " " . DB::table('users')->where('id', $dataName->owner)->value('surname') . " " . DB::table('users')->where('id', $dataName->owner)->value('email');
            }
            if (sizeof($data) > 0) {
                $indexDocument++;
                $name = substr(substr($data[0]->owner, strpos($data[0]->owner, " "), strlen($data[0]->owner)), strpos($data[0]->owner, " ") + 2, strlen($data[0]->owner));

                array_push($clientName, $name);
            }
        }
        return $clientName;
    }


    public function getDocumentsSearch($date, $tag, $user)
    {
        $document = array();
        $usersID = DB::table('rel_user_user')->select('user_id')->where('ucto_id', Auth::user()->id)->get();
        $clientName = array();
        $indexDocument = 0;
        if ($tag != "" && $date != "" && $user != "") {

            $idUSer = DB::table('users')->where('email', request()->input('user'))->value('id');
            $data = DB::table('document')->select('name', 'id', 'date', 'tag', 'owner')->where('owner', $idUSer)->where('date', '>=', $date)->where('tag', request()->input('tag'))->get();
            foreach ($data as $dataName) {
                $dataName->owner = DB::table('users')->where('id', $dataName->owner)->value('name') . " " . DB::table('users')->where('id', $dataName->owner)->value('surname') . " " . DB::table('users')->where('id', $dataName->owner)->value('email');
            }
            if (sizeof($data) > 0) {
                array_push($document, $data);
                $indexDocument++;
            }
            return $document;
        }
        if ($tag == "" && $date != "" && $user != "") {

            $idUSer = DB::table('users')->where('email', request()->input('user'))->value('id');
            $data = DB::table('document')->select('name', 'id', 'date', 'tag', 'owner')->where('owner', $idUSer)->where('date', '>=', $date)->get();
            foreach ($data as $dataName) {
                $dataName->owner = DB::table('users')->where('id', $dataName->owner)->value('name') . " " . DB::table('users')->where('id', $dataName->owner)->value('surname') . " " . DB::table('users')->where('id', $dataName->owner)->value('email');
            }
            if (sizeof($data) > 0) {
                array_push($document, $data);
                $indexDocument++;
            }
            return $document;
        }
        if ($tag != "" && $date == "" && $user != "") {
            $idUSer = DB::table('users')->where('email', request()->input('user'))->value('id');
            $data = DB::table('document')->select('name', 'id', 'date', 'tag', 'owner')->where('owner', $idUSer)->where('tag', request()->input('tag'))->get();
            foreach ($data as $dataName) {
                $dataName->owner = DB::table('users')->where('id', $dataName->owner)->value('name') . " " . DB::table('users')->where('id', $dataName->owner)->value('surname') . " " . DB::table('users')->where('id', $dataName->owner)->value('email');
            }
            if (sizeof($data) > 0) {
                array_push($document, $data);
                $indexDocument++;
            }
            return $document;
        }
        if ($user != "") {
            $idUSer = DB::table('users')->where('email', request()->input('user'))->value('id');
            $data = DB::table('document')->select('name', 'id', 'date', 'tag', 'owner')->where('owner', $idUSer)->get();

            foreach ($data as $dataName) {
                $dataName->owner = DB::table('users')->where('id', $dataName->owner)->value('name') . " " . DB::table('users')->where('id', $dataName->owner)->value('surname') . " " . DB::table('users')->where('id', $dataName->owner)->value('email');
            }
            if (sizeof($data) > 0) {
                array_push($document, $data);
            }
            return $document;
        }

        if ($date != "") {
            foreach ($usersID as $userID) {
                $data = DB::table('document')->select('name', 'id', 'date', 'tag', 'owner')->where('owner', $userID->user_id)->where('date', '>=', $date)->get();
                foreach ($data as $dataName) {
                    $dataName->owner = DB::table('users')->where('id', $dataName->owner)->value('name') . " " . DB::table('users')->where('id', $dataName->owner)->value('surname') . " " . DB::table('users')->where('id', $dataName->owner)->value('email');
                }
                if (sizeof($data) > 0) {
                    array_push($document, $data);
                    $indexDocument++;
                }
            }
            return $document;
        }


    }

    public function addItem($id)
    {
        session()->put('toast', 'add');
        $maxId = DB::table('edit_item')->max('id') + 1;
        DB::table('edit_item')->insert(
            ['id' => $maxId, 'edit_id' => $id, 'name' => request()->input("name"), 'price' => request()->input("price"), 'quantity' => request()->input("quantity")]
        );
         $real_document = DB::table('real_document')->where('real_id', '=', $id)->get();
        $real_item = DB::table('real_item')->where('real_id', '=', $id)->get();
        $edit_document = DB::table('edit_document')->where('edit_id', '=', $id)->get();
        $edit_item = DB::table('edit_item')->where('edit_id', '=', $id)->get();
        $document = DB::table('document')->where('edit_id', '=', $id)->get();
        $document_photo = DB::table('doc_img')->select('name')->where('id', '=', $id)->get();
        $priviledge = DB::table('priviledge')->select('name')->where('rel_role_priviledge', Auth::user()->id)->get();
        $tags = DB::table('tag')->where('rel_tag_user', Auth::user()->id)->get();
        foreach ($tags as $tagValue) {
            $tagValue->color = '#' . $tagValue->color;
        }
        $summar = 0;
        $summarEdit = 0;
        foreach ($real_item as $real_items) {
            $summar = $summar + ($real_items->quantity * $real_items->price);
        }
        foreach ($edit_item as $edit_items) {
            $summarEdit = $summarEdit + ($edit_items->quantity * $edit_items->price);
        }

        return view('evidence/paperId')->with('tags', $tags)->with('priviledge', $priviledge)->with('document', $document)->with('id', $id)->with('document_photo', $document_photo)->with('real_document', $real_document)->with('real_item', $real_item)->with('sumar', $summar)->with('edit_document', $edit_document)->with('edit_item', $edit_item)->with('summarEdit', $summarEdit);


    }

    public function delItem($id)
    {


          $idReal=DB::table('real_item')->where('real_id', '=', $id)->get();
        $idR="";
        foreach ($idReal as $ids) {
            $idR=$ids->edit_id;
        }
        

         $real_document = DB::table('real_document')->where('real_id', '=', $idR)->get();
        $real_item = DB::table('real_item')->where('real_id', '=', $idR)->get();
        $edit_document = DB::table('edit_document')->where('edit_id', '=', $idR)->get();
        $edit_item = DB::table('edit_item')->where('edit_id', '=', $idR)->get();
        $document = DB::table('document')->where('edit_id', '=', $idR)->get();
        $document_photo = DB::table('doc_img')->select('name')->where('id', '=', $idR)->get();
        $priviledge = DB::table('priviledge')->select('name')->where('rel_role_priviledge', Auth::user()->id)->get();
        $tags = DB::table('tag')->where('rel_tag_user', Auth::user()->id)->get();
        foreach ($tags as $tagValue) {
            $tagValue->color = '#' . $tagValue->color;
        }
        session()->put('toast', 'delete');
        DB::table('edit_item')->where('id', $id)->delete();
        foreach ($tags as $tagValue) {
            $tagValue->color = '#' . $tagValue->color;
        }
        $summar = 0;
        $summarEdit = 0;
        foreach ($real_item as $real_items) {
            $summar = $summar + ($real_items->quantity * $real_items->price);
        }
        foreach ($edit_item as $edit_items) {
            $summarEdit = $summarEdit + ($edit_items->quantity * $edit_items->price);
        }

        return view('evidence/paperId')->with('tags', $tags)->with('priviledge', $priviledge)->with('document', $document)->with('id', $id)->with('document_photo', $document_photo)->with('real_document', $real_document)->with('real_item', $real_item)->with('sumar', $summar)->with('edit_document', $edit_document)->with('edit_item', $edit_item)->with('summarEdit', $summarEdit);


    }

    public function delDocument($id)
    {
        session()->put('toast', 'delete');
        DB::table('real_document')->where('real_id', $id)->delete();
        DB::table('real_item')->where('real_id', $id)->delete();
        DB::table('edit_document')->where('edit_id', $id)->delete();
        DB::table('edit_item')->where('edit_id', $id)->delete();
        DB::table('doc_img')->where('doc_img', $id)->delete();
        return Redirect::back();

    }

    public function editProductInfo($id)
    {
        DB::table('edit_document')->where('edit_id', $id)->update(['company_name' => request()->input('company_name')
            , 'company_address' => request()->input('company_address')
            , 'ico' => request()->input('ico')
            , 'ic_dph' => request()->input('ic_dph')
            , 'date' => request()->input('date')
            , 'time' => request()->input('time')

        ]);
        return Redirect::back();

    }

    public function tagChange($id)
    {
        DB::table('document')->where('id', $id)->update(['tag' => request()->input('tag')]);
        return Redirect::back();

    }

    public function tagUserShow()
    {
        $userId = DB::table('users')->where('email', request()->input('id'))->value('id');
        $userTags = DB::table("tag")->select('tag')->where("rel_tag_user", $userId)->get();
        return $userTags;
    }

    //add document

    public function addDoc()
    {

        return view('evidence/addDoc');
    }

    public function safeDocument()
    {
        Session::forget('edit');
        return redirect('paperShow');
    }

//    --------------------------------------------------------------------------- ///
    public function getDocumentFolder()
    {
        $privilegios = Auth::user()->getRights(Auth::user()->id);


        if ($privilegios == 1) {
        }

        if ($privilegios == 3) {
            $usersID = DB::table('rel_user_user')->select('user_id')->where('ucto_id', Auth::user()->id)->get();
            $clientList = [];


            $arraYyears = [];
            $arraYMouth = [];
            foreach ($usersID as $userID) {
                $document = DB::table('document')->where('owner', '=', $userID->user_id)->where('type', '=', 1)->where('active', '=', 1)->orderBy('date', 'desc')->get();
                foreach ($document as $year) {

                    $date = date("Y.m", strtotime(substr($year->date, 0, 7)));
                    $string = strval($date);

                    for ($index = 0; $index < sizeof($arraYMouth); $index++) {
                        if ($arraYMouth[$index]['mounth'] == $string) {
                            $arraYMouth[$index]['count'] = $arraYMouth[$index]['count'] + 1;
                        } else {
                            $arraYMouth[] = [
                                'mounth' => $string,
                                'count' => 1,
                            ];
                        }
                    }
                    if (empty($arraYMouth)) {
                        $arraYMouth[] = [
                            'mounth' => $string,
                            'count' => 1,
                        ];
                    }
                }
                array_push($clientList, DB::table('users')->where('id', '=', $userID->user_id)->value('email'));

            }
            return view('evidence/paperFolder')->with('$arraYyears', $arraYyears)->with('document', $arraYMouth)->with('client', $clientList);

        } else {
            $document = DB::table('document')->where('owner', '=', Auth::user()->id)->where('type', '=', 1)->orderBy('date', 'desc')->get();
            $arraYyears = [];
            $arraYMouth = [];
            foreach ($document as $year) {

                $date = date("Y.m", strtotime(substr($year->date, 0, 7)));
                $string = strval($date);

                for ($index = 0; $index < sizeof($arraYMouth); $index++) {
                    if ($arraYMouth[$index]['mounth'] == $string) {
                        $arraYMouth[$index]['count'] = $arraYMouth[$index]['count'] + 1;
                    } else {
                        $helpindex = 0;
                        for ($index = 0; $index < sizeof($arraYMouth); $index++) {
                            if ($arraYMouth[$index]['mounth'] == $string) {
                                $helpindex = 1;
                            }
                        }
                        if ($helpindex == 0) {
                            $arraYMouth[] = [
                                'mounth' => $string,
                                'count' => 1,
                            ];
                        }

                    }
                }
                if (empty($arraYMouth)) {
                    $arraYMouth[] = [
                        'mounth' => $string,
                        'count' => 1,
                    ];
                }

            }
            return view('evidence/paperFolder')->with('$arraYyears', $arraYyears)->with('document', $arraYMouth);
        }

    }

    public function getDocumentMounth($date)
    {


        $years = substr($date, 0, 4);
        $mounth = substr($date, 5, 7);
        $date = $years . "-" . $mounth;
        $maxDayInMounth = date("Y-m-t", strtotime($date));
        $active = 0;
        $deactive = 0;
        $tags = DB::table('tag')->where('rel_tag_user', Auth::user()->id)->get();

        foreach ($tags as $tagValue) {
            $tagValue->color = '#' . $tagValue->color;
        }
        $privilegios = Auth::user()->getRights(Auth::user()->id);
        if ($privilegios == 1) {
            $document = DB::table('document')->select('name', 'id', 'date', 'tag')->get();
            return view('evidence/paper')->with('document', $document);
        }

        if ($privilegios == 3) {

            $usersID = DB::table('rel_user_user')->select('user_id')->where('ucto_id', Auth::user()->id)->get();
            $document = [];

            $indexDocument = 0;
            foreach ($usersID as $userID) {
                $documentHelp = DB::table('document')->where('owner', '=', $userID->user_id)->where('type', '=', 1)->where('date', '>=', $date . "-1")->where('date', '<=', $maxDayInMounth)->where('active', '=', 1)->get();
                foreach ($documentHelp as $item) {
                    $name = DB::table('users')->where('id', '=', $item->owner)->value('email');
                    $item->owner = $name;
                    array_push($document, $item);
                }
            }
            return view('evidence/paper')->with('document', $document)->with("tags", $tags)->with("date", $date);
        } else {
            $document = DB::table('document')->where('owner', '=', Auth::user()->id)->where('type', '=', 1)->where('date', '>=', $date . "-1")->where('date', '<=', $maxDayInMounth)->orderBy('name', 'desc')->get();
            foreach ($document as $documents) {
                if ($documents->active == 1) {
                    $active++;
                } else $deactive++;
            }

            return view('evidence/paper')->with('document', $document)->with("tags", $tags)->with("date", $date)->with('active', $active)->with('deactive', $deactive);
        }

    }

    function active($id)
    {
        DB::table('document')->where('id', $id)->update(['active' => 1]);
        return Redirect::back();

    }

    function deactive($id)
    {
        DB::table('document')->where('id', $id)->update(['active' => 0]);
        return Redirect::back();

    }

    function searchFolder()
    {
        if (Auth::user()->getRights(Auth::user()->id) == 2) {
            $arraYMouth = [];
            $date = request()->input('year') . "-" . "1-1";
            $maxMouthYear = request()->input('year') . "-" . "12-31";
            $document = DB::table('document')->where('date', '>=', $date)->where('date', '<=', $maxMouthYear)->where('owner', '=', Auth::user()->id)->where('type', '=', 1)->orderBy('date', 'desc')->get();
            foreach ($document as $year) {

                $date = date("Y.m", strtotime(substr($year->date, 0, 7)));
                $string = strval($date);

                for ($index = 0; $index < sizeof($arraYMouth); $index++) {
                    if ($arraYMouth[$index]['mounth'] == $string) {
                        $arraYMouth[$index]['count'] = $arraYMouth[$index]['count'] + 1;
                    } else {
                        $arraYMouth[] = [
                            'mounth' => $string,
                            'count' => 1,
                        ];
                    }
                }
                if (empty($arraYMouth)) {
                    $arraYMouth[] = [
                        'mounth' => $string,
                        'count' => 1,
                    ];
                }

            }            

            return view('evidence/paperFolder')->with('document', $arraYMouth);
        }


        if (Auth::user()->getRights(Auth::user()->id) == 3) {

            $usersID = DB::table('rel_user_user')->select('user_id')->where('ucto_id', Auth::user()->id)->get();
            $clientList = [];
            foreach ($usersID as $userID) {
                array_push($clientList, DB::table('users')->where('id', '=', $userID->user_id)->value('email'));
            }
            $arraYyears = [];
            $arraYMouth = [];
//        request()->input('client');
//        if (request()->input('client') != "Vyber klienta" && request()->input('year') != "Vyber Rok:") {
//            $idUser = DB::table('users')->where('email', '=', request()->input('client'))->value('id');
//            $date = request()->input('year') . "-" . "1-1";
//            $maxMouthYear = request()->input('year') . "-" . "12-31";
//            $document = DB::table('document')->select('name', 'id', 'date', 'tag')->where('date', '>=', $date)->where('date', '<=', $maxMouthYear)->where('owner', '=', $idUser)->where('type', '=', 1)->orderBy('date', 'desc')->get();
//            foreach ($document as $year) {
//
//                if (!in_array(date("Y-m-t", strtotime(substr($year->date, 0, 7))), $arraYyears)) {
//                    array_push($arraYyears, date("Y-m-t", strtotime(substr($year->date, 0, 7))));
//                }
//                if (!in_array(date("Y.m", strtotime(substr($year->date, 0, 7))), $arraYMouth)) {
//                    array_push($arraYMouth, date("Y.m", strtotime(substr($year->date, 0, 7))));
//                }
//            }
//            // return view('evidence/paperFolder')->with('$arraYyears', $arraYyears)->with('document', $arraYMouth)->with("client",$clientList);
//        } else if (request()->input('client') != "Vyber klienta") {
//            $idUser = DB::table('users')->where('email', '=', request()->input('client'))->value('id');
//
//            $document = DB::table('document')->where('owner', '=', $idUser)->where('type', '=', 1)->orderBy('date', 'desc')->get();
//            foreach ($document as $year) {
//
//                if (!in_array(date("Y-m-t", strtotime(substr($year->date, 0, 7))), $arraYyears)) {
//                    array_push($arraYyears, date("Y-m-t", strtotime(substr($year->date, 0, 7))));
//                }
//                if (!in_array(date("Y.m", strtotime(substr($year->date, 0, 7))), $arraYMouth)) {
//                    array_push($arraYMouth, date("Y.m", strtotime(substr($year->date, 0, 7))));
//                }
//            }
//        } else

            if (request()->input('year') != "Vyber Rok:") {
                $usersID = DB::table('rel_user_user')->select('user_id')->where('ucto_id', Auth::user()->id)->get();
                $date = request()->input('year') . "-" . "1-1";
                $maxMouthYear = request()->input('year') . "-" . "12-31";
                foreach ($usersID as $userID) {
                    $document = DB::table('document')->select('name', 'id', 'date', 'tag')->where('active', 1)->where('date', '>=', $date)->where('date', '<=', $maxMouthYear)->where('owner', '=', $userID->user_id)->where('type', '=', 1)->orderBy('date', 'desc')->get();
                    foreach ($document as $year) {

                        $date = date("Y.m", strtotime(substr($year->date, 0, 7)));
                        $string = strval($date);

                        for ($index = 0; $index < sizeof($arraYMouth); $index++) {
                            if ($arraYMouth[$index]['mounth'] == $string) {
                                $arraYMouth[$index]['count'] = $arraYMouth[$index]['count'] + 1;
                            } else {
                                $arraYMouth[] = [
                                    'mounth' => $string,
                                    'count' => 1,
                                ];
                            }
                        }
                        if (empty($arraYMouth)) {
                            $arraYMouth[] = [
                                'mounth' => $string,
                                'count' => 1,
                            ];
                        }
                    }
                }
            }            
            return view('evidence/paperFolder')->with('$arraYyears', $arraYyears)->with('document', $arraYMouth)->with("client", $clientList);
        }
    }

    function searchUser()
    {
        $tags = DB::table('tag')->where('rel_tag_user', Auth::user()->id)->get();
        $years = substr(request()->input('date'), 0, 4);
        $mounth = substr(request()->input('date'), 5, 7);
        $date = $years . "-" . $mounth;
        $maxDayInMounth = date("Y-m-t", strtotime($date));
        if (request()->input("tag") != "") {
            $document = DB::table('document')->select('name', 'id', 'date', 'tag')->where('tag', request()->input('tag'))->where('owner', '=', Auth::user()->id)->where('type', '=', 1)->where('date', '>=', $date . "-1")->where('date', '<=', $maxDayInMounth)->get();
            return view('evidence/paper')->with('document', $document)->with("tags", $tags)->with("date", $date);
        }
        if (request()->input('year')) {
            $date = request()->input('year') . "-" . "1-1";
            $maxMouthYear = request()->input('year') . "-" . "12-31";
            $document = DB::table('document')->select('name', 'id', 'date', 'tag')->where('date', '>=', $date)->where('date', '<=', $maxMouthYear)->where('owner', '=', Auth::user()->id)->where('type', '=', 1)->orderBy('date', 'desc')->get();
            $arraYyears = [];
            $arraYMouth = [];
            foreach ($document as $year) {

                if (!in_array(date("Y-m-t", strtotime(substr($year->date, 0, 7))), $arraYyears)) {
                    array_push($arraYyears, date("Y-m-t", strtotime(substr($year->date, 0, 7))));
                }
                if (!in_array(date("Y.m", strtotime(substr($year->date, 0, 7))), $arraYMouth)) {
                    array_push($arraYMouth, date("Y.m", strtotime(substr($year->date, 0, 7))));
                }
            }

            return view('evidence/paperFolder')->with('$arraYyears', $arraYyears)->with('document', $arraYMouth)->with("tags", $tags);

        } else {
            $document = DB::table('document')->select('name', 'id', 'date', 'tag')->where('owner', '=', Auth::user()->id)->where('type', '=', 1)->where('date', '>=', $date . "-1")->where('date', '<=', $maxDayInMounth)->get();
            return view('evidence/paper')->with('document', $document)->with("tags", $tags)->with("date", $date);
        }


    }


}
