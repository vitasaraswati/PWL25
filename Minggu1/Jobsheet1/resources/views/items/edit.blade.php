<!DOCTYPE html>
<html>
<head>
    <title>Edit Item</title> <!-- Menampilkan judul halaman "Edit Item" yang ditampilkan di browser -->
</head>
<body>
    <h1>Edit Item</h1> <!-- Heading utama halaman dengan teks "Edit Item" -->
    <form action="{{ route('items.update', $item) }}" method="POST"> <!-- Form untuk mengirimkan data item yang diedit ke route 'items.update' dengan metode POST -->
        @csrf <!-- token CSRF untuk keamanan -->
        @method('PUT') <!-- Menggunakan metode PUT untuk memberitahu bahwa form ini untuk update -->
        
        <label for="name">Name:</label> <!-- Label untuk input teks 'name' -->
        <input type="text" name="name" value="{{ $item->name }}" required> <!-- Input teks untuk nama item, menampilkan nilai saat ini sebagai value -->
        <br>
        <label for="description">Description:</label> <!-- Label untuk textarea 'description' -->
        <textarea name="description" required>{{ $item->description }}</textarea> //<!-- Area teks untuk deskripsi item, menampilkan nilai saat ini sebagai value -->
        <br> <!-- sebagai enter -->
        <button type="submit">Update Item</button> <!-- Button untuk mengirim form dan memperbarui item -->
    </form>
    </form>
    <a href="{{ route('items.index') }}">Back to List</a> <!-- Link untuk kembali ke halaman daftar item -->
</body>
</html>