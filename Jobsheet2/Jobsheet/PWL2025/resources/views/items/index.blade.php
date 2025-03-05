<!DOCTYPE html>
<html>
<head>
    <title>Item List</title> <!-- Judul halaman yang ditampilkan di tab browser -->
</head>
<body>
    <h1>Items</h1> <!-- heading1 halaman dengan teks "Items" -->
    @if(session('success'))<!-- Mengecek apakah ada pesan sukses dalam session -->
        <p>{{ session('success') }}</p> <!-- Menampilkan pesan sukses jika ada -->
    @endif
    <a href="{{ route('items.create') }}">Add Item</a> <!-- Link untuk membuat item baru (mengarah ke halaman create) -->
    
    <ul>
        @foreach ($items as $item) <!-- Loop untuk menampilkan semua item dalam variabel $items -->
            <li>
                {{ $item->name }} - <!-- Menampilkan nama item -->
                <a href="{{ route('items.edit', $item) }}">Edit</a> <!-- Link untuk mengedit item, mengarah ke halaman edit -->
                <form action="{{ route('items.destroy', $item) }}" method="POST" style="display:inline;"> <!-- Form untuk menghapus item -->
                    @csrf <!-- Token CSRF-->
                    @method('DELETE') <!-- Menentukan metode form sebagai DELETE -->
                    <button type="submit">Delete</button> <!-- button untuk mengirim form delete -->
                </form>
            </li>
        @endforeach <!-- end dari loop -->
    </ul>
</body>
</html>