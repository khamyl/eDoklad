<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Intervention\Image\Facades\Image;
use App\User;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Routing\ControllerMiddlewareOptions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class UploadImage extends Controller
{


    private $photos_path;

    public function __construct()
    {
        $this->photos_path = public_path('/image/paper/');
    }

    /**
     * Display all of the images.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $photos = Upload::all();
        return view('uploaded-images', compact('photos'));
    }

    /**
     * Show the form for creating uploading new images.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('upload');
    }

    /**
     * Saving images uploaded through XHR Request.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        ini_set('max_execution_time', 300);
        $photos = $request->file('file');

        if (!is_array($photos)) {
            $photos = [$photos];
        }

        if (!is_dir($this->photos_path)) {
            mkdir($this->photos_path, 0777);
        }

        for ($i = 0; $i < count($photos); $i++) {
            $photo = $photos[$i];
            $save_name = Auth::user()->id.'_'.date('Y_m_d').time().'.jpg';
            $photo->move($this->photos_path, $save_name);

        }
        DB::table("doc_img")->insert([
            'id'=>DB::table('doc_img')->max('id')+1,
            'name'=>$save_name,
            'doc_img'=>DB::table('doc_img')->max('id')+1,
            'user'=>Auth::user()->id
        ]);


        $ocr=new OcrController();
        $ocr->ocrEcho();

    }

    public function safeImg()
    {


        $destinationPath = public_path() . '/image/paper/';

        $file = str_replace('data:image/png;base64,', '', request()->input('img'));
        $img = str_replace(' ', '+', $file);
        $data = base64_decode($img);
        $filename = Auth::user()->id . '_' . date('Y_m_d') . time().".jpg";
        $file = $destinationPath . $filename;
        $success = file_put_contents($file, $data);
        echo (request()->input('img'));

        DB::table("doc_img")->insert([
            'id' => DB::table('doc_img')->max('id') + 1,
            'name' => $filename,
            'doc_img' => DB::table('doc_img')->max('id') + 1,
            'user' => Auth::user()->id
        ]);

    }

    /**
     * Remove the images from the storage.
     *
     * @param Request $request
     */
    public function destroy(Request $request)
    {
        $filename = $request->id;
        $uploaded_image = Upload::where('original_name', basename($filename))->first();

        if (empty($uploaded_image)) {
            return Response::json(['message' => 'Sorry file does not exist'], 400);
        }

        $file_path = $this->photos_path . '/' . $uploaded_image->filename;
        $resized_file = $this->photos_path . '/' . $uploaded_image->resized_name;

        if (file_exists($file_path)) {
            unlink($file_path);
        }

        if (file_exists($resized_file)) {
            unlink($resized_file);
        }

        if (!empty($uploaded_image)) {
            $uploaded_image->delete();
        }

        return Response::json(['message' => 'File successfully delete'], 200);
    }


}
