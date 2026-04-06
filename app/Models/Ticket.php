<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;
    
    // Tambahkan assigned_to, started_at, dan finished_at
    protected $fillable = [
        'ticket_number', 'location', 'subject', 'requester_name', 'divisi', 'no_wa', 'priority', 'status', 'channel', 'assigned_to', 'started_at', 'finished_at'
    ];

    // Beri tahu Laravel bahwa kolom ini adalah format Tanggal & Waktu
    protected $casts = [
        'started_at' => 'datetime',
        'finished_at' => 'datetime',
    ];
}