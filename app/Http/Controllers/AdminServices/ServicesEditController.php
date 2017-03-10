<?php

namespace App\Http\Controllers\AdminServices;

use App\Service;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Validator;

class ServicesEditController extends Controller
{
    public function execute(Service $service, Request $request){

        if($request->isMethod('delete')){
            $service->delete();
            return redirect('admin')->with('status', 'Service deleted');
        }

        if($request->isMethod('post')){
            $input = $request->except('_token');

            $validator = Validator::make($input, [
                'name'=>'required|max:150',
                'text'=>'required',
                'icon'=>'required'
            ]);

            if($validator->fails()){
                return redirect()->route('servicesEdit', ['service'=>$input['id']])->withErrors($validator);
            }



            $service->fill($input);

            if($service->update()){
                return redirect('admin')->with('status','Service updated');
            }
        }

        //$page = Page::find($id); //if pass $id as parameter of execute()
        $old = $service->toArray();

        if(view()->exists('admin.services.services_edit')){
            $data = [
                'title'=>'Editing service - '.$old['name'],
                'data'=>$old
            ];
            return view('admin.services.services_edit', $data);
        }
    }
}
