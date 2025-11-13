<?php

namespace App\Exports;

use App\Models\Member;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Carbon\Carbon;

class MembersByTypeSheet implements FromCollection, WithHeadings, WithTitle
{
    protected $type;

    public function __construct($type)
    {
        $this->type = $type;
    }

    public function collection()
    {
        return Member::select(
                'members.member_id',
                'members.member_no',
                'members.photo',
                'members.full_name',
                'members.ic_no',
                'members.gender',
                'members.date_of_birth',
                'members.phone',
                'members.email',
                'members.address',
                'members.occupation',
                'members.join_date',
                'members.status',
                'members.created_at',
                'members.updated_at'
            )
            ->join('member_membership as mm', 'members.member_id', '=', 'mm.member_id')
            ->where('mm.type_id', $this->type->type_id)
            ->where('mm.is_active', 1)
            ->orderBy('members.full_name')
            ->get()
            ->map(function ($m) {
                return [
                    'Member ID'    => $m->member_id,
                    'Member No'    => $m->member_no,
                    'Photo'        => $m->photo,
                    'Full Name'    => $m->full_name,
                    'IC No'        => $m->ic_no,
                    'Gender'       => $m->gender,
                    'Date of Birth'=> $this->formatDate($m->date_of_birth),
                    'Phone'        => $m->phone,
                    'Email'        => $m->email,
                    'Address'      => $m->address,
                    'Occupation'   => $m->occupation,
                    'Join Date'    => $this->formatDate($m->join_date),
                    'Status'       => $m->status,
                    'Created At'   => $this->formatDate($m->created_at),
                    'Updated At'   => $this->formatDate($m->updated_at),
                ];
            });
    }

    public function headings(): array
    {
        return [
            'Member ID',
            'Member No',
            'Photo',
            'Full Name',
            'IC No',
            'Gender',
            'Date of Birth',
            'Phone',
            'Email',
            'Address',
            'Occupation',
            'Join Date',
            'Status',
            'Created At',
            'Updated At',
        ];
    }

    public function title(): string
    {
        return $this->type->type_name; // e.g. "Annual", "Lifetime", "Associate"
    }

    private function formatDate($date)
    {
        if (!$date) {
            return '';
        }

        return Carbon::parse($date)->format('d/m/Y');
    }
}
