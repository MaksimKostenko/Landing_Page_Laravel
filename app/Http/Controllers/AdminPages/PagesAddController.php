<?php

namespace App\Http\Controllers\AdminPages;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Http\Requests;

use Validator;
use App\Page;
class PagesAddController extends Controller
{
    public function execute(Request $request){

        if($request->isMethod('post')){
            $input = $request->except('_token'); // data from request into mass without '_token'

            $validator = Validator::make($input, [
                'name'=>'required|max:150',
                'alias'=>'required|unique:pages|max:150', //unique in table 'pages'
                'text'=>'required'
            ]);

            if($validator->fails()){
                return redirect()->route('pagesAdd')->withErrors($validator)->withInput(); //wihErrors get all errors from $validator //withInput save entered data in session
            }

            if($request->hasFile('images')){
                $file = $request->file('images');
                $fileName = $input['images'] = $file->getClientOriginalName();
                $file->move(public_path().'/assets/img',$fileName );
            }

            $page = new Page();
            $page->fill($input);

            if($page->save()){
                return redirect('admin')->with('status', 'Page added');
            }
        }

        if(view()->exists('admin.pages.pages_add')){
            $data = [
                'title'=>'New page'
            ];
            return view('admin.pages.pages_add', $data);
        }
        abort(404);
    }
}
