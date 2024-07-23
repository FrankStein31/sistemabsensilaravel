<?php

namespace App\Http\Controllers;
use App\Models\Setting;

use Illuminate\Http\Request;

class settingtucontroller extends Controller
{
    public function index()
    {
        return view('dashboard.settingtu.index', [
            'settings' => setting::all()
        ]);
    }

    public function create()
    {
        return view('dashboard.settingtu.create');
    }


    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'in_start' => 'required',
            'in_end' => 'required',
            'out_start' => 'required',
            'out_end' => 'required',
        ]);

        // Menambahkan nilai default untuk fine dan fuel
        $validatedData['fine'] = 123;
        $validatedData['fuel'] = 132;

        Setting::create($validatedData);
        return redirect('/dashboard/settingtu')->with('success', 'New time has been added!');
    }

    public function show(Setting $setting)
    {
        //
    }

    public function edit(Setting $settingtu)
    {
        return view('dashboard.settingtu.edit', [
            'setting' => $settingtu,
        ]);
    }


    public function update(Request $request, Setting $settingtu)
    {
        $rules = [
            'in_start' => 'required',
            'in_end' => 'required',
            'out_start' => 'required',
            'out_end' => 'required',
        ];

        $validatedData = $request->validate($rules);
        Setting::where('id', $settingtu->id)
            ->update($validatedData);
        return redirect('/dashboard/settingtu')->with('success', 'Data has been updated!');
    }


    public function destroy(Setting $settingtu)
    {
        Setting::destroy($settingtu->id);
        return redirect('/dashboard/settingtu')->with('success', 'Data has been deleted!');
    }
}
