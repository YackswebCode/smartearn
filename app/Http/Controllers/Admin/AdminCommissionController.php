<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Commission;
use Illuminate\Http\Request;

class AdminCommissionController extends Controller
{
    public function index(Request $request)
    {
        $query = Commission::with(['order', 'affiliate', 'vendor']);

        // Filter by type (affiliate/vendor)
        if ($request->has('type') && in_array($request->type, ['affiliate', 'vendor'])) {
            $query->where('type', $request->type);
        }

        $commissions = $query->latest()->get();

        return view('admin.commissions.index', compact('commissions'));
    }
}