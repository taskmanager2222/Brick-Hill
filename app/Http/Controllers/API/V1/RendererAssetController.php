<?php

namespace App\Http\Controllers\API\V1;

use App\Models\Item;
use App\Http\Controllers\Controller;

class RendererAssetController extends Controller
{
    public function poly($type, $itemId)
    {
        $item = Item::where('id', $itemId)->firstOrFail();

        $filename = $item->filename;

        return response()->json([[
            'mesh' => "asset://{$filename}.obj",
            'texture' => "asset://{$filename}.png"
        ]]);
    }

    public function asset($filename)
    {
        $filename = basename($filename);

        if (!preg_match('/^[A-Za-z0-9_-]+\.(obj|mtl|png)$/i', $filename))
            abort(404);

        return redirect(config('site.storage_url') . '/uploads/' . $filename);
    }
}
