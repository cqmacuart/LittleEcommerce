<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FileController extends Controller
{
    //
    public function downloadFile($file)
    {

        // var_dump($file);
        $path = '../public/files/demo/' . $file;
        $header = [
            'Content-Type' => 'application/*',
        ];
        return response()->download($path, $file, $header);
    }
}
