<!DOCTYPE html>
<html>
<head>
    <title>Add Item</title> <!-- Menampilkan judul halaman "Add Item" yang ditampilkan di browser -->
</head>
<body>
    <h1>Add Item</h1> <!-- Heading utama halaman dengan teks "Add Item" -->
    <form action="{{ route('items.store') }}" method="POST"> <!-- Form untuk mengirim data item baru ke route 'items.store' dengan metode POST -->
        @csrf <!-- Menyertakan token CSRF untuk keamanan -->
        @csrf <!-- Menyertakan token CSRF untuk keamanan -->
        <label for="name">Name:</label> <!-- Label untuk input 'name' -->
        <input type="text" name="name" required> <!-- Input teks untuk nama item, wajib diisi -->
        <br> <!-- sebagai enter -->
        <label for="description">Description:</label> <!-- Label untuk textarea 'description' -->
        <textarea name="description" required></textarea> <!-- Area teks untuk deskripsi item, wajib diisi -->
        <br> <!-- sebagai enter -->
        <button type="submit">Add Item</button>  <!-- Button untuk mengirim form dan menambahkan item -->
    </form>
    <a href="{{ route('items.index') }}">Back to List</a> <!-- Link untuk kembali ke halaman daftar item -->
</body>
</html>