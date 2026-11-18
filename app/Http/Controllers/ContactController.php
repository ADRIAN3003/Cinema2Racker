<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Models\Message;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ContactController extends Controller
{
    public function show(): View
    {
        return view('contact');
    }

    public function store(ContactRequest $request): RedirectResponse
    {
        Message::create($request->validated());

        return redirect()->route('contact')->with('status', 'Köszönjük, az üzeneted megérkezett.');
    }
}
