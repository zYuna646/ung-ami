<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFacultyRequest;
use App\Http\Requests\UpdateFacultyRequest;
use App\Models\Faculty;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class FacultyController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Faculty::class, 'faculty');
    }

    public function index()
    {
        $faculties = Faculty::latest()->get();

        return view('pages.dashboard.master.faculties.index', compact('faculties'));
    }

    public function create()
    {
        return view('pages.dashboard.master.faculties.create');
    }

    public function store(StoreFacultyRequest $request)
    {
        try {
            DB::beginTransaction();

            $data = $request->validated();
            $user = User::create([
                'name' => "Dekan Fakultas {$request->faculty_name}",
                'email' => strtolower(str_replace(' ', '.', $request->faculty_name)) . '@amiung.com',
            ]);
            $data['user_id'] = $user->id;
            Faculty::create($data);

            DB::commit();

            return redirect()->back()->with('success', 'Data berhasil ditambahkan.');
        } catch (\Throwable $th) {
            DB::rollBack();
            logger()->error($th->getMessage());

            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan.'])->withInput();
        }
    }

    public function edit(Faculty $faculty)
    {
        return view('pages.dashboard.master.faculties.edit', compact('faculty'));
    }

    public function update(UpdateFacultyRequest $request, Faculty $faculty)
    {
        try {
            $data = $request->validated();
            $faculty->update($data);

            return redirect()->back()->with('success', 'Data berhasil diperbarui.');
        } catch (\Throwable $th) {
            logger()->error($th->getMessage());

            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan.'])->withInput();
        }
    }

    public function destroy(Faculty $faculty)
    {
        try {
            $faculty->user->delete();
            $faculty->delete();

            return redirect()->route('dashboard.master.faculties.index')->with('success', 'Data berhasil dihapus.');
        } catch (\Throwable $th) {
            logger()->error($th->getMessage());
            
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan.'])->withInput();
        }
    }
}
