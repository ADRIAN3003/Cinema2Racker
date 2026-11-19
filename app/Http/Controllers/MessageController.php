<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\View\View;

class MessageController extends Controller
{
    public function index(): View
    {
        return view('messages', [
            'messages' => Message::latest()->paginate(10),
            'total' => Message::count(),
        ]);
    }
}
