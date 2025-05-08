<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;
use App\Models\User;

class FeedController extends \Illuminate\Routing\Controller
{
    public function index(): Factory|View
    {
        $users = User::whereNotNull('curriculum')->get();
        return view('feed', compact('users'));
    }
}