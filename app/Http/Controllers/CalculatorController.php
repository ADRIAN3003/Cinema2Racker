<?php

namespace App\Http\Controllers;

use App\Services\Calculator;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use InvalidArgumentException;

class CalculatorController extends Controller
{
    public function __construct(private readonly Calculator $calculator)
    {
    }

    public function showForm(): View
    {
        return view('calc', [
            'a' => 0,
            'b' => 0,
            'op' => 'add',
            'result' => null,
            'symbol' => null,
            'error' => null,
        ]);
    }

    public function calculate(Request $request): View
    {
        $validated = $request->validate([
            'a' => ['required', 'integer'],
            'b' => ['required', 'integer'],
            'op' => ['required', Rule::in(['add', 'sub', 'mul', 'divide'])],
        ]);

        $a = (int) $validated['a'];
        $b = (int) $validated['b'];
        $op = $validated['op'];

        $symbols = [
            'add' => '+',
            'sub' => '-',
            'mul' => '*',
            'divide' => '/',
        ];

        $data = [
            'a' => $a,
            'b' => $b,
            'op' => $op,
            'result' => null,
            'symbol' => $symbols[$op],
            'error' => null,
        ];

        try {
            $value = match ($op) {
                'add' => $this->calculator->add($a, $b),
                'sub' => $this->calculator->subtract($a, $b),
                'mul' => $this->calculator->multiply($a, $b),
                'divide' => $this->calculator->divide($a, $b),
            };
            $data['result'] = $op === 'divide' ? number_format($value, 2, ',', '') : (string) $value;
        } catch (InvalidArgumentException $exception) {
            $data['error'] = $exception->getMessage();
        }

        return view('calc', $data);
    }
}
