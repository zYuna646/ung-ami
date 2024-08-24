<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProgramRequest;
use App\Http\Requests\UpdateProgramRequest;
use App\Models\Program;
use App\Models\Department;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class ProgramController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Program::class, 'program');
    }

    public function index()
    {
        $programs = Program::latest()->get();

        return view('pages.dashboard.master.programs.index', compact('programs'));
    }

    public function create()
    {
        $departments = Department::latest()->get();

        return view('pages.dashboard.master.programs.create', compact('departments'));
    }

    public function store(StoreProgramRequest $request)
    {
        try {
            DB::beginTransaction();

            $data = $request->validated();
            $user = User::create([
                'name' => "Ketua Program Studi {$request->program_name}",
                'email' => strtolower(str_replace(' ', '.', $request->program_name)) . '@amiung.com',
            ]);
            $data['user_id'] = $user->id;
            Program::create($data);

            DB::commit();

            return redirect()->back()->with('success', 'Data berhasil ditambahkan.');
        } catch (\Throwable $th) {
            DB::rollBack();
            logger()->error($th->getMessage());

            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan.'])->withInput();
        }
    }

    public function edit(Program $program)
    {
        return view('pages.dashboard.master.programs.edit', compact('program'));
    }

    public function update(UpdateProgramRequest $request, Program $program)
    {
        try {
            $data = $request->validated();
            $program->update($data);

            return redirect()->back()->with('success', 'Data berhasil diperbarui.');
        } catch (\Throwable $th) {
            logger()->error($th->getMessage());

            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan.'])->withInput();
        }
    }

    public function destroy(Program $program)
    {
        try {
            $program->user->delete();
            $program->delete();

            return redirect()->route('dashboard.master.programs.index')->with('success', 'Data berhasil dihapus.');
        } catch (\Throwable $th) {
            logger()->error($th->getMessage());
            
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan.'])->withInput();
        }
    }
}
