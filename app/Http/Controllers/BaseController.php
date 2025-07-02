<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\PageVisit;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    public function __construct()
    {
        view()->composer('*', function ($view) {
            $currentPage = request()->path();
            $pageVisit = PageVisit::where('page', $currentPage)->first();
            $visits = $pageVisit ? $pageVisit->visits : 0;

            $view->with('pageVisits', $visits);
        });
    }
}
