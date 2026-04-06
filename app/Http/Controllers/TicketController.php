<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TicketController extends Controller
{
    // --- AREA PUBLIK ---
   public function clientHome()
    {
        return view('client.home'); 
    }

    // Menampilkan Halaman Form Tiket (Terpisah)
    public function clientCreate()
    {
        return view('client.create'); 
    }
  public function clientStore(Request $request)
    {
        // 1. Validasi Inputan
        $request->validate([
            'location'       => 'required|string',
            'requester_name' => 'required|string|max:255',
            'divisi'         => 'required|string|max:255',
            'no_wa'          => 'required|string|max:20',
            'subject'        => 'required|string',
        ]);

        // 2. Generate Nomor Tiket Otomatis (Format: IT-LOKASI-001)
        
        // a. Tentukan Kode Singkatan Lokasi
        $lokasiString = strtolower($request->location);
        $kodeLokasi = 'PST'; // Default jika lokasi tidak terdeteksi

        if (\Illuminate\Support\Str::contains($lokasiString, 'krian')) {
            $kodeLokasi = 'KRIAN';
        } elseif (\Illuminate\Support\Str::contains($lokasiString, 'mojoagung')) {
            $kodeLokasi = 'MOJOAGUNG';
        } elseif (\Illuminate\Support\Str::contains($lokasiString, 'batang')) {
            $kodeLokasi = 'BATANG';
        }

        // b. Tentukan Awalan Tiket (Contoh: IT-KRIAN)
        $prefix = 'IT-' . $kodeLokasi;

        // c. Cari tiket terakhir di database yang berawalan lokasi tersebut
        $tiketTerakhir = Ticket::where('ticket_number', 'LIKE', $prefix . '-%')
                               ->orderBy('id', 'desc') // Ambil yang paling baru
                               ->first();

        // d. Buat urutan angka baru
        if ($tiketTerakhir) {
            // Potong 3 karakter dari kanan (misal dari IT-KRIAN-005, ambil "005") lalu ubah jadi angka dan tambah 1
            $urutanTerakhir = (int) substr($tiketTerakhir->ticket_number, -3);
            $urutanBaru = $urutanTerakhir + 1;
        } else {
            // Jika belum ada tiket sama sekali di pabrik tersebut
            $urutanBaru = 1;
        }

        // e. Gabungkan string dan padding dengan angka 0 di depan agar selalu 3 digit
        $nomorTiket = $prefix . '-' . str_pad($urutanBaru, 3, '0', STR_PAD_LEFT);

        // 3. LOGIKA PRIORITAS OTOMATIS (Deteksi Kata Kunci)
        // Ubah keluhan klien menjadi huruf kecil semua agar mudah dideteksi
        $keluhan = strtolower($request->subject);
        $prioritasOtomatis = 'Medium'; // Prioritas Default jika tidak ada kata kunci yang cocok

        // Deteksi tingkat CRITICAL (Sangat Kritis)
        if (Str::contains($keluhan, ['server mati', 'down', 'hack', 'kebakar', 'mati total', 'jaringan putus', 'internet mati', 'sistem down', 'darurat'])) {
            $prioritasOtomatis = 'Critical';
        } 
        // Deteksi tingkat HIGH (Tinggi)
        elseif (Str::contains($keluhan, ['tidak bisa login', 'error aplikasi', 'virus', 'penting', 'segera', 'lambat sekali', 'rusak parah'])) {
            $prioritasOtomatis = 'High';
        } 
        // Deteksi tingkat LOW (Rendah)
        elseif (Str::contains($keluhan, ['tanya', 'info', 'kabel', 'mouse', 'keyboard', 'tinta', 'kertas', 'cara', 'minta'])) {
            $prioritasOtomatis = 'Low';
        }

        // 4. Simpan ke Database
        Ticket::create([
            'ticket_number'  => $nomorTiket,
            'location'       => $request->location,
            'requester_name' => $request->requester_name,
            'divisi'         => $request->divisi,
            'no_wa'          => $request->no_wa,
            'subject'        => $request->subject,
            'priority'       => $prioritasOtomatis, // Masukkan variabel prioritas otomatis di sini
            'channel'        => 'Web Publik', 
            'status'         => 'New'
        ]);

        // 5. Kembali ke halaman klien dengan memunculkan pop-up nomor tiket
        return back()->with('ticket_success', $nomorTiket);
    }
    public function trackTicket()
    {
        return view('client.track');
    }

    // Memproses pencarian berdasarkan Nomor Tiket
    public function searchTicket(Request $request)
    {
        $request->validate([
            'ticket_number' => 'required|string'
        ]);

        // Cari tiket di database
        $ticket = Ticket::where('ticket_number', $request->ticket_number)->first();

        // Kembalikan ke halaman track dengan membawa data tiket dan status pencarian
        return view('client.track', compact('ticket'))->with('searched', true);
    }
    // --- AREA ADMIN ---
   public function index(Request $request)
    {
        $adminLocation = auth()->user()->location; // Ambil lokasi admin yang login
        
        // Filter tiket HANYA untuk pabrik admin tersebut
        $query = Ticket::where('location', $adminLocation);

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('ticket_number', 'like', '%' . $request->search . '%')
                  ->orWhere('subject', 'like', '%' . $request->search . '%')
                  ->orWhere('requester_name', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $tickets = $query->latest()->paginate(10);

        // Hitung badge sidebar hanya untuk pabrik ini
        $counts = [
            'All' => Ticket::where('location', $adminLocation)->count(),
            'New' => Ticket::where('location', $adminLocation)->where('status', 'New')->count(),
            'Open' => Ticket::where('location', $adminLocation)->where('status', 'Open')->count(),
            'On-hold' => Ticket::where('location', $adminLocation)->where('status', 'On-hold')->count(),
            'Resolved' => Ticket::where('location', $adminLocation)->where('status', 'Resolved')->count(),
        ];

        return view('tickets.index', compact('tickets', 'counts'));
    }

    public function show(Ticket $ticket)
    {
        $adminLocation = auth()->user()->location;

        // KEAMANAN TAMBAHAN: Cegah admin mengintip tiket dari pabrik lain via URL
        if ($ticket->location !== $adminLocation && $adminLocation !== null) {
            abort(403, 'Akses Ditolak: Ini adalah tiket dari cabang perusahaan lain.');
        }

        // PERBAIKAN: Menyamakan hitungan sidebar agar tidak berubah saat buka detail
        $counts = [
            'All' => Ticket::where('location', $adminLocation)->count(),
            'New' => Ticket::where('location', $adminLocation)->where('status', 'New')->count(),
            'Open' => Ticket::where('location', $adminLocation)->where('status', 'Open')->count(),
            'On-hold' => Ticket::where('location', $adminLocation)->where('status', 'On-hold')->count(),
            'Resolved' => Ticket::where('location', $adminLocation)->where('status', 'Resolved')->count(),
        ];
        
        return view('tickets.show', compact('ticket', 'counts'));
    }

    // Fungsi untuk Admin mengubah status tiket
    // Fungsi untuk Admin mengubah status tiket & teknisi
    public function update(Request $request, Ticket $ticket)
    {
        $request->validate([
            'status' => 'required|in:New,Open,On-hold,Pending,Resolved,Spam,Trash',
            'assigned_to' => 'nullable|string' // Validasi teknisi baru
        ]);

        $data = [
            'status' => $request->status,
            'assigned_to' => $request->assigned_to
        ];

        // 1. Catat Waktu Mulai otomatis saat status jadi "Open" (dan sebelumnya belum pernah dimulai)
        if ($request->status == 'Open' && is_null($ticket->started_at)) {
            $data['started_at'] = now();
        }

        // 2. Catat Waktu Selesai otomatis saat status jadi "Resolved" (dan sebelumnya belum selesai)
        if ($request->status == 'Resolved' && is_null($ticket->finished_at)) {
            $data['finished_at'] = now();
            
            // Jika tiket langsung di-Resolved tanpa di-Open dulu, set waktu mulai sama dengan waktu selesai
            if (is_null($ticket->started_at)) {
                $data['started_at'] = now();
            }
        }

        $ticket->update($data);

        return back()->with('success', 'Status dan penugasan tiket berhasil diperbarui!');
    }

    // Fungsi Menampilkan dan Memfilter Laporan
    public function report(Request $request)
    {
        $adminLocation = auth()->user()->location;
        
        // PERBAIKAN: Hanya query (tarik data) tiket sesuai lokasi pabrik admin
        $query = Ticket::where('location', $adminLocation);

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('created_at', [
                $request->start_date . ' 00:00:00',
                $request->end_date . ' 23:59:59'
            ]);
        }

        if ($request->filled('status') && $request->status != 'All') {
            $query->where('status', $request->status);
        }

        $tickets = $query->latest()->get();

        // PERBAIKAN: Hitung badge untuk sidebar khusus pabrik ini
        $counts = [
            'All' => Ticket::where('location', $adminLocation)->count(),
            'New' => Ticket::where('location', $adminLocation)->where('status', 'New')->count(),
            'Open' => Ticket::where('location', $adminLocation)->where('status', 'Open')->count(),
            'On-hold' => Ticket::where('location', $adminLocation)->where('status', 'On-hold')->count(),
            'Resolved' => Ticket::where('location', $adminLocation)->where('status', 'Resolved')->count(),
        ];

        return view('tickets.report', compact('tickets', 'counts'));
    }

    // Fungsi untuk mengecek tiket baru secara background (AJAX)
    public function checkNewTickets()
    {
        $adminLocation = auth()->user()->location;

        // PERBAIKAN: Hanya hitung dan notifkan tiket 'New' yang lokasinya sama dengan admin
        $count = Ticket::where('location', $adminLocation)->where('status', 'New')->count();
        $latest = Ticket::where('location', $adminLocation)->where('status', 'New')->latest()->first();

        return response()->json([
            'count' => $count,
            'latest_ticket' => $latest ? $latest->ticket_number : null,
            'requester' => $latest ? $latest->requester_name : null,
        ]);
    }
}