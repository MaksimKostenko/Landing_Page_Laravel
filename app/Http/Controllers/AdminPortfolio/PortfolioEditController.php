<?php

namespace App\Http\Controllers\AdminPortfolio;

use App\Portfolio;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Validator;
class PortfolioEditController extends Controller
{
    public function execute(Portfolio $portfolio, Request $request){

        if($request->isMethod('delete')){
            $portfolio->delete();
            return redirect('admin')->with('status', 'Portfolio deleted');
        }

        if($request->isMethod('post')){
            $input = $request->except('_token');

            $validator = Validator::make($input, [
                'name'=>'required|max:150',
                'filter'=>'required|max:150',
            ]);

            if($validator->fails()){
                return redirect()->route('portfolioEdit', ['portfolio'=>$input['id']])->withErrors($validator);
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

            $portfolio->fill($input);

            if($portfolio->update()){
                return redirect('admin')->with('status','Portfolio updated');
            }
        }

        $old = $portfolio->toArray();

        if(view()->exists('admin.portfolio.portfolio_edit')){
            $data = [
                'title'=>'Editing portfolio - '.$old['name'],
                'data'=>$old
            ];
            return view('admin.portfolio.portfolio_edit', $data);
        }
    }
}
