<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class FeesPayment extends Model
{
    use HasFactory;

    protected $table = 'fees_payments';
    protected $primaryKey = 'payment_id';
    public $timestamps = false;

    protected $fillable = [
        'member_id',
        'amount',
        'payment_date',
        'payment_method',
        'reference_no',
        'remarks',
    ];

        // ✅ Cast payment_date to datetime
    protected $casts = [
        'payment_date' => 'datetime',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id', 'member_id');
    }

}
