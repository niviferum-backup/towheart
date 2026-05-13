<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GameController extends Controller
{
    public function showFloor(int $floor)
    {
        $floors = config('game.floors');

        if (! isset($floors[$floor])) {
            abort(404);
        }

        // Prevent skipping: every previous floor must be completed
        for ($i = 1; $i < $floor; $i++) {
            if ($floors[$i]['type'] !== 'intro' && ! session("floor_{$i}_done")) {
                return redirect()->route('floor', ['floor' => $i]);
            }
        }

        $data = $floors[$floor];
        $totalFloors = count($floors);

        return view('game.floor', compact('floor', 'data', 'totalFloors'));
    }

    public function solveFloor(int $floor, Request $request)
    {
        $floors = config('game.floors');

        if (! isset($floors[$floor])) {
            abort(404);
        }

        $floorData = $floors[$floor];

        if ($floorData['answer'] === null) {
            abort(422);
        }

        $given = strtoupper(trim($request->input('password', '')));
        $expected = strtoupper(trim($floorData['answer']));

        if ($given !== $expected) {
            return back()->with('error', "Ce n'est pas le bon mot… Cherche encore.");
        }

        session(["floor_{$floor}_done" => true]);

        $next = $floor + 1;
        if (isset($floors[$next])) {
            return redirect()->route('floor', ['floor' => $next]);
        }

        return redirect()->route('floor', ['floor' => $floor]);
    }

    public function checkFloor(int $floor, Request $request)
    {
        $floors = config('game.floors');

        if (! isset($floors[$floor])) {
            abort(404);
        }

        $floorData = $floors[$floor];

        if ($floorData['answer'] === null) {
            abort(422);
        }

        $given    = strtoupper(trim($request->input('password', '')));
        $expected = strtoupper(trim($floorData['answer']));

        if ($given !== $expected) {
            return response()->json(['correct' => false]);
        }

        session(["floor_{$floor}_done" => true]);

        $next    = $floor + 1;
        $nextUrl = isset($floors[$next])
            ? route('floor', ['floor' => $next])
            : route('floor', ['floor' => $floor]);

        return response()->json(['correct' => true, 'nextUrl' => $nextUrl]);
    }

    public function markIntro(int $floor)
    {
        session(["floor_{$floor}_done" => true]);
        $floors = config('game.floors');
        $next = $floor + 1;

        if (isset($floors[$next])) {
            return redirect()->route('floor', ['floor' => $next]);
        }

        return redirect()->route('floor', ['floor' => $floor]);
    }
}
