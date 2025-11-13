<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $primaryKey = 'member_id';

    protected $fillable = [
        'member_no', 'full_name', 'ic_no', 'gender', 'date_of_birth',
        'phone', 'email', 'address', 'occupation', 'join_date', 'status'
    ];

    protected $casts = [
        'join_date' => 'date',
        'date_of_birth' => 'date',
    ];

    // AUTO GENERATE MEMBER NO
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($member) {
            if (empty($member->member_no)) {
                $year = date('Y');
                $prefix = 'A' . $year;

                $lastMember = self::where('member_no', 'like', $prefix . '%')
                    ->orderBy('member_id', 'desc')
                    ->first();

                if ($lastMember) {
                    $lastNumber = (int) substr($lastMember->member_no, -4);
                    $nextNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
                } else {
                    $nextNumber = '0001';
                }

                $member->member_no = $prefix . $nextNumber;
            }
        });
    }

    // 🔹 Family Members relationship
    public function familyMembers()
    {
        return $this->hasMany(FamilyMember::class, 'member_id', 'member_id')
                    ->orderBy('family_id', 'desc');
    }

    // 🔹 Relationship to MemberMembership table
    public function membership()
    {
        return $this->hasOne(MemberMembership::class, 'member_id', 'member_id');
    }

    public function memberships()
{
    return $this->hasMany(\App\Models\MemberMembership::class, 'member_id', 'member_id');
}


    // 🔹 Relationship to MembershipType through MemberMembership
    public function membershipType()
    {
        return $this->hasOneThrough(
            MembershipType::class,   // Final model
            MemberMembership::class, // Intermediate model
            'member_id',  // Foreign key on member_membership
            'type_id',    // Foreign key on membership_types
            'member_id',  // Local key on members
            'type_id'     // Local key on member_membership
        );
    }

    public function memberMemberships()
{
    return $this->hasMany(MemberMembership::class, 'member_id', 'member_id');
}

}
