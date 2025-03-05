<?php

namespace App\Http\Controllers; //Menetapkan namespace App\Http\Controllers.

use App\Models\Item; ////menggunakan model Item dari Laravel
use Illuminate\Http\Request; //menggunakan model request dari Laravel

class ItemController extends Controller //deklarasi ItemController yang mewarisi Controller
{
    
    public function index() //deklarasi fungsi index
    {
        $items = Item::all(); //impor semua data Item 
        return view('items.index', compact('items')); //impor semua data Item ke view items.index
    }

    public function create() //deklarasi fungsi membuat item baru
    {
        return view('items.create'); //impor data yang dibuat ke view items.create
    }

    public function store(Request $request) //method store
    {
        $request->validate([ //validasi input (name dan description wajib diisi).
            'name' => 'required',   //nama wajib diisi 
            'description' => 'required', //deskripsi wajib diisi 
        ]);


         // Hanya masukkan atribut yang diizinkan
        Item::create($request->only(['name', 'description']));
        return redirect()->route('items.index')->with('success', 'Item added successfully.'); //Redirect ke halaman index, dan display message 
    }

    public function show(string $id) // Method untuk menampilkan halaman detail item
    {
        return view('items.show', compact('item')); // Mengirim data item ke tampilan 'items.show'
    }

    public function edit(string $id) //// Method untuk menampilkan halaman edit item
    {
        return view('items.edit', compact('item')); // Mengirim data item ke tampilan 'items.edit'
    }

    public function update(Request $request, Item $item)// Method untuk memperbarui item
    {
        $request->validate([
            'name' => 'required', // Validasi: name wajib diisi
            'description' => 'required', // Validasi: description wajib diisi
        ]);
         

        // Hanya masukkan atribut yang diizinkan
         $item->update($request->only(['name', 'description']));  // Update item dengan data yang valid
        return redirect()->route('items.index')->with('success', 'Item updated successfully.'); // Update item dengan data yang valid, display suskses
    }

    public function destroy(Item $item) //// Method untuk hapus item
    {
        // return redirect()->route('items.index');
       $item->delete(); // Hapus item dari database
       return redirect()->route('items.index')->with('success', 'Item deleted successfully.'); // Redirect ke halaman daftar item, display sukses 
    }
}