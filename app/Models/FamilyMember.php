<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FamilyMember extends Model
{
    protected $primaryKey = 'family_id';

    protected $fillable = [
        'member_id',
        'name',
        'relationship_type_id',
        'date_of_birth',
        'contact_no',
        'ic_no',
        'email',
        'address',
        'occupation',
        'child_no_of_sibling',
        'child_diagnose',
        'child_right_ear_hearing_level',
        'child_left_ear_hearing_level',
        'child_right_ear_hearing_tool',
        'child_left_ear_hearing_tool',
        'child_right_ear_hearing_tool_brand',
        'child_left_ear_hearing_tool_brand',
        'child_right_ear_hearing_tool_from',
        'child_left_ear_hearing_tool_from',
        'child_reference_hospital',
        'child_education_level',
        'child_school_name',
        'child_oku_status',
    ];

    // Each family member belongs to a Member
    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id', 'member_id');
    }

    // Each family member belongs to a relationship type
    public function relationshipType()
    {
        return $this->belongsTo(RelationshipType::class, 'relationship_type_id');
    }

    // Optional accessor to use in view
    public function getRelationshipAttribute()
    {
        return $this->relationshipType?->name ?? '-';
    }

    protected $casts = [
    'date_of_birth' => 'date',
];



}
