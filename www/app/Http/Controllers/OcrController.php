<?php

namespace App\Http\Controllers;

use App\real_document;
use App\User;
use function GuzzleHttp\Psr7\str;
use http\Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use function Sodium\add;
use thiagoalessio\TesseractOCR\TesseractOCR;

class OcrController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function getData()
    {
        $onlyName="Lidl";
        $filename = asset("texty\\".$onlyName.".txt");
        $handle = fopen($filename, "r");
        $hasIco = false;
        $hasDkp = false;
        $hasSum = false;
        $hasDph = false;
        $hasDate = false;
        $hasTime = false;
        $date = "";
        $time = "";
        $ico = "";
        $dkp = "";
        $Sum = 0.0;
        $dph = 0.0;
        $lineNumber=0;
        $numLinForDelete=array();

        if ($handle) {
            while (($line = fgets($handle)) !== false) {
                $line = mb_strtoupper($line);
                $line = preg_replace('/\s+/', '', $line);
                $line = " " . $line;
                $line = preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\n", $line);
                $lineNumber++;
                /**IČO*/
                if (!$hasIco) {
                    if (mb_ereg("[\[\]\(\)\{\}1I]Č[0O]?:", $line) && !strpos($line, "DIČ")) {
                        $line = preg_replace("/[\[\]\(\)\{\}1I]Č[0O]?:/", "IČO:", $line);
                        $ico = substr($line, strpos($line, "IČO:") + 5, 8);
                        $hasIco = true;
                        $isLine=false;
                        foreach ($numLinForDelete as $row){
                            if ($row==$lineNumber){
                                $isLine=true;
                                break;
                            }
                        }
                        if (!$isLine){
                            array_push($numLinForDelete,$lineNumber);
                        }
                    }
                }

                /**DKP*/
                if (!$hasDkp) {
                    if (mb_ereg("[DO0]K[P]", $line)) {
                        $line = preg_replace("/[DO0]K[PB]/", "DKP:", $line);
                        if (mb_strlen($line) == mb_strpos($line, "DKP:") + 22) {
                            $dkp = substr($line, strpos($line, "DKP:") + 5, 17);
                            $hasDkp = true;
                        } else if (mb_strlen($line) == mb_strpos($line, "DKP:") + 21) {
                            $dkp = substr($line, strpos($line, "DKP:") + 5, 16);
                            $hasDkp = true;
                        } else if (mb_strlen($line) < mb_strpos($line, "DKP:") + 21) {
                            $dkp = substr($line, strpos($line, "DKP:") + 5);
                            $hasDkp = true;
                        }
                        $isLine=false;
                        foreach ($numLinForDelete as $row){
                            if ($row==$lineNumber){
                                $isLine=true;
                                break;
                            }
                        }
                        if (!$isLine){
                            array_push($numLinForDelete,$lineNumber);
                        }
                    }
                }
                /**Datum*/
                if (!$hasDate) {
                    $pattern = "[0-3]?[0-9][-|.|,][0-1]?[0-9][-|.|,][1-2]([0-9]{3})?";
                    if (mb_ereg($pattern, $line)) {
                        $date = $line;
                        $date = trim(preg_replace("/[,-]/", ".", $date));
                    }
                    if (strlen($date) > 0) {
                        if (preg_match('/[0-3]?[0-9]\.[0-1]?[0-9]\.[1-2]([0-9]{3})?/', $date, $matches, PREG_OFFSET_CAPTURE)) {
                            $date = implode('-', explode('.', $matches[0][0]));
                        } else {
                            $date = date("d-m-Y");
                        }
                        $hasDate = true;
                        $isLine=false;
                        foreach ($numLinForDelete as $row){
                            if ($row==$lineNumber){
                                $isLine=true;
                                break;
                            }
                        }
                        if (!$isLine){
                            array_push($numLinForDelete,$lineNumber);
                        }
                    }
                }
                /**ČAS*/
                if (!$hasTime) {
                    $pattern1 = "[0-2][0-9]:[0-5][0-9]:([0-5][0-9])?";
                    $pattern2 = "[0-2][0-9]:([0-5][0-9])?";
                    if (mb_ereg($pattern1, $line)) {
                        $time = $line;
                        //$date = preg_replace("/[,-]/", ".", $date);
                    } else if (mb_ereg($pattern2, $line)) {
                        $time = $line;
                    }
                    if (strlen($time) > 0) {
                        if (preg_match('/[0-2][0-9]:[0-5][0-9]:([0-5][0-9])?/', $time, $matches, PREG_OFFSET_CAPTURE)) {
                            $time = $matches[0][0];
                        } else if (preg_match('/[0-2][0-9]:([0-5][0-9])?/', $time, $matches, PREG_OFFSET_CAPTURE)) {
                            $time = $matches[0][0];
                        }

                        $hasTime = true;
                        $isLine=false;
                        foreach ($numLinForDelete as $row){
                            if ($row==$lineNumber){
                                $isLine=true;
                                break;
                            }
                        }
                        if (!$isLine){
                            array_push($numLinForDelete,$lineNumber);
                        }
                    }
                }

                /**SUMA*/
                if (!$hasSum) {
                    $pattern1 = "C?ELK[OU]M";
                    $pattern2 = "SUMA";
                    $commasPosition = array();
                    $prices = array();
                    $lengthOfLine = 0;
                    if (mb_ereg($pattern1, $line) || mb_ereg($pattern2, $line)) {
                        if (mb_ereg($pattern1, $line)) {
                            $line = preg_replace("/C?ELK[OU]M/", "CELKOM:", $line);
                        } else {
                            $line = preg_replace("/SUMA/", "CELKOM:", $line);
                        }
                        $line = preg_replace("/[^,.0-9]/", "", $line);
                        $line  = preg_replace("/,/", ".", $line);
                        $lineInArray = str_split($line);
                        /**Rozdelenie riadku podla des ciarok*/
                        for ($i = 0; $i < count($lineInArray); $i++) {
                            if ($lineInArray[$i] == "," || $lineInArray[$i] == ".") {
                                array_push($commasPosition, $i);
                            }
                        }
                        for ($i = count($commasPosition) - 1; $i > -1; $i--) {
                            if ($i != 0) {
                                array_push($prices, substr($line, ($commasPosition[$i - 1]) + 3, count($lineInArray) - (($commasPosition[$i - 1]) + 2)));
                                $lengthOfLine += ($commasPosition[$i - 1]) + 2;
                            } else {
                                array_push($prices, substr($line, 0, count($lineInArray) - $lengthOfLine));
                            }
                        }
                        if (count($prices)>0) {
                            $Sum = max($prices);
                        }
                        if (count($prices)>0 && $dph==0) {
                            $dph = min($prices);
                        }
                        $hasSum=true;
                        $isLine=false;
                        foreach ($numLinForDelete as $row){
                            if ($row==$lineNumber){
                                $isLine=true;
                                break;
                            }
                        }
                        if (!$isLine){
                            array_push($numLinForDelete,$lineNumber);
                        }
                    }
                }
                /**DPH*/
                if (!$hasDph){
                    $commasPosition = array();
                    $prices = array();
                    $lengthOfLine=0;
                    if (mb_ereg("DPH", $line) && !strpos($line, "IČ")){
                        while (!mb_ereg("[0-9]",$line)){
                            $line = fgets($handle);
                            if(!mb_ereg("[0-9]",$line)) {
                                $line = fgets($handle);
                            }
                            break;
                        }
                        $line  = preg_replace("/,/", ".", $line);
                        $line=$line = preg_replace('/20%/', '', $line);
                        $line=$line = preg_replace('/20..00%/', '', $line);
                        $line=$line = preg_replace('/ /', '', $line);
                        $line = preg_replace("/[^,.0-9]/", "", $line);
                        $lineInArray = str_split($line);
                        /**Rozdelenie riadku podla des ciarok*/
                        for ($i = 0; $i < count($lineInArray); $i++) {
                            if ($lineInArray[$i] == ".") {
                                array_push($commasPosition, $i);
                            }
                        }
//                        for ($i = 0; $i < count($commasPosition); $i++) {
//                            echo $commasPosition[$i]."<br>";
//                        }

                        for ($i = count($commasPosition) - 1; $i > -1; $i--) {
                            if(count($commasPosition)==1){
                                array_push($prices ,substr($line,0,$commasPosition[0]+3));
                            }
                            else if ($i != 0 ) {
                                $aaaauto=(($commasPosition[$i - 1]) + 2);
                                array_push($prices, substr($line, ($commasPosition[$i- 1]) + 3, count($lineInArray) - $aaaauto - $lengthOfLine + 2));
                                $lengthOfLine += ($commasPosition[$i - 1]) + 2;
                            }
                            else {
                                array_push($prices, substr($line, 0, count($lineInArray) - $lengthOfLine-1));
                            }
                        }
//                        for ($i = 0; $i < count($commasPosition); $i++) {
//                            echo $prices[$i]."<br>";
//                        }
                        if (count($prices)>0) {
                            $dph = min($prices);
                        }
                        if (count($prices)>0 && $Sum==0) {
                            $Sum = max($prices);
                        }
                        $hasDph=true;
                        $isLine=false;
                        foreach ($numLinForDelete as $row){
                            if ($row==$lineNumber){
                                $isLine=true;
                                break;
                            }
                        }
                        if (!$isLine){
                            array_push($numLinForDelete,$lineNumber);
                        }
                    }
                }
            }
        } else {
            echo "Neide";
            exit();

        }
        echo "IČO: " . $ico . "<br>";
        echo "DKP: " . $dkp . "<br>";
        echo "CELKOM: " . $Sum . "€<br>";
        echo "DPH: " . $dph . "€<br>";
        echo "Dátum: " . $date . "<br>";
        echo "Čas: " . $time . "<br>";

//        for ($i = 0; $i < count($numLinForDelete); $i++) {
//                            echo $numLinForDelete[$i]."<br>";
//                        }
        fclose($handle);

        /**Jednotlive polozky*/
        $copy="texty\\".$onlyName."copy.txt";
        if (!copy($filename, $copy)) {
            echo "failed to copy $filename...\n";
        }
        /**Vytvor kopiu txt*/
        //----------------------------------------------------------
        $lines = file($copy);
        $numOfLine=0;
        $breakingPoint=10000;
        /**Vymaze vsetko od oddelenia zatial iba hviezdickami smerom dole*/
        foreach ($lines as $line) {
            $numOfLine++;
            if (mb_ereg("[*][*][*]+", $line)) {
                $breakingPoint=$numOfLine;
                break;
            }
            else if ($breakingPoint==10000 && mb_ereg("[.][.][.]+", $line)){
                $breakingPoint=$numOfLine;
                break;
            }
            else if ($breakingPoint==10000 && mb_ereg("MEDZISÚČET", $line)){
                $breakingPoint=$numOfLine;
                break;
            }
        }
        //----------------------------------------------------------
        $out="";
        $line_no = 0;
        $indexOfRowForDelete=0;
        /**zmaze to co uz mame vyselectovane*/
        foreach($lines as $line) {
            $line_no++;
            if ($line_no== $numLinForDelete[$indexOfRowForDelete] || $line_no>=$breakingPoint) {
                $out .= "";
                if ($indexOfRowForDelete<count($numLinForDelete)-1){
                    $indexOfRowForDelete++;
                }
            }
            else {$out.=$line;}
        }
        $f = fopen($copy, "w");
        fwrite($f, $out);
        fclose($f);
        //------------------------------------
        /**Hladanie poloziek*/
        $handle = fopen($copy, "r");
        $handle2 = fopen($copy,"r");
        $nameOfBoughtThings = array();
        $countBoughtThings = array();
        $pricesOfBoughtThings = array();
        $nextLine = fgets($handle2);
        $dotPosition = 0;
        $countOfDots = 0;
        $startCountPosition=0;
        if ($ico=="35790164" || $ico == "35793783"){
            while (($line = fgets($handle)) !== false) {
                $line = preg_replace('/,/', '.', $line);
                $line = preg_replace('/\s+/', '', $line);
                $lengthOfCount = 0;
                if (mb_ereg("[a-zA-Z]", $line) && mb_ereg("[0-9]\.", $line) && mb_ereg("ks", mb_strtolower($line))) {
                    $ksPosition = strpos(mb_strtolower($line), "ks")-1;
                    $lineInArray = $lineInArray = str_split($line);
                    /**pocet*/
                    for ($i = $ksPosition; $i > -1; $i--) {
                        $lengthOfCount++;
                        if (!is_numeric($lineInArray[$i])) {
                            $startCountPosition = $i+1;
                            break;
                        }
                    }
                    if ($lengthOfCount>1) {
                        array_push($countBoughtThings,substr($line, $startCountPosition, $lengthOfCount - 1));
                    }
                    else{array_push($countBoughtThings, 1);}
                    /**nazvy poloziek*/
                    array_push($nameOfBoughtThings,substr($line,0,$startCountPosition));
                    /**cena*/
                    /**hladanie des. ciarky*/
                    for ($i = count($lineInArray) - 1; $i > -1; $i--) {
                        if ($lineInArray[$i] == ".") {
                            $dotPosition = $i;
                            $lengthOfPrice = 1;
                            break;
                        }
                    }
                    /**Zistovanie dlzky ceny za polozku a startovnej pozicie ceny*/
                    $startPricePosition = 0;
                    for ($i = $dotPosition - 1; $i > -1; $i--) {
                        $lengthOfPrice++;
                        if (!is_numeric($lineInArray[$i])) {
                            $startPricePosition = $i + 1;
                            break;
                        }
                    }
                    if ($lengthOfPrice <= 1) {
                        array_push($pricesOfBoughtThings, "0.00");
                    } else {
                        array_push($pricesOfBoughtThings, substr($line, $startPricePosition, $lengthOfPrice + 1));
                    }
                    $countOfDots = 0;
                }
            }
        }
        else {
            while (($line = fgets($handle)) !== false) {
                if (($nextLine = fgets($handle2)) !== false) {
                    $nextLine = preg_replace('/,/', '.', $nextLine);
                    /**nazvy poloziek*/
                    if (mb_ereg("[a-zA-Z]", $line) && mb_ereg("[0-9]\.", $nextLine)) {
                        array_push($nameOfBoughtThings, $line);
                        $nextLine = preg_replace('/\s+/', '', $nextLine);
                        $lineInArray = str_split($nextLine);
                        for ($i = 0; $i < count($lineInArray); $i++) {
                            if ($lineInArray[$i] == ".") {
                                $countOfDots++;
                            }
                        }
                        $indexOfDot = 0;
                        /**pocet kusov*/
                        if (mb_ereg("ks", $nextLine) && $countOfDots == 1) {
                            $count = mb_strtoupper(substr($nextLine, 0, strpos($nextLine, "ks")));
                            $count = preg_replace('[I]', '1', $count);
                            array_push($countBoughtThings, $count);
                        } else if ($countOfDots > 1) {
                            for ($i = 0; $i < count($lineInArray); $i++) {
                                if ($lineInArray[$i] == ".") {
                                    $indexOfDot = $i;
                                }
                            }
                            $lengthOfCount = 0;
                            for ($i = $indexOfDot; $i > -1; $i--) {
                                $lengthOfCount++;
                                if (!is_numeric($lineInArray[$i])) {
                                    $startCountPosition = $i + 1;
                                    break;
                                }
                            }
                            array_push($countBoughtThings, substr($nextLine, $startCountPosition, $lengthOfCount));
                        } else {
                            array_push($countBoughtThings, 1);
                        }
                        $lengthOfPrice = 0;
                        /**hladanie des. ciarky*/
                        for ($i = count($lineInArray) - 1; $i > -1; $i--) {
                            if ($lineInArray[$i] == ".") {
                                $dotPosition = $i;
                                $lengthOfPrice = 1;
                                break;
                            }
                        }
                        /**Zistovanie dlzky ceny za polozku a startovnej pozicie ceny*/
                        $startPricePosition = 0;
                        for ($i = $dotPosition - 1; $i > -1; $i--) {
                            $lengthOfPrice++;
                            if (!is_numeric($lineInArray[$i])) {
                                $startPricePosition = $i + 1;
                                break;
                            }
                        }
                        if ($lengthOfPrice <= 1) {
                            array_push($pricesOfBoughtThings, "0.00");
                        } else {
                            array_push($pricesOfBoughtThings, substr($nextLine, $startPricePosition, $lengthOfPrice + 1));
                        }
                        $countOfDots = 0;
                    }
                }
            }
        }
        for ($i = 0; $i < count($nameOfBoughtThings); $i++) {
            echo $nameOfBoughtThings[$i]." POČET: ".$countBoughtThings[$i]." CENA: ".$pricesOfBoughtThings[$i]."€<br>";
        }
        fclose($handle);
        fclose($handle2);
        unlink($copy);
    }


    public function startOcr(){
        $this->ocrEcho();
        $id = DB::table('document')->select('edit_id')->where("owner", '=', Auth::user()->id)->get();
        $idReal = "";

        foreach ($id as $idF) {
            $idReal = $idF->edit_id;

        }

        $real_document = DB::table('real_document')->where('real_id', '=', $idReal)->get();
        $real_item = DB::table('real_item')->where('real_id', '=', $idReal)->get();
        $edit_document = DB::table('edit_document')->where('edit_id', '=', $idReal)->get();
        $edit_item = DB::table('edit_item')->where('edit_id', '=', $idReal)->get();
        $document = DB::table('document')->where('edit_id', '=', $idReal)->get();
        $document_photo = DB::table('doc_img')->select('name')->where('id', '=', $idReal)->get();
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

        return view('evidence/paperId')->with('tags', $tags)->with('priviledge', $priviledge)->with('document',$document)->with('id', $id)->with('document_photo', $document_photo)->with('real_document', $real_document)->with('real_item', $real_item)->with('sumar', $summar)->with('edit_document', $edit_document)->with('edit_item', $edit_item)->with('summarEdit', $summarEdit);


    }


    public function ocrEcho()
    {
        ini_set('max_execution_time', 300);
        $photo = DB::table('doc_img')->select('name')->where('user', '=', Auth::user()->id)->get();
        $namePhoto = "";
        foreach ($photo as $photoName) {
            $namePhoto = $photoName->name;
        }

        $txt = "";
        $privilegios = Auth::user()->getRights(Auth::user()->id);;
        if ($privilegios == 2) {

            try {

                $tesseract = new  TesseractOCR;
                $tesseract->image('../public/image/paper/' . $namePhoto);
                $tesseract->lang('slk');
                $handle = $tesseract->run();
                $handle = mb_strtoupper($handle);
                $hasIco = false;
                $hasDkp = false;
                $hasSum = false;
                $hasDph = false;
                $hasDate = false;
                $hasTime = false;
                $date = "";
                $time = "";
                $ico = "";
                $dkp = "";
                $Sum = 0.0;
                $dph = 0.0;
                $txt = $handle . "\n";
                $lineNumber=0;
                $numLinForDelete=array();

                if ($handle) {
                    $handle = explode("\n", $handle);
                    for ($index = 0, $count = count($handle); $index < $count; $index++) {
                        $line = $handle[$index];
                        $line = preg_replace('/\s+/', '', $line);
                        $line = " " . $line;
                        $line = preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\n", $line);

                        /**IČO*/
                        if (!$hasIco) {
                            if (mb_ereg("[\[\]\(\)\{\}1I][ČC][0O]?:", $line) && !strpos($line, "DIČ")) {
                                $line = preg_replace("/[\[\]\(\)\{\}1I]Č[0O]?:/", "IČO:", $line);
                                $ico = substr($line, strpos($line, "IČO:") + 5, 8);
                                $hasIco = true;
                            }
                        }

                        /**DKP*/
                        if (!$hasDkp) {
                            if (mb_ereg("[DO0]K[P]", $line)) {
                                $line = preg_replace("/[DO0]K[PB]/", "DKP:", $line);
                                if (mb_strlen($line) == mb_strpos($line, "DKP:") + 22) {
                                    $dkp = substr($line, strpos($line, "DKP:") + 5, 17);
                                    $hasDkp = true;
                                } else if (mb_strlen($line) == mb_strpos($line, "DKP:") + 21) {
                                    $dkp = substr($line, strpos($line, "DKP:") + 5, 16);
                                    $hasDkp = true;
                                } else if (mb_strlen($line) < mb_strpos($line, "DKP:") + 21) {
                                    $dkp = substr($line, strpos($line, "DKP:") + 5);
                                    $hasDkp = true;
                                }
                            }
                        }
                        /**Datum*/
                        if (!$hasDate) {
                            $pattern = "[0-3]?[0-9][-|.|,][0-1]?[0-9][-|.|,][1-2]([0-9]{3})?";
                            if (mb_ereg($pattern, $line)) {
                                $date = $line;
                                $date = trim(preg_replace("/[,-]/", ".", $date));
                            }
                            if (strlen($date) > 0) {
                                if (preg_match('/[0-3]?[0-9]\.[0-1]?[0-9]\.[1-2]([0-9]{3})?/', $date, $matches, PREG_OFFSET_CAPTURE)) {
                                    $date = implode('-', explode('.', $matches[0][0]));
                                    $date = date("Y-m-d", strtotime($date));
                                } else {
                                    $date = date("Y-m-d");
                                }
                                $hasDate = true;
                            }
                        }
                        /**ČAS*/
                        if (!$hasTime) {
                            $pattern1 = "[0-2][0-9]:[0-5][0-9]:([0-5][0-9])?";
                            $pattern2 = "[0-2][0-9]:([0-5][0-9])?";
                            if (mb_ereg($pattern1, $line)) {
                                $time = $line;
                                //$date = preg_replace("/[,-]/", ".", $date);
                            } else if (mb_ereg($pattern2, $line)) {
                                $time = $line;
                            }
                            if (strlen($time) > 0) {
                                if (preg_match('/[0-2][0-9]:[0-5][0-9]:([0-5][0-9])?/', $time, $matches, PREG_OFFSET_CAPTURE)) {
                                    $time = $matches[0][0];
                                } else if (preg_match('/[0-2][0-9]:([0-5][0-9])?/', $time, $matches, PREG_OFFSET_CAPTURE)) {
                                    $time = $matches[0][0];
                                } else {
                                    $date = time();
                                }
                                $hasTime = true;
                            }
                        }
                        /**SUMA*/
                        if (!$hasSum) {
                            $pattern1 = "C?ELK[OU]M";
                            $pattern2 = "SUMA";
                            $commasPosition = array();
                            $prices = array();
                            $lengthOfLine = 0;
                            if (mb_ereg($pattern1, $line) || mb_ereg($pattern2, $line)) {
                                if (mb_ereg($pattern1, $line)) {
                                    $line = preg_replace("/C?ELK[OU]M/", "CELKOM:", $line);
                                } else {
                                    $line = preg_replace("/SUMA/", "CELKOM:", $line);
                                }
                                $line = preg_replace("/[^,.0-9]/", "", $line);
                                $line  = preg_replace("/,/", ".", $line);
                                $lineInArray = str_split($line);
                                /**Rozdelenie riadku podla des ciarok*/
                                for ($i = 0; $i < count($lineInArray); $i++) {
                                    if ($lineInArray[$i] == "," || $lineInArray[$i] == ".") {
                                        array_push($commasPosition, $i);
                                    }
                                }
                                for ($i = count($commasPosition) - 1; $i > -1; $i--) {
                                    if ($i != 0) {
                                        array_push($prices, substr($line, ($commasPosition[$i - 1]) + 3, count($lineInArray) - (($commasPosition[$i - 1]) + 2)));
                                        $lengthOfLine += ($commasPosition[$i - 1]) + 2;
                                    } else {
                                        array_push($prices, substr($line, 0, count($lineInArray) - $lengthOfLine));
                                    }
                                }
                                if (count($prices)>0) {
                                    $Sum = max($prices);
                                }
                                if (count($prices)>0 && $dph==0) {
                                    $dph = min($prices);
                                }
                                $hasSum=true;
                                $isLine=false;
                                foreach ($numLinForDelete as $row){
                                    if ($row==$lineNumber){
                                        $isLine=true;
                                        break;
                                    }
                                }
                                if (!$isLine){
                                    array_push($numLinForDelete,$lineNumber);
                                }
                            }
                        }

                    /**DPH neni 100%*/
                    if (!$hasDph) {
                        $commasPosition = array();
                        $prices = array();
                        $lengthOfLine=0;
                        if (mb_ereg("DPH", $line) && !strpos($line, "IČ")){
                            while (!mb_ereg("[0-9]",$line)){
                                $line = $handle[$index];
                                if(!mb_ereg("[0-9]",$line)) {
                                    $line = $handle[$index];
                                }
                                break;
                            }
                            $line  = preg_replace("/,/", ".", $line);
                            $line=$line = preg_replace('/20%/', '', $line);
                            $line=$line = preg_replace('/20..00%/', '', $line);
                            $line=$line = preg_replace('/ /', '', $line);
                            $line = preg_replace("/[^,.0-9]/", "", $line);
                            $lineInArray = str_split($line);
                            /**Rozdelenie riadku podla des ciarok*/
                            for ($i = 0; $i < count($lineInArray); $i++) {
                                if ($lineInArray[$i] == ".") {
                                    array_push($commasPosition, $i);
                                }
                            }
//                        for ($i = 0; $i < count($commasPosition); $i++) {
//                            echo $commasPosition[$i]."<br>";
//                        }

                            for ($i = count($commasPosition) - 1; $i > -1; $i--) {
                                if(count($commasPosition)==1){
                                    array_push($prices ,substr($line,0,$commasPosition[0]+3));
                                }
                                else if ($i != 0 ) {
                                    $aaaauto=(($commasPosition[$i - 1]) + 2);
                                    array_push($prices, substr($line, ($commasPosition[$i- 1]) + 3, count($lineInArray) - $aaaauto - $lengthOfLine + 2));
                                    $lengthOfLine += ($commasPosition[$i - 1]) + 2;
                                }
                                else {
                                    array_push($prices, substr($line, 0, count($lineInArray) - $lengthOfLine-1));
                                }
                            }
                            if (count($prices)>0) {
                                $dph = min($prices);
                            }
                            if (count($prices)>0 && $Sum==0) {
                                $Sum = max($prices);
                            }
                            $hasDph=true;
                            $isLine=false;
                            foreach ($numLinForDelete as $row){
                                if ($row==$lineNumber){
                                    $isLine=true;
                                    break;
                                }
                            }
                            if (!$isLine){
                                array_push($numLinForDelete,$lineNumber);
                            }
                        }
                    }


                    }
                }
                if ($dph == "") {
                    $dph = 0;
                }
                if(is_numeric($dph)){
                    $dph = 0;
                }
                if ($date == "") {
                    $date = date('Y-m-d');
                }
                if ($time == "") {
                    $time = date('H:i');
                }
                if ($Sum == "" || is_numeric($Sum) != 1) {
                    $Sum = 0;
                }
                if ($ico == "" || is_numeric($ico) != 1) {
                    $ico = 0;
                }


                $myfile = fopen(public_path('text/texty.txt'), "w") or die("Unable to open file!");
                $txt .= "---------------------\n";
                $txt .= $date . "\n";
                $txt .= $dph . "\n";
                $txt .= $time . "\n";
                $txt .= $ico . "\n";
                $txt .= $dkp . "\n";
                $txt .= $Sum . "\n";

                fwrite($myfile, $txt);
                fclose($myfile);
                if (is_numeric($ico) == 8 && is_numeric($ico) == 1) {

                    $data = DB::table('company')->where('ico', $ico)->get();

                    if ($data == "[]") {
                        $url = 'https://finstat.sk/' . $ico;
                        $finstat_cnt = "";
                        if (get_http_response_code('https://finstat.sk/' . $ico) != "200") {
                            $maxIdRealDocument = DB::table('doc_img')->where('user','=',Auth::user()->id)->max('id');
                            $maxIdEditDocument = DB::table('doc_img')->where('user','=',Auth::user()->id)->max('id');
                            $this->createEditReal($maxIdEditDocument, $maxIdRealDocument, "NULL", "NULL", "0", "0", $Sum, date("Y-m-d"), time(), "0", "0",0);
                            $this->createItems($maxIdEditDocument, $maxIdRealDocument, 'Polozka', 15.20, 5);
                            $this->createDocument($maxIdEditDocument, $maxIdRealDocument);
                            return;
                        } else {
                            $finstat_content = file_get_html('https://finstat.sk/' . $ico);
                        }                        


                        $finstat_company_info = $finstat_content->find('.detail-company-info-side')[0]->find('ul', 0);                       

                        if (!empty($finstat_company_info)) {                            

                            $dic = $finstat_company_info->find('li', 1)->find('text', 2)->save();
                            $ic_dph = $finstat_company_info->find('li', 2)->find('text', 2)->save();
                            $nameCompany = $finstat_company_info->find('li', 3)->find('text', 2)->save();
                            $address = html_entity_decode($finstat_company_info->find('li', 3)->find('text', 3)->save(), ENT_COMPAT, 'UTF-8');                                                       

                            $this->insertCompany($ico, $dic, trim($ic_dph), $address, $nameCompany);
                            $maxIdRealDocument = DB::table('doc_img')->where('user','=',Auth::user()->id)->max('id');
                            $maxIdEditDocument = DB::table('doc_img')->where('user','=',Auth::user()->id)->max('id');
                            $this->createEditReal($maxIdEditDocument, $maxIdRealDocument, $nameCompany, $address, $ico, $ic_dph, $Sum, $date, $time, $dkp, $Sum,0);
                            $this->createItems($maxIdEditDocument, $maxIdRealDocument, 'Polozka', 15.20, 5);
                            $this->createDocument($maxIdEditDocument, $maxIdRealDocument);
                        }

                    } else {
                        foreach ($data as $information) {

                            $dic = $information->dic;
                            $ic_dph = $information->ic_dph;
                            $address = $information->address;
                            $nameCompany = $information->name;
                            $maxIdRealDocument = DB::table('doc_img')->where('user','=',Auth::user()->id)->max('id');
                            $maxIdEditDocument = DB::table('doc_img')->where('user','=',Auth::user()->id)->max('id');
                            $this->createEditReal($maxIdEditDocument, $maxIdRealDocument, $nameCompany, $address, $ico, $ic_dph, $Sum, $date, $time, $dkp, 0,0);
                            $this->createItems($maxIdEditDocument, $maxIdRealDocument, 'Polozka', 0.00, 0);
                            $this->createDocument($maxIdEditDocument, $maxIdRealDocument);
                        }
                    }
                } else {
                    $maxIdRealDocument = DB::table('doc_img')->where('user','=',Auth::user()->id)->max('id');
                    $maxIdEditDocument = DB::table('doc_img')->where('user','=',Auth::user()->id)->max('id');
                    $this->createEditReal($maxIdEditDocument, $maxIdRealDocument, "NULL", "NULL", $ico, "0", $Sum, $date, $time, $dkp, 0,0);
                    $this->createItems($maxIdEditDocument, $maxIdRealDocument, 'Polozka', 00.00, 0);
                    $this->createDocument($maxIdEditDocument, $maxIdRealDocument);
                }
            }catch (Exception $e) {
                $maxIdRealDocument = DB::table('doc_img')->where('user','=',Auth::user()->id)->max('id');
                $maxIdEditDocument = DB::table('doc_img')->where('user','=',Auth::user()->id)->max('id');
                $this->createEditReal($maxIdEditDocument, $maxIdRealDocument, "NULL", "NULL", "0", "0", $Sum, date("Y-m-d"), time(), "0", "0",0);
                $this->createItems($maxIdEditDocument, $maxIdRealDocument, 'Polozka', 00.00, 0);
                $this->createDocument($maxIdEditDocument, $maxIdRealDocument);
            }
        }
    }


    private function createItems($edit_document, $real_document, $name, $price, $quantity)
    {


        DB::table('real_item')->insert([
            'name' => $name,
            'price' => $price,
            'quantity' => $quantity,
            'real_id' => $real_document
        ]);
        DB::table('edit_item')->insert([
            'name' => $name,
            'price' => $price,
            'quantity' => $quantity,
            'edit_id' => $edit_document
        ]);

    }

    private function insertCompany($ico, $dic, $ic_dph, $address, $nameCompany)
    {
        DB::table('company')->insert([
            'ico' => $ico,
            'dic' => $dic,
            'ic_dph' => $ic_dph,
            'address' => $address,
            'name' => $nameCompany

        ]);
    }

    private function createEditReal($edit_document, $real_document, $company_name, $company_address, $ico, $ic_dph, $summar, $date, $time, $dpk, $pay, $dph)
    {
        DB::table('real_document')->insert([
            'real_id' => $real_document,
            'company_name' => $company_name,
            'company_address' => $company_address,
            'ico' => $ico,
            'ic_dph' => $ic_dph,
            'summar' => $summar,
            'dph' => $dph,
            'date' => $date,
            'time' => $time,
            'dpk' => $dpk,
            'pay' => $pay,
        ]);
        DB::table('edit_document')->insert([
            'edit_id' => $edit_document,
            'company_name' => $company_name,
            'company_address' => $company_address,
            'ico' => $ico,
            'ic_dph' => $ic_dph,
            'summar' => $summar,
            'dph' => $dph,
            'date' => $date,
            'time' => $time,
            'dpk' => $dpk,
            'pay' => $pay
        ]);
    }

    private function createDocument($edit_document, $real_document)
    {
        DB::table("document")->insert([
            'id' =>DB::table('doc_img')->where('user','=',Auth::user()->id)->max('id'),
            'owner' => Auth::user()->id,
            'edit_id' => $edit_document,
            'real_id' => $real_document,
            'name' => 'Dokument' . date('Y-m-d'),
            'type' => 1,
            'date' => date('Y-m-d'),
            'doc_img' => DB::table('doc_img')->where('user','=',Auth::user()->id)->max('id'),
        ]);
        //    DB::table('doc_img')->where('id', $id)->update(["id" => DB::table('document')->max('id')]);
    }

}
