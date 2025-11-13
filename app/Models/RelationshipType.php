<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RelationshipType extends Model
{
        protected $fillable = [
        'name',
        'description',
    ];

    public function familyMembers()
    {
        return $this->hasMany(FamilyMember::class, 'relationship_type_id');
    }
}
