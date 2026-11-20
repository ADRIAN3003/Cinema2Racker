<?php

namespace App\Http\Controllers;

use App\Models\Mozi;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MoziApiController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Mozi::orderBy('nev')->get());
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'nev' => ['required', 'string', 'max:255'],
            'iranyitoszam' => ['required', 'digits:4'],
            'cim' => ['required', 'string', 'max:255'],
            'telefon' => ['nullable', 'string', 'max:30'],
        ]);

        $mozi = Mozi::create($validated);

        return response()->json($mozi, 201);
    }

    public function update(Request $request, Mozi $mozi): JsonResponse
    {
        $validated = $request->validate([
            'nev' => ['required', 'string', 'max:255'],
            'iranyitoszam' => ['required', 'digits:4'],
            'cim' => ['required', 'string', 'max:255'],
            'telefon' => ['nullable', 'string', 'max:30'],
        ]);

        $mozi->update($validated);

        return response()->json($mozi);
    }

    public function destroy(Mozi $mozi): Response
    {
        $mozi->delete();

        return response()->noContent();
    }
}
