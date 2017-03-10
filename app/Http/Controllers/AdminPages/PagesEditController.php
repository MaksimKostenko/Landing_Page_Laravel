<?php

namespace App\Http\Controllers\AdminPages;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Http\Requests;

use App\Page;
use Validator;
class PagesEditController extends Controller
{
    public function execute(Page $page, Request $request){

        if($request->isMethod('delete')){
            $page->delete();
            return redirect('admin')->with('status', 'Page deleted');
        }

        if($request->isMethod('post')){
            $input = $request->except('_token');

            $validator = Validator::make($input, [
                'name'=>'required|max:150',
                'alias'=>'required|max:150|unique:pages,alias,'.$input['id'],//ignore the row that is being edited
                'text'=>'required'
            ]);

            if($validator->fails()){
                return redirect()->route('pagesEdit', ['page'=>$input['id']])->withErrors($validator);
            }

            if($request->hasFile('images')){
                $file = $request->file('images');
                $file->move(public_path().'/assets/img',$file->getClientOriginalName());
                $input['images'] = $file->getClientOriginalName();
            }
            else{
                $input['images'] = $input['old_images'];
            }

            unset($input['old_images']);

            $page->fill($input);

            if($page->update()){
                return redirect('admin')->with('status','Page updated');
            }
        }

        //$page = Page::find($id); //if pass $id as parameter of execute()
        $old = $page->toArray();

        if(view()->exists('admin.pages.pages_edit')){
            $data = [
                'title'=>'Editing page - '.$old['name'],
                'data'=>$old
            ];
            return view('admin.pages.pages_edit', $data);
        }
    }
}
