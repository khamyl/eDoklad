<?php

namespace App\Http\Controllers;

use App\Document;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use thiagoalessio\TesseractOCR\TesseractOCR;

class MobilController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     *
     */


    public function __construct()
    {

    }

    public function loginMobil()
    {

        if (Auth::attempt(['email' => request()->input('email'), 'password' => request()->input('password')])) {
            return 'succ';
        } else {
            return "neopravnena osoba";
        }

    }

    public function uploadImage(Request $request)
    {


        if (Auth::attempt(['email' => request()->input('email'), 'password' => request()->input('pass')])) {
            $name = Auth::user()->id . '_' . date('Y_m_d') . time();
            $path = 'image/paper/' . $name . '.jpg';
            file_put_contents(public_path($path), base64_decode($_POST['image']));
            DB::table("doc_img")->insert([
                'id' => DB::table('doc_img')->max('id') + 1,
                'name' => $name . ".jpg",
                'doc_img' => DB::table('doc_img')->max('id') + 1,
                'user' => Auth::user()->id
            ]);


        }

        $ocr = new OcrController();
        $ocr->ocrEcho();

        $id = DB::table('document')->select('edit_id')->where("owner", '=', Auth::user()->id)->get();
        $idReal = "";

        foreach ($id as $idF) {
            $idReal = $idF->edit_id;

        }
        $edit_document = DB::table('edit_document')->where('edit_id', "=", $idReal)->get();
        $myObj = [];
        foreach ($edit_document as $data) {
            echo json_encode(array('response' => 'Upload succesful'));
            $myObj[] = [
                'prevadzka' => $data->company_name,
                'adresa' => $data->company_address,
                'ICO' => $data->ico,
                'IC_DKP' => $data->ic_dph,
                'datum' => $data->date,
                'cas' => $data->time,
                'dkp' => $data->dpk,
                'celkom' => $data->summar
            ];

            $myJSON = json_encode($myObj[0], JSON_UNESCAPED_UNICODE);

            echo $myJSON;
        }


    }

    public function dashboard(Request $request)
    {
        if (Auth::attempt(['email' => request()->input('email'), 'password' => request()->input('pass')])) {
            $idUser = DB::table('users')->where("email", '=', request()->input('email'))->get();
            $id = 0;
            foreach ($idUser as $id) {
                $id = $id->id;
            }

            $idDocument = DB::table('document')->where('owner', '=', Auth::user()->id)->get();
            $document = [];
            foreach ($idDocument as $id) {
                $document[] = DB::table('edit_document')->select('edit_document.date', 'edit_document.company_name', 'edit_document.summar')
                    ->leftJoin('document', 'edit_document.edit_id', '=', 'document.edit_id')->orderBy('edit_document.edit_id', 'DESC')->where('edit_document.edit_id', $id->edit_id)
                    ->get();
            }

            $myObj = [];
            foreach ($document as $doc) {
                foreach ($doc as $d) {
                    $myObj[] = [
                        'datum' => $d->date,
                        'prevadzka' => $d->company_name,
                        'adresa' => $d->summar,
                    ];
                }
            }
            $myJSON = json_encode(array('data' => $myObj), JSON_UNESCAPED_UNICODE);

            echo $myJSON;


        }
    }

    public function uploadSafeMobil(Request $request)
    {
        if (Auth::attempt(['email' => request()->input('email'), 'password' => request()->input('pass')])) {
            $id = DB::table('document')->select('edit_id')->where("owner", '=', Auth::user()->id)->get();
            $idReal = "";

            foreach ($id as $idF) {
                $idReal = $idF->edit_id;

            }
            DB::table('edit_document')->where('edit_id', '=', $idReal)->update([
                "company_name" => request()->input('prevadzka'),
                "company_address" => request()->input('adresa'),
                "summar" => request()->input('celkom'),
                "ico" => request()->input('ICO'),
                "ic_dph" => request()->input('IC_DKP')
            ]);

        }
    }


}
