<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $primaryKey = 'event_id'; // 👈 Add this line
    protected $keyType = 'int';   // and not string if you use numeric IDs
    public $incrementing = true;  // should be true unless you use UUIDs

    protected $fillable = [
        'event_name', 
        'event_date', 
        'location', 
        'description', 
        'organized_by'
    ];

    // Relationship to CommitteeMember
    public function organizer()
    {
        return $this->belongsTo(CommitteeMember::class, 'organized_by','id');
    }


    public function participants()
{
    return $this->hasMany(EventParticipant::class, 'event_id', 'event_id')
                ->with('member');
}

}
