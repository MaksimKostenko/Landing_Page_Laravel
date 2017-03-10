<?php

namespace App\Http\Controllers\AdminServices;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Validator;
use App\Service;

class ServicesAddController extends Controller
{
    public function execute(Request $request){

        if($request->isMethod('post')){
            $input = $request->except('_token');

            $validator = Validator::make($input, [
                'name'=>'required|unique:services|max:150',
                'text'=>'required',
                'icon'=>'required|max:150'
            ]);

            if($validator->fails()){
                return redirect()->route('servicesAdd')->withErrors($validator)->withInput();
            }

            if($request->hasFile('images')){
                $file = $request->file('images');
                $fileName = $input['images'] = $file->getClientOriginalName();
                $file->move(public_path().'/assets/img',$fileName );
            }

            $service = new Service();
            $service->fill($input);

            if($service->save()){
                return redirect('admin')->with('status', 'Service added');
            }
        }

        if(view()->exists('admin.services.services_add')){
            $data = [
                'title'=>'New service'
            ];
            return view('admin.services.services_add', $data);
        }
        abort(404);
    }
}
