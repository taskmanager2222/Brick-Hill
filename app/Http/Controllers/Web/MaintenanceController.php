<?php

namespace App\Http\Controllers\Web;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class MaintenanceController extends Controller
{
    public function index()
    {
        if (session()->has('maintenance_password'))
            return redirect()->route('home.index');

        $jackpot = false;
        $localImages = [
            'aeo' => 'images/aeo.png',
            'brick-luke' => 'images/brick-luke.png',
            'spacebuilder' => 'images/spacebuilder.png',
            'jefemy' => 'images/jefemy.png',
            'kwame' => 'images/kwame.png',
        ];
        $users = ['aeo', 'brick-luke', 'spacebuilder', 'jefemy', 'kwame'];
        $randomUsers = [];
        $thumbnails = [];
        $i = 0;

        foreach ($users as $user) {
            $i++;

            if ($i > 4)
                continue;

            shuffle($users);
            $randomUsers[] = $users[0];
        }

        foreach ($randomUsers as $id) {
            if (isset($localImages[$id])) {
                $thumbnails[] = asset($localImages[$id]);
                continue;
            }

            $user = User::where('id', '=', $id);
            $thumbnails[] = ($user->exists()) ? $user->first()->thumbnail() : config('site.storage_url') . '/error/png_error.png';
        }

        if (Auth::check() && ($randomUsers[0] == 'aeo' && $randomUsers[1] == 'aeo' && $randomUsers[2] == 'aeo' && $randomUsers[3] == 'aeo')) {
            $jackpot = true;

            if (!Auth::user()->ownsAward(2))
                Auth::user()->giveAward(2);
        }

        return view('web.maintenance.index')->with([
            'thumbnails' => $thumbnails,
            'jackpot' => $jackpot,
            'rands' => $thumbnails,
            'won' => $jackpot
        ]);
    }

    public function authenticate(Request $request)
    {
        $maintenancePasswords = config('site.maintenance_passwords');

        if (session()->has('maintenance_password'))
            return back()->withErrors(['Already authenticated.']);

        if (!$request->key)
            return back()->withErrors(['Please provide a key.']);

        if (!in_array($request->key, $maintenancePasswords))
            return back()->withErrors(['Invalid key.']);

        session()->put('maintenance_password', $request->key);
        session()->save();

        return redirect()->route('home.index');
    }

    public function exit()
    {
        session()->forget('maintenance_password');

        return redirect()->route('maintenance.index');
    }
}
