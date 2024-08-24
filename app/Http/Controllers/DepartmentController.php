<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDepartmentRequest;
use App\Http\Requests\UpdateDepartmentRequest;
use App\Models\Department;
use App\Models\Faculty;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DepartmentController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Department::class, 'department');
    }

    public function index()
    {
        $departments = Department::latest()->get();

        return view('pages.dashboard.master.departments.index', compact('departments'));
    }

    public function create()
    {
        $faculties = Faculty::latest()->get();

        return view('pages.dashboard.master.departments.create', compact('faculties'));
    }

    public function store(StoreDepartmentRequest $request)
    {
        try {
            DB::beginTransaction();

            $data = $request->validated();
            $user = User::create([
                'name' => "Ketua Jurusan {$request->department_name}",
                'email' => strtolower(str_replace(' ', '.', $request->department_name)) . '@amiung.com',
            ]);
            $data['user_id'] = $user->id;
            Department::create($data);

            DB::commit();

            return redirect()->back()->with('success', 'Data berhasil ditambahkan.');
        } catch (\Throwable $th) {
            DB::rollBack();
            logger()->error($th->getMessage());

            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan.'])->withInput();
        }
    }

    public function edit(Department $department)
    {
        return view('pages.dashboard.master.departments.edit', compact('department'));
    }

    public function update(UpdateDepartmentRequest $request, Department $department)
    {
        try {
            $data = $request->validated();
            $department->update($data);

            return redirect()->back()->with('success', 'Data berhasil diperbarui.');
        } catch (\Throwable $th) {
            logger()->error($th->getMessage());

            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan.'])->withInput();
        }
    }

    public function destroy(Department $department)
    {
        try {
            $department->user->delete();
            $department->delete();

            return redirect()->route('dashboard.master.departments.index')->with('success', 'Data berhasil dihapus.');
        } catch (\Throwable $th) {
            logger()->error($th->getMessage());
            
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan.'])->withInput();
        }
    }
}
