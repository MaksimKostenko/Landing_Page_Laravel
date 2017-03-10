<?php

namespace App\Http\Controllers\AdminServices;

use App\Service;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ServicesController extends Controller
{
    public function execute(){
        if(view()->exists('admin.services.services')){
            $services = Service::all();

            $data = [
                'title'=>'Services',
                'services'=>$services
            ];
            return view('admin.services.services',$data);
        }
        abort(404);
    }
}
