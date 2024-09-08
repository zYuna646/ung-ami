<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAuditeeRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Faculty;
use App\Models\Program;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AuditeeController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(User::class, 'user');
    }

    public function index(Request $request)
    {
        $validTypes = ['unit', 'faculty', 'program'];

        if (!$request->has('type') || !in_array($request->type, $validTypes)) {
            return redirect()->route('dashboard.users.auditees.index', ['type' => 'unit']);
        }

        $users = User::latest()->whereHas($request->type)->get();

        return view('pages.dashboard.users.auditees.index', compact('users'));
    }

    // public function create(Request $request)
    // {
    //     $validTypes = ['unit', 'faculty', 'program'];

    //     if (!$request->has('type') || !in_array($request->type, $validTypes)) {
    //         return redirect()->route('dashboard.users.auditees.create', ['type' => 'unit']);
    //     }

    //     $units = Unit::get();
    //     $faculties = Faculty::get();
    //     $programs = Program::get();

    //     return view('pages.dashboard.users.auditees.create', compact('units', 'faculties', 'programs'));
    // }

    public function store(StoreAuditeeRequest $request)
    {
        try {
            DB::beginTransaction();
            $data = $request->validated();
            $user = User::create($data);
            switch ($request->type) {
                case 'unit':
                    Unit::create([
                        'unit_name' => $data['unit_name'],
                        'user_id' => $user->id
                    ]);
                    break;
                case 'faculty':
                    Faculty::create([
                        'faculty_name' => $data['faculty_name'],
                        'user_id' => $user->id
                    ]);
                    break;
                case 'program':
                    Program::create([
                        'program_name' => $data['program_name'],
                        'user_id' => $user->id
                    ]);
                    break;
            }
            DB::commit();

            return redirect()->back()->with('success', 'Data berhasil ditambahkan.');
        } catch (\Throwable $th) {
            DB::rollBack();
            logger()->error($th->getMessage());

            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan.'])->withInput();
        }
    }

    public function edit(User $user)
    {
        return view('pages.dashboard.users.auditees.edit', compact('user'));
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        try {
            $data = $request->validated();
            $user->update($data);

            return redirect()->back()->with('success', 'Data berhasil diperbarui.');
        } catch (\Throwable $th) {
            logger()->error($th->getMessage());

            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan.'])->withInput();
        }
    }
}
