<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MembershipType extends Model
{
    use HasFactory;

    protected $primaryKey = 'type_id'; // your primary key is type_id

    protected $fillable = [
        'type_name',
        'description',
        'annual_fee',
    ];

    public $timestamps = false; // optional, since your table doesn't have created_at/updated_at
}
