<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Faculty;
use App\Models\Fakultas;
use App\Models\Instrument;
use App\Models\Periode;
use App\Models\Prodi;
use App\Models\Program;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="AMI-UNG API",
 *      description="API documentation for AMI-UNG"
 * )

 */

class ApiController extends Controller
{

    /**
     * @OA\Get(
     *      path="/api/fakultas",
     *      tags={"Faculty"},
     *      summary="Get list of faculties",
     *      description="Mengambil data semua fakultas beserta prodi",
     *      @OA\Response(
     *          response=200,
     *          description="Data fakultas berhasil diambil",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="success", type="boolean", example=true),
     *              @OA\Property(property="message", type="string", example="Data fakultas berhasil diambil"),
     *              @OA\Property(property="data", type="array",
     *                  @OA\Items(
     *                      type="object",
     *                      @OA\Property(property="id", type="integer", example=1),
     *                      @OA\Property(property="faculty_name", type="string", example="Fakultas Teknik"),
     *                      @OA\Property(property="prodi", type="array",
     *                          @OA\Items(
     *                              type="object",
     *                              @OA\Property(property="id", type="integer", example=1),
     *                              @OA\Property(property="name", type="string", example="Teknik Informatika")
     *                          )
     *                      )
     *                  )
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Terjadi kesalahan",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="success", type="boolean", example=false),
     *              @OA\Property(property="message", type="string", example="Terjadi kesalahan"),
     *              @OA\Property(property="error", type="string", example="Server error message")
     *          )
     *      )
     * )
     */
    public function getFakultas(): JsonResponse
    {
        try {
            $fakultas = Faculty::with('departments')->get();
            return response()->json([
                'success' => true,
                'message' => 'Data fakultas berhasil diambil',
                'data' => $fakultas
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Get(
     *      path="/api/fakultas/{id}",
     *      tags={"Faculty"},
     *      summary="Get faculty by ID",
     *      description="Mengambil data fakultas berdasarkan ID",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="ID Fakultas",
     *          required=true,
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Data fakultas ditemukan",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="success", type="boolean", example=true),
     *              @OA\Property(property="message", type="string", example="Data fakultas ditemukan"),
     *              @OA\Property(property="data", type="object",
     *                  @OA\Property(property="id", type="integer", example=1),
     *                  @OA\Property(property="faculty_name", type="string", example="Fakultas Teknik"),
     *                  @OA\Property(property="departments", type="array",
     *                      @OA\Items(
     *                          type="object",
     *                          @OA\Property(property="id", type="integer", example=1),
     *                          @OA\Property(property="name", type="string", example="Teknik Informatika")
     *                      )
     *                  )
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Data tidak ditemukan",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="success", type="boolean", example=false),
     *              @OA\Property(property="message", type="string", example="Data fakultas tidak ditemukan")
     *          )
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Terjadi kesalahan",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="success", type="boolean", example=false),
     *              @OA\Property(property="message", type="string", example="Terjadi kesalahan"),
     *              @OA\Property(property="error", type="string", example="Server error message")
     *          )
     *      )
     * )
     */
    public function getFakultasById($id): JsonResponse
    {
        try {
            $fakultas = Faculty::with('departments')->find($id);

            if (!$fakultas) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data fakultas tidak ditemukan'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Data fakultas ditemukan',
                'data' => $fakultas
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    /**
     * @OA\Get(
     *      path="/api/departments",
     *      tags={"Department"},
     *      summary="Get list of departments",
     *      description="Mengambil data semua departemen beserta fakultas dan program studinya",
     *      @OA\Response(
     *          response=200,
     *          description="Data departemen berhasil diambil",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="success", type="boolean", example=true),
     *              @OA\Property(property="message", type="string", example="Data departemen berhasil diambil"),
     *              @OA\Property(property="data", type="array",
     *                  @OA\Items(
     *                      type="object",
     *                      @OA\Property(property="id", type="integer", example=1),
     *                      @OA\Property(property="department_name", type="string", example="Teknik Informatika"),
     *                      @OA\Property(property="faculty", type="object",
     *                          @OA\Property(property="id", type="integer", example=1),
     *                          @OA\Property(property="faculty_name", type="string", example="Fakultas Teknik")
     *                      ),
     *                      @OA\Property(property="programs", type="array",
     *                          @OA\Items(
     *                              type="object",
     *                              @OA\Property(property="id", type="integer", example=1),
     *                              @OA\Property(property="program_name", type="string", example="S1 Informatika")
     *                          )
     *                      )
     *                  )
     *              )
     *          )
     *      )
     * )
     */
    public function getDepartment(): JsonResponse
    {
        try {
            $departments = Department::with(['faculty', 'programs'])->get();
            return response()->json([
                'success' => true,
                'message' => 'Data departemen berhasil diambil',
                'data' => $departments
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Get(
     *      path="/api/departments/{id}",
     *      tags={"Department"},
     *      summary="Get department by ID",
     *      description="Mengambil data departemen berdasarkan ID beserta fakultas dan program studinya",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="ID Departemen",
     *          required=true,
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Data departemen ditemukan",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="success", type="boolean", example=true),
     *              @OA\Property(property="message", type="string", example="Data departemen ditemukan"),
     *              @OA\Property(property="data", type="object",
     *                  @OA\Property(property="id", type="integer", example=1),
     *                  @OA\Property(property="department_name", type="string", example="Teknik Informatika"),
     *                  @OA\Property(property="faculty", type="object",
     *                      @OA\Property(property="id", type="integer", example=1),
     *                      @OA\Property(property="faculty_name", type="string", example="Fakultas Teknik")
     *                  ),
     *                  @OA\Property(property="programs", type="array",
     *                      @OA\Items(
     *                          type="object",
     *                          @OA\Property(property="id", type="integer", example=1),
     *                          @OA\Property(property="program_name", type="string", example="S1 Informatika")
     *                      )
     *                  )
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Data tidak ditemukan",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="success", type="boolean", example=false),
     *              @OA\Property(property="message", type="string", example="Data departemen tidak ditemukan")
     *          )
     *      )
     * )
     */
    public function getDepartmentById($id): JsonResponse
    {
        try {
            $department = Department::with(['faculty', 'programs'])->find($id);

            if (!$department) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data departemen tidak ditemukan'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Data departemen ditemukan',
                'data' => $department
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Get(
     *      path="/api/programs",
     *      tags={"Program"},
     *      summary="Get list of programs",
     *      description="Mengambil data semua program beserta departemen dan fakultasnya",
     *      @OA\Response(
     *          response=200,
     *          description="Data program berhasil diambil",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="success", type="boolean", example=true),
     *              @OA\Property(property="message", type="string", example="Data program berhasil diambil"),
     *              @OA\Property(property="data", type="array",
     *                  @OA\Items(
     *                      type="object",
     *                      @OA\Property(property="id", type="integer", example=1),
     *                      @OA\Property(property="program_name", type="string", example="S1 Informatika"),
     *                      @OA\Property(property="department", type="object",
     *                          @OA\Property(property="id", type="integer", example=1),
     *                          @OA\Property(property="department_name", type="string", example="Teknik Informatika"),
     *                          @OA\Property(property="faculty", type="object",
     *                              @OA\Property(property="id", type="integer", example=1),
     *                              @OA\Property(property="faculty_name", type="string", example="Fakultas Teknik")
     *                          )
     *                      )
     *                  )
     *              )
     *          )
     *      )
     * )
     */
    public function getProgram(): JsonResponse
    {
        try {
            $programs = Program::with(['department.faculty'])->get();
            return response()->json([
                'success' => true,
                'message' => 'Data program berhasil diambil',
                'data' => $programs
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Get(
     *      path="/api/programs/{id}",
     *      tags={"Program"},
     *      summary="Get program by ID",
     *      description="Mengambil data program berdasarkan ID beserta departemen dan fakultasnya",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="ID Program",
     *          required=true,
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Data program ditemukan",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="success", type="boolean", example=true),
     *              @OA\Property(property="message", type="string", example="Data program ditemukan"),
     *              @OA\Property(property="data", type="object",
     *                  @OA\Property(property="id", type="integer", example=1),
     *                  @OA\Property(property="program_name", type="string", example="S1 Informatika"),
     *                  @OA\Property(property="department", type="object",
     *                      @OA\Property(property="id", type="integer", example=1),
     *                      @OA\Property(property="department_name", type="string", example="Teknik Informatika"),
     *                      @OA\Property(property="faculty", type="object",
     *                          @OA\Property(property="id", type="integer", example=1),
     *                          @OA\Property(property="faculty_name", type="string", example="Fakultas Teknik")
     *                      )
     *                  )
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Data tidak ditemukan",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="success", type="boolean", example=false),
     *              @OA\Property(property="message", type="string", example="Data program tidak ditemukan")
     *          )
     *      )
     * )
     */
    public function getProgramById($id): JsonResponse
    {
        try {
            $program = Program::with(['department.faculty'])->find($id);

            if (!$program) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data program tidak ditemukan'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Data program ditemukan',
                'data' => $program
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/programs/{id}/detail",
     *     summary="Get program detail by ID",
     *     tags={"Program"},
     *     description="Mengambil detail program studi berdasarkan ID termasuk department, faculty, user, instruments, periodes, audit results, compliance results, dan lainnya.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID Program Studi",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Data program ditemukan",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Data program ditemukan"),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="program_name", type="string", example="Teknik Informatika"),
     *                 @OA\Property(property="department", type="object",
     *                     @OA\Property(property="id", type="integer", example=2),
     *                     @OA\Property(property="department_name", type="string", example="Jurusan Teknik"),
     *                     @OA\Property(property="faculty", type="object",
     *                         @OA\Property(property="id", type="integer", example=3),
     *                         @OA\Property(property="faculty_name", type="string", example="Fakultas Teknik")
     *                     )
     *                 ),
     *                 @OA\Property(property="user", type="object",
     *                     @OA\Property(property="id", type="integer", example=5),
     *                     @OA\Property(property="name", type="string", example="John Doe")
     *                 ),
     *                 @OA\Property(property="instruments", type="array",
     *                     @OA\Items(type="object",
     *                         @OA\Property(property="id", type="integer", example=10),
     *                         @OA\Property(property="name", type="string", example="Instrument Audit 2024")
     *                     )
     *                 ),
     *                 @OA\Property(property="periodes", type="array",
     *                     @OA\Items(type="object",
     *                         @OA\Property(property="id", type="integer", example=20),
     *                         @OA\Property(property="periode_name", type="string", example="Periode Semester 1"),
     *                         @OA\Property(property="year", type="integer", example=2024)
     *                     )
     *                 ),
     *                 @OA\Property(property="auditResults", type="array",
     *                     @OA\Items(type="object",
     *                         @OA\Property(property="id", type="integer", example=30),
     *                         @OA\Property(property="result", type="string", example="Passed")
     *                     )
     *                 ),
     *                 @OA\Property(property="complianceResults", type="array",
     *                     @OA\Items(type="object",
     *                         @OA\Property(property="id", type="integer", example=40),
     *                         @OA\Property(property="status", type="string", example="Compliant")
     *                     )
     *                 ),
     *                 @OA\Property(property="noncomplianceResults", type="array",
     *                     @OA\Items(type="object",
     *                         @OA\Property(property="id", type="integer", example=50),
     *                         @OA\Property(property="issue", type="string", example="Documentation missing")
     *                     )
     *                 ),
     *                 @OA\Property(property="auditStatus", type="array",
     *                     @OA\Items(type="object",
     *                         @OA\Property(property="id", type="integer", example=60),
     *                         @OA\Property(property="status", type="string", example="Pending")
     *                     )
     *                 ),
     *                 @OA\Property(property="PTKs", type="array",
     *                     @OA\Items(type="object",
     *                         @OA\Property(property="id", type="integer", example=70),
     *                         @OA\Property(property="description", type="string", example="PTK Document")
     *                     )
     *                 ),
     *                 @OA\Property(property="PTPs", type="array",
     *                     @OA\Items(type="object",
     *                         @OA\Property(property="id", type="integer", example=80),
     *                         @OA\Property(property="description", type="string", example="PTP Evidence")
     *                     )
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Data program tidak ditemukan",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Data program tidak ditemukan")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Terjadi kesalahan",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Terjadi kesalahan"),
     *             @OA\Property(property="error", type="string", example="Detail error...")
     *         )
     *     )
     * )
     */


    public function getProgramByIdDetail($id): JsonResponse
    {
        try {
            $program = Program::with([
                'department.faculty',    // Ambil Department dan Faculty
                'user',                  // Ambil User yang berhubungan
                'instruments',           // Ambil Instruments terkait
                'periodes',              // Ambil Periodes terkait
                'auditResults',          // Ambil Audit Results
                'complianceResults',     // Ambil Compliance Results
                'noncomplianceResults',  // Ambil Non-Compliance Results
                'auditStatus',           // Ambil Audit Status
                'PTKs',                  // Ambil PTKs
                'PTPs'                   // Ambil PTPs
            ])->find($id);

            if (!$program) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data program tidak ditemukan'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Data program ditemukan',
                'data' => $program
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    /**
     * @OA\Get(
     *      path="/api/periodes",
     *      tags={"Periode"},
     *      summary="Get list of periodes",
     *      description="Mengambil data semua periode",
     *      @OA\Response(
     *          response=200,
     *          description="Data periode berhasil diambil",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="success", type="boolean", example=true),
     *              @OA\Property(property="message", type="string", example="Data periode berhasil diambil"),
     *              @OA\Property(property="data", type="array",
     *                  @OA\Items(
     *                      type="object",
     *                      @OA\Property(property="id", type="integer", example=1),
     *                      @OA\Property(property="periode_name", type="string", example="Periode 2024"),
     *                      @OA\Property(property="year", type="integer", example=2024),
     *                      @OA\Property(property="start_date", type="string", format="date", example="2024-01-01"),
     *                      @OA\Property(property="end_date", type="string", format="date", example="2024-12-31")
     *                  )
     *              )
     *          )
     *      )
     * )
     */
    public function getPeriode(): JsonResponse
    {
        try {
            $periodes = Periode::select('id', 'periode_name', 'year', 'start_date', 'end_date')->get();
            return response()->json([
                'success' => true,
                'message' => 'Data periode berhasil diambil',
                'data' => $periodes
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Get(
     *      path="/api/periodes/{id}",
     *      tags={"Periode"},
     *      summary="Get periode by ID",
     *      description="Mengambil data periode berdasarkan ID beserta standard dan instrument",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="ID Periode",
     *          required=true,
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Data periode ditemukan",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="success", type="boolean", example=true),
     *              @OA\Property(property="message", type="string", example="Data periode ditemukan"),
     *              @OA\Property(property="data", type="object",
     *                  @OA\Property(property="id", type="integer", example=1),
     *                  @OA\Property(property="periode_name", type="string", example="Periode 2024"),
     *                  @OA\Property(property="year", type="integer", example=2024),
     *                  @OA\Property(property="start_date", type="string", format="date", example="2024-01-01"),
     *                  @OA\Property(property="end_date", type="string", format="date", example="2024-12-31"),
     *                  @OA\Property(property="standard", type="object",
     *                      @OA\Property(property="id", type="integer", example=1),
     *                      @OA\Property(property="name", type="string", example="SN Dikti")
     *                  ),
     *                  @OA\Property(property="instruments", type="array",
     *                      @OA\Items(
     *                          type="object",
     *                          @OA\Property(property="id", type="integer", example=1),
     *                          @OA\Property(property="instrument_name", type="string", example="Instrumen A")
     *                      )
     *                  )
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Data tidak ditemukan",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="success", type="boolean", example=false),
     *              @OA\Property(property="message", type="string", example="Data periode tidak ditemukan")
     *          )
     *      )
     * )
     */
    public function getPeriodeById($id): JsonResponse
    {
        try {
            $periode = Periode::with(['standard', 'instruments'])->find($id);

            if (!$periode) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data periode tidak ditemukan'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Data periode ditemukan',
                'data' => $periode
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Get(
     *      path="/api/instruments",
     *      tags={"Instrument"},
     *      summary="Get list of instruments",
     *      description="Mengambil data semua instrumen (hanya name dan periode_id)",
     *      @OA\Response(
     *          response=200,
     *          description="Data instrument berhasil diambil",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="success", type="boolean", example=true),
     *              @OA\Property(property="message", type="string", example="Data instrument berhasil diambil"),
     *              @OA\Property(property="data", type="array",
     *                  @OA\Items(
     *                      type="object",
     *                      @OA\Property(property="id", type="integer", example=1),
     *                      @OA\Property(property="name", type="string", example="Instrumen A"),
     *                      @OA\Property(property="periode_id", type="integer", example=1)
     *                  )
     *              )
     *          )
     *      )
     * )
     */
    public function getInstrument(): JsonResponse
    {
        try {
            $instruments = Instrument::select('id', 'name', 'periode_id')->get();
            return response()->json([
                'success' => true,
                'message' => 'Data instrument berhasil diambil',
                'data' => $instruments
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Get(
     *      path="/api/instruments/{id}",
     *      tags={"Instrument"},
     *      summary="Get instrument by ID",
     *      description="Mengambil data instrument berdasarkan ID beserta questions",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="ID Instrument",
     *          required=true,
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Data instrument ditemukan",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="success", type="boolean", example=true),
     *              @OA\Property(property="message", type="string", example="Data instrument ditemukan"),
     *              @OA\Property(property="data", type="object",
     *                  @OA\Property(property="id", type="integer", example=1),
     *                  @OA\Property(property="name", type="string", example="Instrumen A"),
     *                  @OA\Property(property="periode_id", type="integer", example=1),
     *                  @OA\Property(property="questions", type="array",
     *                      @OA\Items(
     *                          type="object",
     *                          @OA\Property(property="id", type="integer", example=1),
     *                          @OA\Property(property="question_text", type="string", example="Apa yang dimaksud dengan SN Dikti?")
     *                      )
     *                  )
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Data tidak ditemukan",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="success", type="boolean", example=false),
     *              @OA\Property(property="message", type="string", example="Data instrument tidak ditemukan")
     *          )
     *      )
     * )
     */
    public function getInstrumentById($id): JsonResponse
    {
        try {
            $instrument = Instrument::with(['questions', 'units'])->find($id);

            if (!$instrument) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data instrument tidak ditemukan'
                ], 404);
            }

            // Ambil areas secara manual karena areas() adalah method, bukan relasi Eloquent
            // $instrument->setAttribute('areas', $instrument->areas());

            return response()->json([
                'success' => true,
                'message' => 'Data instrument ditemukan',
                'data' => $instrument
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan',
                'error' => $e->getMessage()
            ], 500);
        }
    }



}
