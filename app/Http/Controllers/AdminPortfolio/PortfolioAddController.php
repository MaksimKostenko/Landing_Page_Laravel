<?php

namespace App\Http\Controllers\AdminPortfolio;

use App\Portfolio;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Validator;

class PortfolioAddController extends Controller
{
    public function execute(Request $request){

        if($request->isMethod('post')){
            $input = $request->except('_token');

            $validator = Validator::make($input, [
                'name'=>'required|max:150',
                'filter'=>'required|max:150',
            ]);

            if($validator->fails()){
                return redirect()->route('portfolioAdd')->withErrors($validator)->withInput();
            }

            if($request->hasFile('images')){
                $file = $request->file('images');
                $fileName = $input['images'] = $file->getClientOriginalName();
                $file->move(public_path().'/assets/img',$fileName );
            }

            $portfolio = new Portfolio();
            $portfolio->fill($input);

            if($portfolio->save()){
                return redirect('admin')->with('status', 'Portfolio added');
            }
        }

        if(view()->exists('admin.portfolio.portfolio_add')){
            $data = [
                'title'=>'New portfolio'
            ];
            return view('admin.portfolio.portfolio_add', $data);
        }
        abort(404);
    }
}
