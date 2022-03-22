<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;

class LayoutFormatController extends BaseController
{
  function rtl()
  {
    return view('layoutformat.rtl');
  }

  function horizontal()
  {
    return view('layoutformat.horizontal');
  }

  function smallmenu()
  {
    return view('layoutformat.smallmenu');
  }
}
