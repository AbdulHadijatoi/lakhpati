<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::all();
        return view('admin.settings.index', compact('settings'));
    }

    public function create()
    {
        return view('admin.settings.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'key' => 'required|unique:settings|max:255',
            'value' => 'required'
        ]);

        Setting::create($request->only('key', 'value'));
        return redirect()->route('settings.index')->with('success', 'Setting created successfully.');
    }

    public function edit($key)
    {
        $setting = Setting::findOrFail($key);
        return view('admin.settings.edit', compact('setting'));
    }

    public function update(Request $request, $key)
    {
        $setting = Setting::findOrFail($key);
        $request->validate([
            'value' => 'required'
        ]);

        $setting->update($request->only('value'));
        return redirect()->route('settings.index')->with('success', 'Setting updated successfully.');
    }

    public function destroy($key)
    {
        Setting::destroy($key);
        return redirect()->route('settings.index')->with('success', 'Setting deleted successfully.');
    }
}
