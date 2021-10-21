<?php

namespace App\Http\Controllers;

use App\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    // singleton
    public function __invoke(Page $page)
    {
        return view('page', compact('page'));
    }

    public function banned() {
        $message = opt('bannedUserMessage');
        return view('banned', compact('message'));
    }
}
