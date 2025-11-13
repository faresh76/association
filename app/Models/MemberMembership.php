<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class MemberMembership extends Model
{
    use HasFactory;

    protected $table = 'member_membership';
    protected $primaryKey = 'id';

    protected $fillable = [
        'member_id',
        'type_id',
        'start_date',
        'end_date',
        'is_active',
        'renew_no',
         'hide', 
    ];

        // Accessor to auto-format date
    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];


    // 🔹 Relationship to Member
    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id', 'member_id');
    }

    // 🔹 Relationship to MembershipType
    public function membershipType()
    {
        return $this->belongsTo(MembershipType::class, 'type_id', 'type_id');
    }
}
