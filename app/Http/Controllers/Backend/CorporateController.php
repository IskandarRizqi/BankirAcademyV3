<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\CorporateModel;

/**
 * Compatibility endpoint for the public corporate lookup used by checkout.
 */
class CorporateController extends Controller
{
    public function show($id)
    {
        if (! $id) {
            return collect();
        }

        return CorporateModel::where('jenis', $id)->get();
    }
}
