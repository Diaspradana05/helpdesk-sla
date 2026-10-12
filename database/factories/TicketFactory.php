<?php

namespace Database\Factories;

use App\Enums\TicketStatus;
use App\Models\Category;
use App\Models\Priority;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TicketFactory extends Factory
{
    protected array $subjects = [
        'Tidak bisa login ke aplikasi setelah update terbaru',
        'Invoice bulan ini belum muncul di dashboard',
        'Permintaan reset password akun perusahaan',
        'Fitur export laporan ke PDF mengalami error',
        'Lupa password dan email pemulihan tidak masuk',
        'Tagihan double charge pada kartu kredit',
        'Permintaan penambahan fitur dark mode',
        'Halaman dashboard loading terus tanpa henti',
        'Data pelanggan tidak tersimpan setelah submit form',
        'Akun diblokir otomatis tanpa alasan yang jelas',
        'Pertanyaan mengenai paket berlangganan tahunan',
        'Notifikasi email tidak terkirim ke pelanggan',
        'Permintaan integrasi dengan sistem pembayaran baru',
        'Error 500 saat mencoba mengunggah dokumen',
        'Perubahan nomor telepon tidak tersimpan di profil',
        'Laporan bug pada fitur pencarian produk',
        'Permintaan pembatalan langganan bulan ini',
        'Konfirmasi status pengembalian dana (refund)',
        'Tampilan aplikasi kacau di perangkat mobile',
        'Permintaan dokumentasi API untuk integrasi internal',
    ];

    protected array $descriptions = [
        'Saya sudah mencoba beberapa kali namun masalah ini masih terjadi. Mohon bantuannya untuk segera ditindaklanjuti karena cukup mengganggu aktivitas kerja kami.',
        'Masalah ini pertama kali muncul sejak pembaruan sistem terakhir. Sebelumnya tidak ada kendala sama sekali, jadi kami menduga ada bug dari update tersebut.',
        'Mohon informasinya terkait estimasi waktu penyelesaian, karena kami memiliki tenggat waktu yang cukup ketat untuk menyelesaikan pekerjaan ini.',
        'Kami sudah mencoba clear cache dan login ulang, tetapi masalah tetap sama. Berikut detail kronologi kejadian yang kami alami.',
        'Tim kami membutuhkan konfirmasi lebih lanjut mengenai hal ini sebelum melanjutkan proses ke tahap berikutnya.',
        'Ini adalah kedua kalinya kami mengalami masalah serupa dalam satu bulan terakhir. Mohon bisa diberikan solusi permanen.',
        'Kami ingin mengusulkan penambahan fitur ini karena akan sangat membantu efisiensi kerja tim kami sehari-hari.',
        'Mohon dibantu untuk pengecekan lebih lanjut, karena kami sudah mencoba berbagai cara namun belum menemukan solusinya.',
    ];

    public function definition(): array
    {
        $priority = Priority::inRandomOrder()->first();
        $created = fake()->dateTimeBetween('-30 days', 'now');
        $status = fake()->randomElement(TicketStatus::cases());
        $agent = $status === TicketStatus::Open
            ? null
            : User::role('agent')->inRandomOrder()->first();

        return [
            'ticket_number' => 'TKT-' . $created->format('Ymd') . '-' . fake()->unique()->numerify('####'),
            'subject' => fake()->randomElement($this->subjects),
            'description' => fake()->randomElement($this->descriptions),
            'customer_id' => User::role('customer')->inRandomOrder()->first()->id,
            'assigned_to' => $agent?->id,
            'category_id' => Category::inRandomOrder()->first()->id,
            'priority_id' => $priority->id,
            'status' => $status,
            'first_response_due_at' => (clone $created)->modify("+{$priority->first_response_minutes} minutes"),
            'resolution_due_at' => (clone $created)->modify("+{$priority->resolution_minutes} minutes"),
            'created_at' => $created,
            'updated_at' => $created,
        ];
    }
}