<?php

namespace App\Http\Controllers;

use App\Models\PenjualanModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Barryvdh\DomPDF\Facade\PDF;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log; // Impor namespace Log

class PenjualanController extends Controller
{
    // Menampilkan halaman daftar penjualan
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Penjualan',
            'list' => ['Home', 'Penjualan'],
        ];

        $page = (object) [
            'title' => 'Daftar penjualan',
        ];

        $activeMenu = 'penjualan';

        $user = UserModel::all(); // Ambil semua data user untuk filter

        return view('penjualan.index', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => $activeMenu,
            'user' => $user
        ]);
    }

    // Ambil data penjualan dalam bentuk json untuk datatables
    public function list(Request $request)
    {
        $penjualans = PenjualanModel::with('user')
            ->select('penjualan_id', 'user_id', 'pembeli', 'penjualan_kode', 'penjualan_tanggal');

        // Filter berdasarkan user_id jika ada
        if ($request->user_id) {
            $penjualans->where('user_id', $request->user_id);
        }

        return DataTables::of($penjualans)
            ->addIndexColumn() // menambahkan kolom index
            ->addColumn('username', function ($penjualan) {
                return $penjualan->user->nama ?? 'N/A';
            })
            ->addColumn('aksi', function ($penjualan) {
                // menambahkan kolom aksi
                $btn = '<button onclick="modalAction(\'' . url('/penjualan/' . $penjualan->penjualan_id . '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/penjualan/' . $penjualan->penjualan_id . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/penjualan/' . $penjualan->penjualan_id . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';
                return $btn;
            })
            ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html
            ->make(true);
    }

    // Membuat dan menampilkan halaman form tambah penjualan dgn Ajax
    public function create_ajax()
    {
        $user = UserModel::all();
        return view('penjualan.create_ajax', compact('user'));
    }

    // Menyimpan data penjualan baru dgn ajax
    public function store_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'penjualan_kode'    => 'required|string|min:3|unique:t_penjualan,penjualan_kode',
                'pembeli'           => 'required|min:3',
                'penjualan_tanggal' => 'required|date',
                'user_id'           => 'required|integer'
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors(),
                ]);
            }

            PenjualanModel::create($request->all());

            return response()->json([
                'status' => true,
                'message' => 'Data penjualan berhasil disimpan'
            ]);
        }
        return redirect('/');
    }

    // Menampilkan detail penjualan dgn ajax
    public function show_ajax(string $id)
    {
        $penjualan = PenjualanModel::with('user')->find($id);
        return view('penjualan.show_ajax', ['penjualan' => $penjualan]);
    }

    // Mengedit data penjualan dgn ajax
    public function edit_ajax(string $id)
    {
        $penjualan = PenjualanModel::find($id);
        $user = UserModel::select('user_id', 'nama')->get();

        return view('penjualan.edit_ajax', ['penjualan' => $penjualan, 'user' => $user]);
    }

    // Menyimpan data penjualan yang sudah diedit dgn ajax
    public function update_ajax(Request $request, string $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'penjualan_kode'    => 'required|string|min:3|unique:t_penjualan,penjualan_kode,' . $id . ',penjualan_id',
                'user_id'           => 'required|integer',
                'pembeli'           => 'required|min:3',
                'penjualan_tanggal' => 'required|date'
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors(),
                ]);
            }

            $check = PenjualanModel::find($id);
            if ($check) {
                $check->update($request->all());
                return response()->json([
                    'status' => true,
                    'message' => 'Data penjualan berhasil diubah',
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data penjualan tidak ditemukan',
                ]);
            }
        }
        return redirect('/');
    }

    // Konfirmasi hapus data penjualan dgn ajax
    public function confirm_ajax(string $id)
    {
        $penjualan = PenjualanModel::find($id);
        return view('penjualan.confirm_ajax', ['penjualan' => $penjualan]);
    }

    // Menghapus data penjualan dgn ajax
    public function delete_ajax(Request $request, string $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $penjualan = PenjualanModel::find($id);
            if ($penjualan) {
                $penjualan->delete();
                return response()->json([
                    'status' => true,
                    'message' => 'Data penjualan berhasil dihapus',
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data penjualan tidak ditemukan',
                ]);
            }
        }
        return redirect('/');
    }

    // Menampilkan form impor penjualan
    public function import()
    {
        return view('penjualan.import');
    }

    // Impor file excel
    public function import_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'file_penjualan' => ['required', 'mimes:xlsx', 'max:1024']
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors()
                ]);
            }

            try {
                $file = $request->file('file_penjualan');
                $reader = IOFactory::createReader('Xlsx');
                $reader->setReadDataOnly(true);
                $spreadsheet = $reader->load($file->getRealPath());
                $sheet = $spreadsheet->getActiveSheet();
                $data = $sheet->toArray(null, false, true, true);

                $insert = [];
                if (count($data) > 1) {
                    foreach ($data as $baris => $value) {
                        if ($baris > 1 && !empty($value['A']) && !empty($value['B']) && !empty($value['C']) && !empty($value['D'])) {
                            // Validasi user_id
                            if (!UserModel::find($value['A'])) {
                                continue; // Skip jika user_id tidak ada
                            }

                            // Validasi penjualan_kode unik
                            if (PenjualanModel::where('penjualan_kode', $value['B'])->exists()) {
                                continue; // Skip jika penjualan_kode sudah ada
                            }

                            // Konversi tanggal dari nomor seri Excel atau string
                            $tanggal = null;
                            if (is_numeric($value['D'])) {
                                // Jika nomor seri Excel
                                $tanggal = Date::excelToDateTimeObject($value['D'])->format('Y-m-d');
                            } else {
                                // Jika string (misalnya, 13/04/2025)
                                try {
                                    $tanggal = Carbon::createFromFormat('d/m/Y', $value['D'])->format('Y-m-d');
                                } catch (\Exception $e) {
                                    continue; // Skip jika format tanggal tidak valid
                                }
                            }

                            $insert[] = [
                                'user_id'           => $value['A'],
                                'penjualan_kode'    => $value['B'],
                                'pembeli'           => $value['C'],
                                'penjualan_tanggal' => $tanggal,
                                'created_at'        => now(),
                            ];
                        }
                    }

                    if (count($insert) > 0) {
                        PenjualanModel::insertOrIgnore($insert);
                        return response()->json([
                            'status' => true,
                            'message' => 'Data berhasil diimport'
                        ]);
                    }
                }

                return response()->json([
                    'status' => false,
                    'message' => 'Tidak ada data yang valid untuk diimport'
                ]);
            } catch (\Exception $e) {
                Log::error('Impor gagal: ' . $e->getMessage()); // Sekarang Log sudah diimpor
                return response()->json([
                    'status' => false,
                    'message' => 'Terjadi kesalahan saat mengimpor: ' . $e->getMessage()
                ]);
            }
        }

        return redirect('/');
    }

    // Ekspor file excel
    public function export_excel()
    {
        // Ambil data penjualan yang akan diekspor
        $penjualans = PenjualanModel::select('user_id', 'penjualan_kode', 'pembeli', 'penjualan_tanggal')
            ->orderBy('penjualan_id')
            ->with('user')
            ->get();

        // Load library PhpSpreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet(); // ambil sheet yg aktif

        // Set header kolom
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Petugas');
        $sheet->setCellValue('C1', 'Kode Penjualan');
        $sheet->setCellValue('D1', 'Pembeli');
        $sheet->setCellValue('E1', 'Tanggal');

        $sheet->getStyle('A1:E1')->getFont()->setBold(true); // bold header

        // Looping isi data penjualan
        $no = 1; // mulai dari nomor 1
        $baris = 2; // data dimulai dari baris ke 2
        foreach ($penjualans as $penjualan) {
            $sheet->setCellValue('A' . $baris, $no);
            $sheet->setCellValue('B' . $baris, $penjualan->user->nama);
            $sheet->setCellValue('C' . $baris, $penjualan->penjualan_kode);
            $sheet->setCellValue('D' . $baris, $penjualan->pembeli);
            $sheet->setCellValue('E' . $baris, $penjualan->penjualan_tanggal);
            $baris++;
            $no++;
        }

        // Set auto size untuk kolom
        foreach (range('A', 'E') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        $sheet->setTitle('Data Penjualan'); // set title sheet

        $filename = 'Data_Penjualan_' . date('Y-m-d_H-i-s') . '.xlsx'; // generate nama file + dengan format tanggal

        // Set header untuk download file
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        header('Cache-Control: cache, must-revalidate');
        header('Pragma: public');

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
        exit;
    }

    // Ekspor PDF
    public function export_pdf()
    {
        $penjualans = PenjualanModel::with('user')
            ->select('penjualan_id', 'penjualan_kode', 'pembeli', 'user_id', 'penjualan_tanggal')
            ->orderBy('penjualan_id')
            ->get();

        $pdf = PDF::loadView('penjualan.export_pdf', ['penjualans' => $penjualans]);
        $pdf->setPaper('a4', 'portrait');
        $pdf->setOption("isRemoteEnabled", true);
        $pdf->render();

        return $pdf->stream('Data Penjualan ' . date('Y-m-d H:i:s') . '.pdf');
    }
}
