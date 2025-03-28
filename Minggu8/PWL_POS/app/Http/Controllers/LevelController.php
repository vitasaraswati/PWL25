<?php

namespace App\Http\Controllers;

use App\Models\LevelModel; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class LevelController extends Controller
{
    public function index()
    {
        // DB::insert('insert into m_level(level_kode, level_nama, created_at) values(?, ?, ?)', ['CUS', 'Pelanggan', now()]);
        // return "Insert data baru berhasil";

        // $row = DB::update('update m_level set level_nama = ? where level_kode = ?', ['Customer', 'CUS']);
        // return "update data berhasil. Jumlah data yang diupdate: ".$row." baris";

        // $row = DB::delete('delete from m_level where level_kode = ?', ['CUS']);
        // return "Delete data berhasil. Jumlah data yang dihapus: ".$row." baris";

        // $data = DB::select('select * from m_level');
        // return view('level', ['data' => $data]);

        $breadcrumb = (object) [
            'title' => 'Daftar Level',
            'list' => ['Home', 'Level'],
        ];
    
        $page = (object) [
            'title' => 'Daftar level yang terdaftar dalam sistem',
        ];
    
        $activeMenu = 'level';
    
        $level = LevelModel::all(); // ambil semua data level dari db pwl_pos
    
        return view('level.index', ['breadcrumb' => $breadcrumb, 'activeMenu' => $activeMenu, 'page' => $page, 'level' => $level]);
    }

    // Ambil data level dalam bentuk json untuk datatables
    public function list(Request $request)
    {
        $levels = LevelModel::select('level_id', 'level_kode', 'level_nama');
  
        if ($request->level_id) {
            $levels->where('level_id', $request->level_id);
        }
  
        return DataTables::of($levels)
            ->addIndexColumn() // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex)
            ->addColumn('aksi', function ($level) { // menambahkan kolom aksi
                // $btn = '<a href="' . url('/level/' . $level->level_id) . '" class="btn btn-info btn-sm">Detail</a> ';
                // $btn .= '<a href="' . url('/level/' . $level->level_id . '/edit') . '" class="btn btn-warning btn-sm">Edit</a> ';
                // $btn .= '<form class="d-inline-block" method="POST" action="' . url('/level/' . $level->level_id) . '">'
                //     . csrf_field() . method_field('DELETE') .
                //     '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakin menghapus data ini?\');">Hapus</button></form>';
                $btn = '<button onclick="modalAction(\'' . url('/level/' . $level->level_id . '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/level/' . $level->level_id . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/level/' . $level->level_id . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';
                return $btn;
            })
            ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html
            ->make(true);
    }
  
    // Menampilkan form tambah level
    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah Level',
            'list' => ['Home', 'Level', 'Tambah'],
        ];
  
        $page = (object) [
            'title' => 'Tambah level baru',
        ];
  
        $activeMenu = 'level';
  
        return view('level.create', ['breadcrumb' => $breadcrumb, 'activeMenu' => $activeMenu, 'page' => $page]);
    }
  
      // Menyimpan data level baru
    public function store(Request $request)
    {
        $request->validate([
            'level_kode' => 'required|string|max:5',
            'level_nama' => 'required|string|max:100'
        ]);
  
        LevelModel::create([
            'level_kode' => $request->level_kode,
            'level_nama' => $request->level_nama
        ]);
  
        return redirect('/level')->with('success', 'Data level berhasil ditambahkan');
    }
  
    // Menampilkan detail level
    public function show(string $id)
    {
        $level = LevelModel::find($id);
  
        $breadcrumb = (object) [
            'title' => 'Detail Level',
            'list' => ['Home', 'Level', 'Detail'],
        ];
  
        $page = (object) [
            'title' => 'Detail level',
        ];
  
        $activeMenu = 'level';
  
        return view('level.show', ['breadcrumb' => $breadcrumb, 'activeMenu' => $activeMenu, 'page' => $page, 'level' => $level]);
    }
  
    // Menampilkan form edit level
    public function edit(string $id)
    {
        $level = LevelModel::find($id);
  
        $breadcrumb = (object) [
            'title' => 'Edit Level',
            'list' => ['Home', 'Level', 'Edit'],
        ];
  
        $page = (object) [
            'title' => 'Edit level',
        ];
  
        $activeMenu = 'level';
  
        return view('level.edit', ['breadcrumb' => $breadcrumb, 'activeMenu' => $activeMenu, 'page' => $page, 'level' => $level]);
    }
  
    // Memperbarui data level
    public function update(Request $request, string $id)
    {
        $request->validate([
            'level_kode' => 'required|string|max:5',
            'level_nama' => 'required|string|max:100'
        ]);
  
        LevelModel::find($id)->update([
            'level_kode' => $request->level_kode,
            'level_nama' => $request->level_nama
        ]);
  
        return redirect('/level')->with('success', 'Data level berhasil diubah');
    }
  
    // Menghapus data level
    public function destroy(string $id)
    {
        $check = LevelModel::find($id);
          if (!$check) {
              return redirect('/level')->with('error', 'Data level tidak ditemukan');
          }
  
          try {
              LevelModel::destroy($id);
              return redirect('/level')->with('success', 'Data level berhasil dihapus');
          } catch (\Illuminate\Database\QueryException $e) {
              return redirect('/level')->with('error', 'Data level gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
          }
      }

    //JOBSHEET 6 
    // membuat dan menampilkan halaman form tambah level dgn Ajax
    public function create_ajax()
    {
        return view('level.create_ajax');
    }

    // menyimpan data level baru dgn ajax
    public function store_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'level_kode' => 'required|string|max:5',
                'level_nama' => 'required|string|max:100',
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors(),
                ]);
            }
            LevelModel::create($request->all());
            return response()->json([
                'status' => true,
                'message' => 'Data level berhasil disimpan',
            ]);
        }
        return redirect('/');
    }

    // mengedit data level dgn ajax
    public function edit_ajax(string $id)
     {
         $level = LevelModel::find($id);
         return view('level.edit_ajax', ['level' => $level]);
 
     }

    // menyimpan data level yang sudah diedit dgn ajax 
     public function update_ajax(Request $request, string $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'level_kode' => 'required|string|max:5',
                'level_nama' => 'required|string|max:100',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors(),
                ]);
            }
            $check = LevelModel::find($id);
            if ($check) {
                $check->update($request->all());
                return response()->json([
                    'status' => true,
                    'message' => 'Data level berhasil diubah',
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data level tidak ditemukan',
                ]);
            }
        }
        return redirect('/');
    }

    // konfirmasi hapus data level dgn ajax
    public function confirm_ajax(string $id)
    {
        $level = LevelModel::find($id);

        return view('level.confirm_ajax', ['level' => $level]);
    }

    // menghapus data level dgn ajax
    public function delete_ajax(Request $request, string $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $level = LevelModel::find($id);
            if ($level) {
                $level->delete();
                return response()->json([
                    'status' => true,
                    'message' => 'Data level berhasil dihapus',
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data level tidak ditemukan',
                ]);
            }
        }
        return redirect('/');
    }

}