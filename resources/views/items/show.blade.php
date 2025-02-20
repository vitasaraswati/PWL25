<!DOCTYPE html>
<html>
<head>
    <title>Item List</title> <!-- Menampilkan judul halaman sebagai "Item List" yang akan ditampilkan di browser -->
</head>
<body>
    <h1>Items</h1> <!-- Heading utama halaman dengan teks "Items" -->
    @if(session('success')) <!-- Mengecek apakah ada pesan sukses dalam session -->
        <p>{{ session('success') }}</p> <!-- Jika ada, menampilkan pesan sukses -->
    @endif
    <a href="{{ route('items.create') }}">Add Item</a> <!-- Link untuk pembuatan item baru -->
    <ul>
        @foreach ($items as $item) <!-- Looping untuk menampilkan setiap item dalam variabel $items -->
            <li>
                {{ $item->name }} -  <!-- Menampilkan nama item -->
                <a href="{{ route('items.edit', $item) }}">Edit</a>  <!-- Link untuk mengedit item, mengarah ke halaman edit item berdasarkan $item -->
                <form action="{{ route('items.destroy', $item) }}" method="POST" style="display:inline;"> <!-- Form untuk menghapus item -->
                    @csrf <!-- Token CSRF  -->
                    @method('DELETE') <!-- Menyatakan bahwa form ini menggunakan metode DELETE -->
                    <button type="submit">Delete</button>  <!-- button submit form untuk methode delete -->
                </form>
            </li>
        @endforeach <!-- end dari loop -->
    </ul>
</body>
</html>
