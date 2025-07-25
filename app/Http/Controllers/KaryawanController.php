<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\Keluarga;
use App\Models\Pendidikan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class KaryawanController extends Controller
{

    // public function getKaryawan()
    // {
    //     $karyawanData = Karyawan::with(['pendidikans', 'keluargas'])
    //         ->orderBy('id', 'desc')
    //         ->get();

    //     return response()->json(['data' => $karyawanData]);
    // }

    public function getKaryawan(Request $request)
{
    $query = Karyawan::with(['pendidikans', 'keluargas']);

    // Filter jenis kelamin jika ada
    if ($request->filled('jenis_kelamin')) {
        $query->where('jenis_kelamin', $request->jenis_kelamin);
    }

    // Filter jenjang pendidikan jika ada
    if ($request->filled('jenjang')) {
        $query->whereHas('pendidikans', function ($q) use ($request) {
            $q->where('jenjang', $request->jenjang);
        });
    }

    $data = $query->orderByDesc('id')->get();

    return response()->json([
        'data' => $data // DataTables butuh key ini
    ]);
}



    public function karyawanById($id)
    {
        $karyawan = Karyawan::with(['pendidikans', 'keluargas'])->findOrFail($id);
        return response()->json(['data' => $karyawan]);
    }

    public function delete(Request $request)
    {
        $id = $request->input('id');
        $akses = Karyawan::findOrFail($id);
        $akses->delete();

        return response()->json(['message' => 'Karyawan berhasil dihapus'], 200);
    }


    public function create(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'no_karyawan' => 'required|string|unique:karyawans,no_karyawan',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:1,2',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        DB::beginTransaction();
        try {
            // Data utama karyawan
            $data = $request->only([
                'nama_lengkap',
                'no_karyawan',
                'tempat_lahir',
                'tanggal_lahir',
                'jenis_kelamin'
            ]);

            // Simpan foto jika ada
            if ($request->hasFile('foto')) {
                $path = $request->file('foto')->store('uploads/karyawan', 'public');
                $data['foto'] = 'storage/' . $path;
            }

            // Simpan karyawan
            $karyawan = Karyawan::create($data);

            // Simpan data pendidikan
            if ($request->has('pendidikan')) {
                foreach ($request->pendidikan as $item) {
                    if (!empty($item['jenjang']) && !empty($item['institusi'])) {
                        Pendidikan::create([
                            'karyawan_id' => $karyawan->id,
                            'jenjang' => $item['jenjang'],
                            'institusi' => $item['institusi'],
                            'tanggal_lulus' => null, // default null (bisa ditambahkan input-nya nanti)
                        ]);
                    }
                }
            }

            // Simpan data keluarga
            if ($request->has('keluarga')) {
                foreach ($request->keluarga as $item) {
                    if (!empty($item['nama']) && !empty($item['hubungan'])) {
                        Keluarga::create([
                            'karyawan_id' => $karyawan->id,
                            'nama_keluarga' => $item['nama'],
                            'hubungan' => $item['hubungan'],
                        ]);
                    }
                }
            }

            DB::commit();
            return response()->json([
                'message' => 'Karyawan berhasil ditambahkan.',
                'data' => $karyawan
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'message' => 'Gagal menyimpan data: ' . $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request)
    {
        $id = $request->input('karyawan_id'); // ambil dari input hidden
        $request->validate([
            'karyawan_id' => 'required|exists:karyawans,id',
            'nama_lengkap' => 'required|string|max:255',
            'no_karyawan' => "required|string|unique:karyawans,no_karyawan," . $request->karyawan_id,
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:1,2',
            // 'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'foto' => 'sometimes|nullable|file|image|mimes:jpg,jpeg,png|max:2048',

        ]);

        DB::beginTransaction();
        try {
            $karyawan = Karyawan::with(['pendidikans', 'keluargas'])->findOrFail($request->karyawan_id);

            // Update data utama
            $karyawan->nama_lengkap = $request->nama_lengkap;
            $karyawan->no_karyawan = $request->no_karyawan;
            $karyawan->tempat_lahir = $request->tempat_lahir;
            $karyawan->tanggal_lahir = $request->tanggal_lahir;
            $karyawan->jenis_kelamin = $request->jenis_kelamin;

            // Update foto jika ada
            if ($request->hasFile('foto')) {
                if ($karyawan->foto && \Illuminate\Support\Facades\Storage::disk('public')->exists(str_replace('storage/', '', $karyawan->foto))) {
                    \Illuminate\Support\Facades\Storage::disk('public')->delete(str_replace('storage/', '', $karyawan->foto));
                }
                $path = $request->file('foto')->store('uploads/karyawan', 'public');
                $karyawan->foto = 'storage/' . $path;
            }

            $karyawan->save();

            // Handle pendidikan
            $requestPendidikan = $request->input('pendidikan', []);
            $updatedIds = [];

            foreach ($requestPendidikan as $data) {
                if (!empty($data['jenjang']) && !empty($data['institusi'])) {
                    if (!empty($data['id'])) {
                        $pendidikan = Pendidikan::find($data['id']);
                        if ($pendidikan) {
                            $pendidikan->update([
                                'jenjang' => $data['jenjang'],
                                'institusi' => $data['institusi'],
                            ]);
                            $updatedIds[] = $pendidikan->id;
                        }
                    } else {
                        $new = Pendidikan::create([
                            'karyawan_id' => $karyawan->id,
                            'jenjang' => $data['jenjang'],
                            'institusi' => $data['institusi'],
                        ]);
                        $updatedIds[] = $new->id;
                    }
                }
            }

            Pendidikan::where('karyawan_id', $karyawan->id)
                ->whereNotIn('id', $updatedIds)->delete();

            // Handle keluarga
            $requestKeluarga = $request->input('keluarga', []);
            $updatedKeluargaIds = [];

            foreach ($requestKeluarga as $data) {
                if (!empty($data['nama']) && !empty($data['hubungan'])) {
                    if (!empty($data['id'])) {
                        $keluarga = Keluarga::find($data['id']);
                        if ($keluarga) {
                            $keluarga->update([
                                'nama_keluarga' => $data['nama'],
                                'hubungan' => $data['hubungan'],
                            ]);
                            $updatedKeluargaIds[] = $keluarga->id;
                        }
                    } else {
                        $new = Keluarga::create([
                            'karyawan_id' => $karyawan->id,
                            'nama_keluarga' => $data['nama'],
                            'hubungan' => $data['hubungan'],
                        ]);
                        $updatedKeluargaIds[] = $new->id;
                    }
                }
            }

            Keluarga::where('karyawan_id', $karyawan->id)
                ->whereNotIn('id', $updatedKeluargaIds)->delete();

            DB::commit();
            return response()->json(['message' => 'Karyawan berhasil diperbarui.', 'data' => $karyawan]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Gagal memperbarui data: ' . $e->getMessage()], 500);
        }
    }
}
