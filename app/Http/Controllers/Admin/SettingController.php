<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SettingController extends Controller
{
    public function index(): View
    {
        return view('admin.settings.index', [
            'settings' => [
                'store_name' => config('app.name', 'Warung Pak Do'),
                'bank_account' => null,
            ],
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'store_name' => ['required', 'string', 'max:100'],
            'bank_account' => ['nullable', 'string', 'max:255'],
        ]);

        return back()->with('success', 'Pengaturan disimpan.');
    }
}
