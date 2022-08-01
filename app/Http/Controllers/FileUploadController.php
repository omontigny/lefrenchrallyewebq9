<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Cloudinary;

class FileUploadController extends Controller
{
  public function showUploadForm()
  {
    return view('forms.upload');
  }

  // public function storeUploads(Request $request)
  // {
  //   $request->file('file')->store('images');

  //   $fileName = $request->file('file')->getClientOriginalName();
  //   $extension = $request->file('file')->extension();
  //   $mime = $request->file('file')->getMimeType();
  //   $clientSize = $request->file('file')->getSize();
  //   Log::stack(['single'])->debug("Uploaded File" . $fileName . '-' . $extension . '-' . $mime . '-' . $clientSize);

  //   return back()
  //     ->with('success', 'File uploaded successfully');
  // }
  public function storeUploads(Request $request)
  {
    $response = cloudinary()->upload($request->file('file')->getRealPath())->getSecurePath();

    dd($response);

    return back()
      ->with('success', 'File uploaded successfully');
  }
}
