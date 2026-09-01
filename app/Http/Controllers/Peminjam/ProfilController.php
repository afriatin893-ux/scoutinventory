<?php

namespace App\Http\Controllers\Peminjam;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ProfilController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:peminjam');
    }

    // GET /peminjam/profile
    public function edit()
    {
        /** @var \App\Models\Peminjam $peminjam */
        $peminjam = Auth::guard('peminjam')->user();

        return view('peminjam.profil.edit', compact('peminjam'));
    }

    // PUT/PATCH /peminjam/profile
    public function update(Request $request)
    {
        /** @var \App\Models\Peminjam $peminjam */
        $peminjam = Auth::guard('peminjam')->user();

        $validator = Validator::make($request->all(), [
            'nama' => ['required', 'string', 'max:100'],
            'asal_organisasi' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:100', 'unique:peminjams,email,' . $peminjam->id_peminjam . ',id_peminjam'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $data = [
            'nama' => $request->nama,
            'asal_organisasi' => $request->asal_organisasi,
            'email' => $request->email,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $peminjam->update($data);

        return back()->with('success', 'Profil berhasil diperbarui.');
    }
}
