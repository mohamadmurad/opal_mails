<?php

namespace App\Http\Controllers;

use App\Models\files;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class FileDownloader extends Controller
{
    public function download(Request $request){

        $id = $request->get('id');

        $file = files::findOrFail($id);

        $dd= Storage::disk('files')->get($file->name);


         return (new Response($dd, 200))
            ->header('Content-Type', $file->type);

    }
}
