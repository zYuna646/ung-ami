<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest;
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
        $validTypes = ['unit', 'faculty', 'department', 'program'];

        if (!$request->has('type') || !in_array($request->type, $validTypes)) {
            return redirect()->route('dashboard.users.auditees.index', ['type' => 'unit']);
        }

        $users = User::latest()->whereHas($request->type)->get();

        return view('pages.dashboard.users.auditees.index', compact('users'));
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
