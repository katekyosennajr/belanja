<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Kategori;
use App\Models\Produk;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class BackupSeeder extends Seeder
{
    public function run(): void
    {
        $backup = [];

        // Backup Users
        if (Schema::hasTable('users')) {
            $backup['users'] = User::all()->toArray();
        }

        // Backup Kategoris
        if (Schema::hasTable('kategoris')) {
            $backup['kategoris'] = Kategori::all()->toArray();
        }

        // Backup Produks
        if (Schema::hasTable('produks')) {
            $backup['produks'] = Produk::all()->toArray();
        }

        // Simpan backup ke file
        file_put_contents(
            database_path('backup/data_backup_' . date('Y_m_d') . '.json'),
            json_encode($backup, JSON_PRETTY_PRINT)
        );
    }
}
