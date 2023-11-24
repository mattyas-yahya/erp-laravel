<?php

namespace App\Http\Controllers\Tms;

use App\Http\Controllers\Controller;
use App\Models\Tms\TireFactory as TmsTireFactory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SettingTireFactoryController extends Controller
{
    public function __construct()
    {
    }

    function index(Request $request)
    {
        // if (!Auth::user()->can('manage production')) {
        //     return redirect()->back()->with('error', __('Permission Denied.'));
        // }

        $factories = TmsTireFactory::all();

        return view('tms.setting.tire-factory.index', [
            'factories' => $factories,
        ]);
    }

    function create()
    {
        // if (!Auth::user()->can('manage production')) {
        //     return response()->json(['error' => __('Permission denied.')], 401);
        // }

        return view('tms.setting.tire-factory.create');
    }

    function edit($id)
    {
        // if (!Auth::user()->can('manage production')) {
        //     return response()->json(['error' => __('Permission denied.')], 401);
        // }

        $factory = TmsTireFactory::find($id);

        return view('tms.setting.tire-factory.edit', [
            'factory' => $factory ?? [],
        ]);
    }

    function store(Request $request)
    {
        // if (!Auth::user()->can('manage production')) {
        //     return redirect()->back()->with('error', __('Permission Denied.'));
        // }

        try {
            DB::beginTransaction();

            TmsTireFactory::create([
                'name' => $request->name,
            ]);

            DB::commit();

            return redirect()->route('tms.setting.tire-factory.index')->with('success', __('Master tire factory successfully created.'));
        } catch (\Throwable $e) {
            DB::rollBack();

            return redirect()->back()->with('error', 'Tambah data gagal!');
        }
    }

    function update(Request $request, $id)
    {
        // if (!Auth::user()->can('manage production')) {
        //     return redirect()->back()->with('error', __('Permission Denied.'));
        // }

        try {
            DB::beginTransaction();

            $factory = TmsTireFactory::findOrFail($id);
            $factory->fill($request->all());
            $factory->save();

            DB::commit();

            return redirect()->route('tms.setting.tire-factory.index')->with('success', __('Master tire factory successfully updated.'));
        } catch (\Throwable $e) {
            DB::rollBack();

            return redirect()->back()->with('error', 'Tambah data gagal!');
        }
    }

    function destroy($id)
    {
        // if (!Auth::user()->can('manage production')) {
        //     return redirect()->back()->with('error', __('Permission Denied.'));
        // }

        try {
            DB::beginTransaction();

            $factory = TmsTireFactory::find($id);
            $factory->delete();

            DB::commit();

            return redirect()->route('tms.setting.tire-factory.index')->with('success', __('Master tire factory successfully deleted.'));
        } catch (\Throwable $e) {
            return redirect()->back()->with(['error' => 'Delete data gagal!']);
        }
    }
}
