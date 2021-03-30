<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Configuration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

class AdminController extends Controller
{
    public function maintenance()
    {
        $checked = Configuration::select('value')->first()->value ? "checked" : "";

        return view('layouts.admin', [
            'checked' => $checked
        ]);
    }

    public function update(Request $request)
    {
        $mode = $request->input('mode') == 'on' ? true : false;
        $checked = $mode ? "checked" : "";
        DB::table('configurations')
            ->where('name', '=', 'maintenance-mode')
            ->update([
                'value' => $mode
            ]);
        return view('layouts.admin', [
            'checked' => $checked
        ]);
    }
}
