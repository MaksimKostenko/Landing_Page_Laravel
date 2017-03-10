<?php

namespace App\Http\Controllers\AdminPages;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Page;

class PagesController extends Controller
{
    public function execute(){
        if(view()->exists('admin.pages.pages')){
            $pages = Page::all();

            $data = [
                'title'=>'Pages',
                'pages'=>$pages
            ];
            return view('admin.pages.pages',$data);
        }
        abort(404);
    }
}
