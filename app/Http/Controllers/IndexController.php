<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Page;
use App\Service;
use App\Portfolio;
use App\Employee;
use DB;
use Mail;

class IndexController extends Controller
{
    public function execute(Request $request){

        if($request->isMethod('post')){
            $messages = [
                'required' => "The field :attribute is required",
                'email' => "The field :attribute must have a valid e-mail format",
                'max' => "The field :attribute is too long",
            ];

            $this->validate($request,[
                'name'=>'required|max:150',
                'email'=>'required|email',
                'text'=>'required'
            ], $messages);

            $data = $request->all();

            $result = Mail::send('site.email', ['data'=>$data], function($message) use($data){
                $mail_admin = env('MAIL_ADMIN');
                $message->from('laravelmail7@gmail.com', $data['name']);
                $message->to($mail_admin)->subject('Question'); //topic of letter
            });

            if($result) {
                return redirect()->route('home')->with('status', 'Email is send');
            }
        }

        $pages = Page::all();
        $portfolios = Portfolio::all();
        $services = Service::all();
        $employees =  Employee::all();
        $tags = DB::table('portfolios')->distinct()->lists('filter');

        $menu = array();
        foreach($pages as $page){
            $item = array('title' => $page->name, 'alias' => $page->alias);
            array_push($menu, $item);
        }

        $item = array('title'=>'Services' , 'alias'=>'service');
        array_push($menu, $item);

        $item = array('title'=>'Portfolio' , 'alias'=>'Portfolio');
        array_push($menu, $item);

        $item = array('title'=>'Team' , 'alias'=>'team');
        array_push($menu, $item);

        $item = array('title'=>'Contact' , 'alias'=>'contact');
        array_push($menu, $item);

        return view('site.index', array(
            'menu'=> $menu,
            'pages'=> $pages,
            'services'=> $services,
            'portfolios'=> $portfolios,
            'employees'=> $employees,
            'tags'=>$tags
        ));
    }
}
