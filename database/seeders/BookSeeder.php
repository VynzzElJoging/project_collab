<?php

namespace Database\Seeders;

use App\Models\Book;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Book::create([
            'judul' => 'Laskar Pelangi',
            'penulis' => 'Andrea Hirata',
            'penerbit' => 'Bentang Pustaka',
            'tahun' => 2005,
            'kategori' => 'Novel',
            'stok' => 8,
            'cover' => 'images/book-placeholder.jpg',
        ]);

        Book::create([
            'judul' => 'Bumi Manusia',
            'penulis' => 'Pramoedya Ananta Toer',
            'penerbit' => 'Hasta Mitra',
            'tahun' => 1980,
            'kategori' => 'Novel',
            'stok' => 5,
            'cover' => 'images/book-placeholder.jpg',
        ]);

        Book::create([
            'judul' => 'Negeri 5 Menara',
            'penulis' => 'Ahmad Fuadi',
            'penerbit' => 'Gramedia',
            'tahun' => 2009,
            'kategori' => 'Novel',
            'stok' => 10,
            'cover' => 'images/book-placeholder.jpg',
        ]);

        Book::create([
            'judul' => 'Filosofi Teras',
            'penulis' => 'Henry Manampiring',
            'penerbit' => 'Kompas',
            'tahun' => 2018,
            'kategori' => 'Pengembangan Diri',
            'stok' => 7,
            'cover' => 'images/book-placeholder.jpg',
        ]);
    }
}
