<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Area;
use App\Models\Report;
use App\Models\ReportReview;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        //1. Akun Demo untuk Ketiga Role
        $pelapor1 = User::create([
            'username'     => 'kevin',
            'nama_lengkap' => 'Kevin Akbar (Masyarakat Pelapor)',
            'email'        => 'kevin@example.com',
            'password'     => Hash::make('password123'),
            'role'         => 'pelapor',
        ]);

        $pelapor2 = User::create([
            'username'     => 'raihan',
            'nama_lengkap' => 'Raihan Elshirazy',
            'email'        => 'raihan@example.com',
            'password'     => Hash::make('password123'),
            'role'         => 'pelapor',
        ]);

        $relawan = User::create([
            'username'     => 'lycoris',
            'nama_lengkap' => 'Lycoris Rade (Relawan Pemantau)',
            'email'        => 'lycoris@example.com',
            'password'     => Hash::make('password123'),
            'role'         => 'relawan',
        ]);

        $koordinator = User::create([
            'username'     => 'skirk',
            'nama_lengkap' => 'Skirk (Koordinator Relawan)',
            'email'        => 'skirk@example.com',
            'password'     => Hash::make('password123'),
            'role'         => 'koordinator',
        ]);

        //2. Data Master Wilayah/Area
        $areaA = Area::create([
            'nama_area'      => 'Kawasan Perkebunan Sawit Blok Utara',
            'kabupaten_kota' => 'Kabupaten Siak',
            'default_lat'    => 0.7892150,
            'default_long'   => 101.6543210,
        ]);

        $areaB = Area::create([
            'nama_area'      => 'Lahan Gambut Desa Rawa Makmur',
            'kabupaten_kota' => 'Kabupaten Pelalawan',
            'default_lat'    => 0.3214500,
            'default_long'   => 101.9876540,
        ]);

        $areaC = Area::create([
            'nama_area'      => 'Hutan Lindung Bukit Suligi',
            'kabupaten_kota' => 'Kabupaten Rokan Hulu',
            'default_lat'    => 0.5432100,
            'default_long'   => 100.4321000,
        ]);

        //3. Data Laporan Demo (Mencakup Berbagai Status)
        
        //Laporan 1: Baru masuk (menunggu peninjauan) milik Andi
        Report::create([
            'user_id'        => $pelapor1->id,
            'area_id'        => $areaA->id,
            'judul'          => 'Kepulan asap tebal di dekat kebun sawit',
            'deskripsi'      => 'Terlihat asap hitam pekat mengepul dari balik kanal parit batas kebun warga.',
            'latitude'       => 0.7893000,
            'longitude'      => 101.6544000,
            'waktu_kejadian' => now()->subHours(2),
            'bukti_path'     => null,
            'status'         => 'menunggu_peninjauan',
        ]);

        //Laporan 2: Sudah diverifikasi oleh relawan
        $laporan2 = Report::create([
            'user_id'        => $pelapor1->id,
            'area_id'        => $areaB->id,
            'judul'          => 'Titik api di lahan gambut bekas tebasan',
            'deskripsi'      => 'Lahan seluas kurang lebih 1 hektar mulai terbakar dan angin kencang ke arah timur.',
            'latitude'       => 0.3215000,
            'longitude'      => 101.9877000,
            'waktu_kejadian' => now()->subHours(5),
            'bukti_path'     => null,
            'status'         => 'diverifikasi',
        ]);

        ReportReview::create([
            'report_id'         => $laporan2->id,
            'user_id'           => $relawan->id,
            'status_sebelumnya' => 'menunggu_peninjauan',
            'status_baru'       => 'diverifikasi',
            'catatan'           => 'Informasi valid dan cocok dengan pantauan warga sekitar. Membutuhkan tindakan cepat.',
        ]);

        //Laporan 3: Diteruskan ke instansi oleh koordinator
        $laporan3 = Report::create([
            'user_id'        => $pelapor2->id,
            'area_id'        => $areaA->id,
            'judul'          => 'Kebakaran meluas mendekati pemukiman',
            'deskripsi'      => 'Jarak api tersisa sekitar 200 meter dari batas rumah terluar.',
            'latitude'       => 0.7899000,
            'longitude'      => 101.6550000,
            'waktu_kejadian' => now()->subDay(),
            'bukti_path'     => null,
            'status'         => 'diteruskan',
        ]);

        ReportReview::create([
            'report_id'         => $laporan3->id,
            'user_id'           => $koordinator->id,
            'status_sebelumnya' => 'diverifikasi',
            'status_baru'       => 'diteruskan',
            'catatan'           => 'Laporan telah diteruskan via telepon ke BPBD dan Manggala Agni Daops Siak.',
        ]);
    }
}