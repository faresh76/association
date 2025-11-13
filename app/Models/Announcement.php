<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    use HasFactory;

    protected $primaryKey = 'announcement_id';

    protected $casts = [
    'attachments' => 'array', // auto convert JSON <-> array
];


    // ✅ Tambah 'attachment' dalam fillable supaya boleh disimpan mass-assignment
    protected $fillable = [
        'title',
        'content',
        'start_date',
        'end_date',
        'is_active',
        'created_by',
        'attachments', // <--- Tambahan penting
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // ✅ Aksesori Status (auto computed)
    public function getStatusAttribute()
    {
        if ($this->is_active && $this->end_date && now()->gt($this->end_date)) {
            return 'Inactive';
        }

        return $this->is_active ? 'Active' : 'Inactive';
    }
}
