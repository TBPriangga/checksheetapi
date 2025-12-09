<?php

namespace App\Http\Controllers;

use App\Models\Suggestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Department;
use App\Models\DetailDepartement;

class SuggestionController extends Controller
{
    public function showSubmitForm()
    {
        return view('ss.user_admin.submitadmin');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'npk' => 'required|string|max:50|unique:suggestions,npk',
            'departemen' => 'required|string|max:255',
            'section' => 'required|string|max:255',
            'kategori_ide' => 'required|string|max:255',
            'cost_saving_currency' => 'required|in:IDR,USD',
            'cost_saving_amount' => 'required|numeric|min:0',
            'judul_ide' => 'required|string|max:255',
            'before' => 'required|string',
            'after' => 'required|string',
            'before_image' => 'nullable|image|mimes:jpg,png|max:10240', // Max 10MB
            'after_image' => 'nullable|image|mimes:jpg,png|max:10240', // Max 10MB
        ], [
            'cost_saving_currency.required' => 'Harap pilih mata uang (IDR atau USD).',
            'cost_saving_currency.in' => 'Mata uang harus IDR atau USD.',
            'cost_saving_amount.required' => 'Harap masukkan jumlah Cost Saving.',
            'cost_saving_amount.numeric' => 'Jumlah harus berupa angka.',
            'cost_saving_amount.min' => 'Jumlah tidak boleh kurang dari 0.',
        ]);

        // Simpan gambar jika ada
        $beforeImagePath = $request->file('before_image') ? $request->file('before_image')->store('uploads', 'public') : null;
        $afterImagePath = $request->file('after_image') ? $request->file('after_image')->store('uploads', 'public') : null;

        // Simpan ke database dengan kolom terpisah
        Suggestion::create([
            'nama' => $validated['nama'],
            'npk' => $validated['npk'],
            'departemen' => $validated['departemen'],
            'section' => $validated['section'],
            'kategori_ide' => $validated['kategori_ide'],
            'cost_currency' => $validated['cost_saving_currency'],
            'cost_amount' => $validated['cost_saving_amount'],
            'judul_ide' => $validated['judul_ide'],
            'before' => $validated['before'],
            'after' => $validated['after'],
            'before_image' => $beforeImagePath,
            'after_image' => $afterImagePath,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('ss.submitadmin')->with('success', 'Ide berhasil disubmit!');
    }

    public function getDepartments(Request $request)
    {
        $term = $request->query('term', '');
        $departments = Department::where('name', 'LIKE', "%{$term}%")
            ->pluck('name')
            ->toArray();
        return response()->json($departments);
    }

    public function getDetailDepartments(Request $request)
    {
        $term = $request->query('term', '');
        $detailDepartments = DetailDepartement::where('name', 'LIKE', "%{$term}%")
            ->pluck('name')
            ->toArray();
        return response()->json($detailDepartments);
    }

    public function uploadImage(Request $request)
    {
        $request->validate([
            'before_image' => 'nullable|image|mimes:jpg,png|max:10240',
            'after_image' => 'nullable|image|mimes:jpg,png|max:10240',
        ]);

        $fieldName = array_key_first($request->all());
        $file = $request->file($fieldName);

        if ($file) {
            $path = $file->store('uploads', 'public');
            $url = Storage::url($path);
            return response()->json(['url' => $url]);
        }

        return response()->json(['error' => 'No file uploaded'], 400);
    }
}