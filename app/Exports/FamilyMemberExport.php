<?php

namespace App\Exports;

use App\Models\FamilyMember;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Carbon\Carbon;

class FamilyMemberExport implements FromCollection, WithHeadings
{
    protected $id;

    public function __construct($id = null)
    {
        $this->id = $id;
    }

    public function collection()
    {
        $query = FamilyMember::with(['member', 'relationshipType']);

        if ($this->id) {
            $query->where('family_id', $this->id);
        }

        return $query->get()->map(function ($item) {
            return [
                // From related 'members' table
                'Member No'   => $item->member->member_no ?? '',
                'Member Name' => $item->member->full_name ?? '',

                // From 'family_members' table
                'Family ID'  => $item->family_id,
                'Member ID'  => $item->member_id,
                'Name'       => $item->name,
                'Relationship Type' => $item->relationshipType->name ?? '',
                'Date of Birth' => $this->formatDate($item->date_of_birth),
                'Contact No'    => $item->contact_no,
                'Created At'    => $this->formatDate($item->created_at),
                'Updated At'    => $this->formatDate($item->updated_at),
                'IC No'         => $item->ic_no,
                'Email'         => $item->email,
                'Address'       => $item->address,
                'Occupation'    => $item->occupation,
                'Child No of Sibling' => $item->child_no_of_sibling,
                'Child Diagnose' => $item->child_diagnose,
                'Child Right Ear Hearing Level' => $item->child_right_ear_hearing_level,
                'Child Left Ear Hearing Level'  => $item->child_left_ear_hearing_level,
                'Child Right Ear Hearing Tool'  => $item->child_right_ear_hearing_tool,
                'Child Left Ear Hearing Tool'   => $item->child_left_ear_hearing_tool,
                'Child Right Ear Hearing Tool Brand' => $item->child_right_ear_hearing_tool_brand,
                'Child Left Ear Hearing Tool Brand'  => $item->child_left_ear_hearing_tool_brand,
                'Child Right Ear Hearing Tool From'  => $item->child_right_ear_hearing_tool_from,
                'Child Left Ear Hearing Tool From'   => $item->child_left_ear_hearing_tool_from,
                'Child Reference Hospital' => $item->child_reference_hospital,
                'Child Education Level'    => $item->child_education_level,
                'Child School Name'        => $item->child_school_name,
                'Child OKU Status'         => $item->child_oku_status,
            ];
        });
    }

    private function formatDate($date)
    {
        if (!$date) {
            return '';
        }

        return Carbon::parse($date)->format('d/m/Y');
    }

    public function headings(): array
    {
        return [
            'Member No',
            'Member Name',
            'Family ID',
            'Member ID',
            'Name',
            'Relationship Type',
            'Date of Birth',
            'Contact No',
            'Created At',
            'Updated At',
            'IC No',
            'Email',
            'Address',
            'Occupation',
            'Child No of Sibling',
            'Child Diagnose',
            'Child Right Ear Hearing Level',
            'Child Left Ear Hearing Level',
            'Child Right Ear Hearing Tool',
            'Child Left Ear Hearing Tool',
            'Child Right Ear Hearing Tool Brand',
            'Child Left Ear Hearing Tool Brand',
            'Child Right Ear Hearing Tool From',
            'Child Left Ear Hearing Tool From',
            'Child Reference Hospital',
            'Child Education Level',
            'Child School Name',
            'Child OKU Status',
        ];
    }
}
