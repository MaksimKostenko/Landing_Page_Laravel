<?php

namespace App\Http\Controllers\AdminPortfolio;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Portfolio;
class PortfolioController extends Controller
{
    public function execute(){
        if(view()->exists('admin.portfolio.portfolio')){
            $portfolios = Portfolio::all();

            $data = [
                'title'=>'portfolio',
                'portfolios'=> $portfolios
            ];
            return view('admin.portfolio.portfolio', $data);
        }
        abort(404);
    }
}
