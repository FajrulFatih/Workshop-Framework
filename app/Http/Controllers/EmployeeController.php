<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Department;
use App\Models\Position;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Exports\EmployeesExport;
use Maatwebsite\Excel\Facades\Excel;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Stats untuk cards
        $stats = [
            'total' => Employee::count(),
            'active' => Employee::where('status', 'aktif')->count(),
            'inactive' => Employee::where('status', 'nonaktif')->count(),
            'newThisMonth' => Employee::whereMonth('tanggal_masuk', now()->month)->whereYear('tanggal_masuk', now()->year)->count(),
        ];

        // Recent activity
        $recentEmployees = Employee::latest('tanggal_masuk')->take(3)->get();

        // Query builder
        $query = Employee::with(['department', 'position']);

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filter by Department
        if ($request->filled('department')) {
            $query->where('department_id', $request->department);
        }

        // Filter by Position
        if ($request->filled('position')) {
            $query->where('position_id', $request->position);
        }

        // Filter by Status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by Date Range
        if ($request->filled('date_from')) {
            $query->whereDate('tanggal_masuk', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('tanggal_masuk', '<=', $request->date_to);
        }

        // Quick Filters
        if ($request->filled('quick_filter')) {
            switch ($request->quick_filter) {
                case 'new':
                    // Pegawai baru (3 bulan terakhir)
                    $query->where('tanggal_masuk', '>=', now()->subMonths(3));
                    break;
                case 'senior':
                    // Pegawai senior (lebih dari 2 tahun)
                    $query->where('tanggal_masuk', '<=', now()->subYears(2));
                    break;
                case 'this_month':
                    // Bergabung bulan ini
                    $query->whereMonth('tanggal_masuk', now()->month)->whereYear('tanggal_masuk', now()->year);
                    break;
            }
        }

        // Sorting
        $sortBy = $request->get('sort', 'nama_lengkap');
        $sortOrder = $request->get('order', 'asc');

        if ($sortBy === 'nama_lengkap') {
            $query->orderBy('nama_lengkap', $sortOrder);
        } elseif ($sortBy === 'tanggal_masuk') {
            $query->orderBy('tanggal_masuk', $sortOrder);
        } elseif ($sortBy === 'department') {
            $query->join('departments', 'employees.department_id', '=', 'departments.id')->orderBy('departments.nama_department', $sortOrder)->select('employees.*');
        }

        // Pagination
        $perPage = $request->get('per_page', 10);
        $employees = $query->paginate($perPage)->withQueryString();

        // Data untuk dropdowns
        $departments = Department::all();
        $positions = Position::all();

        return view('employees.index', compact('employees', 'departments', 'positions', 'stats', 'recentEmployees'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('employees.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'nomor_telepon' => 'required|string|max:20',
            'tanggal_lahir' => 'required|date',
            'tanggal_masuk' => 'required|date',
            'alamat' => 'required|string|max:255',
            'department_id' => 'required|exists:departments,id',
            'position_id' => 'required|exists:positions,id',
            'status' => 'required|string|max:50',
        ]);

        try {
            DB::beginTransaction();

            // 1. Buat User baru dengan role 'user' dan password default
            $user = User::create([
                'name' => $validated['nama_lengkap'],
                'email' => $validated['email'],
                'password' => Hash::make('password123'), // Password default
                'role' => 'user', // Set role sebagai user
            ]);

            // 2. Buat Employee dan hubungkan dengan User
            $validated['user_id'] = $user->id;
            $employee = Employee::create($validated);

            DB::commit();

            return redirect()->route('employees.index')->with('success', 'Karyawan dan akun user berhasil dibuat! Password default: password123');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->with('error', 'Gagal menyimpan data: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $employee = Employee::with(['department', 'position'])->findOrFail($id);
        return view('employees.show', compact('employee'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $employee = Employee::with(['department', 'position'])->findOrFail($id);
        $departments = Department::all();
        $positions = Position::all();
        return view('employees.edit', compact('employee', 'departments', 'positions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'nomor_telepon' => 'required|string|max:20',
            'tanggal_lahir' => 'required|date',
            'tanggal_masuk' => 'required|date',
            'alamat' => 'required|string|max:255',
            'department_id' => 'required|exists:departments,id',
            'position_id' => 'required|exists:positions,id',
            'status' => 'required|string|max:50',
        ]);
        $employee = Employee::with(['department', 'position'])->findOrFail($id);
        try {
            DB::beginTransaction();

            // Update User
            if ($employee->user) {
                $employee->user->update([
                    'name' => $request->nama_lengkap,
                    'email' => $request->email,
                ]);
            }

            // Update Employee
            $employee->update($request->only(['nama_lengkap', 'email', 'nomor_telepon', 'tanggal_lahir', 'tanggal_masuk', 'alamat', 'department_id', 'position_id', 'status']));

            DB::commit();

            return redirect()->route('employees.index')->with('success', 'Data berhasil diperbarui!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal memperbarui data: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $employee = Employee::with('department', 'position')->find($id);
        if ($employee) {
            try {
                DB::beginTransaction();

                // Hapus User terkait (cascade akan hapus employee juga karena onDelete cascade)
                if ($employee->user) {
                    $employee->user->delete();
                }

                DB::commit();

                return redirect()->route('employees.index')->with('success', 'Data berhasil dihapus!');
            } catch (\Exception $e) {
                DB::rollBack();
                return back()->with('error', 'Gagal menghapus data: ' . $e->getMessage());
            }
        }

        return back()->with('error', 'Data tidak ditemukan.');
    }

    public function export()
    {
        return Excel::download(new EmployeesExport(), 'employees-' . now()->format('Y-m-d') . '.xlsx');
    }
}
