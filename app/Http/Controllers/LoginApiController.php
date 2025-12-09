<?php

namespace App\Http\Controllers;

use App\Models\department;
use App\Models\detail_departement;
use App\Models\position;
use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class LoginApiController extends Controller
{
    public function loginPortalAJI(Request $request)
    {
        // Mengambil token yang dikirim dari Portal AJI
        $encryptedToken = $request->token; // Mengambil token yang telah dienkripsi dari permintaan

        $token = base64_decode($encryptedToken); // Mendekode token yang dienkripsi menggunakan base64
        $client = new Client(); // Membuat instance baru dari Client untuk melakukan permintaan HTTP

        try {
            $response = $client->get(env('API_BASE_URL') . '/api/user', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $token,
                    'Accept' => 'application/json',
                ],
            ]);

            $data = json_decode($response->getBody()->getContents(), true);

            if (isset($data['status']) && $data['status'] === 'success') {
                $userData = $data['user'];

                $user = User::where('username', $userData['username'])->first();
                if ($user) {
                    Auth::loginUsingId($user->id);
                    $request->session()->regenerate();
                    //redirect kehalaman utama web (diganti sesuai website)
                    return redirect()->intended('/dashboard');
                }

                // Jika autentikasi gagal, redirect kembali ke web 1 dengan pesan error
                return redirect()->away(env('API_BASE_URL') . '?error=Password atau Username Salah');
            } else {
                return redirect()->away(env('API_BASE_URL') . '?error=Request API Gagal');
            }
        } catch (\Exception $e) {
            // Jika terjadi kesalahan, redirect kembali ke web 1 dengan pesan error
            return redirect()->away(env('API_BASE_URL') . '?error=Terjadi Kesalahan dalam masuk sub Website, Pastikan data sudah di Update');
        }
    }

    public function updateDataAPI(Request $request)
    {
        try {
            // Validasi input data
            $request->validate([
                'users' => 'required|array',
                'departments' => 'required|array',
                'detail_departments' => 'required|array',
                'positions' => 'required|array',
            ]);

            // Mengupdate model Department
            foreach ($request->input('departments') as $deptData) {
                department::updateOrCreate(
                    ['code' => $deptData['code']], // Sesuaikan dengan kolom unik
                    [
                        'code' => $deptData['code'],
                        'name' => $deptData['name'],
                        'email_depthead' => $deptData['email_depthead'] ?? null,
                        'email_spv' => $deptData['email_spv'] ?? null,
                        'email_members' => $deptData['email_members'] ?? null,
                        'deleted_at' => $deptData['deleted_at'] ?? null,
                    ],
                );
            }

            // Mengupdate model Detail_departement
            foreach ($request->input('detail_departments') as $detailDeptData) {
                detail_departement::updateOrCreate(
                    ['code' => $detailDeptData['code']], // Sesuaikan dengan kolom unik
                    [
                        'departement_id' => $detailDeptData['departement_id'],
                        'name' => $detailDeptData['name'],
                        'code' => $detailDeptData['code'] ?? null,
                        'email_depthead' => $detailDeptData['email_depthead'] ?? null,
                        'email_director' => $detailDeptData['email_director'] ?? null,
                        'email_spv' => $detailDeptData['email_spv'] ?? null,
                        'email_members' => $detailDeptData['email_members'] ?? null,
                    ],
                );
            }

            // Mengupdate model Position
            foreach ($request->input('positions') as $positionData) {
                position::updateOrCreate(
                    ['code' => $positionData['code']], // Sesuaikan dengan kolom unik
                    [
                        'position' => $positionData['position'],
                        'code' => $positionData['code'],
                    ],
                );
            }

            // Ambil data roles dan permissions dari request
            $allRole = $request->input('allRole');
            $allPermission = $request->input('allPermission');
            
            // Nonaktifkan foreign key constraints
            Schema::disableForeignKeyConstraints();

            // Bersihkan tabel roles dan permissions
            Role::truncate();
            Permission::truncate();

            // Bersihkan tabel pivot terkait
            DB::table('model_has_roles')->truncate();
            DB::table('model_has_permissions')->truncate();

            // Aktifkan kembali foreign key constraints
            Schema::enableForeignKeyConstraints();

            foreach ($allPermission as $permissionData) {
                    Permission::firstOrCreate(['name' => $permissionData['name']]);
            }

            foreach ($allRole as $roleData) {
                $newRole = Role::firstOrCreate([
                    'name' => $roleData['name'],
                ]);

                $permissions = [];
                foreach ($roleData['permissions'] as $permissionData) {
                    $NewPermissions = Permission::firstOrCreate([
                        'name' => $permissionData['name'],
                    ]);
                    $permissions[] = $NewPermissions['name'];
                }
                // Sync permissions
                $newRole->givePermissionTo($permissions);
            }

            // Mengupdate model User
            foreach ($request->input('users') as $userData) {
                if ($userData['deleted_at'] != null) {
                    $deleteUser = User::where('npk', $userData['npk'])->first();
                    if ($deleteUser) {
                        $deleteUser->delete();
                    }
                } else {
                    $user = User::updateOrCreate(
                        ['npk' => $userData['npk']],
                        [
                            'name' => $userData['name'],
                            'email' => $userData['email'],
                            'npk' => $userData['npk'] ?? null,
                            'username' => $userData['username'] ?? null, // Tambahkan null jika tidak ada
                            'gender' => $userData['gender'] ?? null,
                            'tgl_masuk' => $userData['tgl_masuk'] ?? null,
                            'tgl_lahir' => $userData['tgl_lahir'] ?? null,
                            'dept_id' => $userData['dept_id'] ?? null,
                            'position_id' => $userData['position_id'] ?? null,
                            'detail_dept_id' => $userData['detail_dept_id'] ?? null,
                            'golongan' => $userData['golongan'] ?? null,
                            'email_verified_at' => $userData['email_verified_at'] ?? null,
                            'password' => isset($userData['password']) ? $userData['password'] : null,
                        ],
                    );
                    // Mengupdate roles dan permissions jika ada
                    if (isset($userData['role']) || isset($userData['permissions'])) {
                        $user->syncRoles($userData['role'] ?? []);
                        $user->syncPermissions($userData['permissions'] ?? []);
                    }
                }
            }

            return response()->json(['success' => 'Data updated successfully']);
        } catch (\Exception $e) {
            // Log error untuk pengecekan jika dibutuhkan
            Log::error('Data update error: ' . $e->getMessage());

            return response()->json(['error' => $e->getMessage()]);
        }
    }
}