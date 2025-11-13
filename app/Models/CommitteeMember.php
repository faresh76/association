<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommitteeMember extends Model
{
    protected $fillable = [
        'member_id',
        'role_id',
        'term_start',
        'term_end',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id', 'member_id');
    }

    public function role()
    {
        return $this->belongsTo(CommitteeRole::class, 'role_id', 'role_id');
    }

        public function eventsOrganized()
    {
        return $this->hasMany(Event::class, 'organized_by');
    }

}
