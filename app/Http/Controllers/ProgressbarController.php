<?php

namespace App\Http\Controllers;
use App\Models\Progressbar;

use Illuminate\Http\Request;

class ProgressbarController extends Controller
{
    public function show($id)
    {
        $progressbar = Progressbar::find($id);

        if (!$progressbar) {
            return response()->json(['error' => 'Progressbar not found'], 404);
        }

        return response()->json($progressbar);
    }
}