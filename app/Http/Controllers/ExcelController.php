<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Excel;
use File;

class ExcelController extends Controller
{
    public function index()
    {
        return view('import');
    }

    public function import(Request $request)
    {
        //validate the xls file
        $this->validate($request, array(
            'file'      => 'required'
        ));
 
        if($request->hasFile('file')){
            $extension = File::extension($request->file->getClientOriginalName());
            if ($extension == "xlsx" || $extension == "xls" || $extension == "csv") {
 
                $path = $request->file->getRealPath();
                $data = Excel::load($path, function($reader) {
                })->get();
                // dd($data);
                // foreach($data as $raw){
                //     echo $raw;
                // }
                if(!empty($data) && $data->count()){ 
                    foreach ($data as $key => $value) {
                        echo "<table style=\"width:100%\">";
                        echo "<tr>";
                        echo "<td style=\"width:20%\" rowspan=\"5\"><img src=\"/dosen/".$value->foto.".jpg\" /></td>";
                        echo "<td style=\"width:20%\">Nama</td>";
                        echo "<td>".$value->nama."</td>";
                        echo "</tr>";

                        echo "<tr>";                        
                        echo "<td style=\"width:20%\">NIP/NIU</td>";
                        echo "<td>".$value->nip."</td>";
                        echo "</tr>";

                        echo "<tr>";                        
                        echo "<td style=\"width:20%\">Bidang Keahlian</td>";
                        echo "<td>".$value->bidang."</td>";
                        echo "</tr>";

                        echo "<tr>";                        
                        echo "<td style=\"width:20%\">Email</td>";
                        echo "<td><a href=\"mailto:".$value->email."\" >".$value->email."</a></td>";
                        echo "</tr>";

                        echo "<tr>";                        
                        echo "<td colspan=\"2\">";                                       

                        if($value->scholar != ""){
                            echo "<a href=\"".$value->scholar."\" target=\"_blank\"><img style=\"width:70px\" src=\"/dosen/scholar.png\"/></a>&nbsp;&nbsp;";
                        }

                        if($value->sinta != ""){
                            echo "<a href=\"".$value->sinta."\" target=\"_blank\"><img style=\"width:70px\" src=\"/dosen/sinta.png\"/></a>&nbsp;&nbsp;";
                        }

                        if($value->site != ""){
                            echo "<a href=\"".$value->site."\" target=\"_blank\"><img style=\"width:20px\" src=\"/dosen/web2.png\"/></a>";
                        }                        
                        echo "</td>";
                        echo "</tr>";

                        echo "</table>";
                        // $insert[] = [
                        //     'name' => $value->name,
                        //     'email' => $value->email,
                        //     'username' => $value->niu,                            
                        // ];
                    }
                     
                }
 
                // return back();
 
            }else {
                Session::flash('error', 'File is a '.$extension.' file.!! Please upload a valid xls/csv file..!!');
                return back();
            }
        }
    }
}
