<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class StorageController extends Controller
{
  public function index()
  {
    return view('new');
  }

  public function save(Request $request)
	{
    //obtenemos el nombre del archivo
    $file = $request->file;
    $image = \Image::make($file);
    $nombre = $file->getClientOriginalName();

    if(!file_exists('images/thumbnail')){
      mkdir('images/thumbnail', 0777, true);
    }
    if(!file_exists('images/thumbnail/min')){
      mkdir('images/thumbnail/min', 0777, true);
    }

    $path = 'images/thumbnail/';
    $path_min = 'images/thumbnail/min/';
    $hasFile = $request->hasFile('file') && $request->file->isValid();
    if($hasFile){
      $file->move($path,$nombre);
      $thumb = Image::make($path.$nombre)->resize(240,200)->save($path_min.$nombre, 100);
      
      return "archivo guardado";
    }else{
      return "archivo no guardado";
    }

	}
}
