<?php

namespace App\Exports;

use App\Models\MemberMembership;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Carbon\Carbon;

class MemberMembershipExport implements FromCollection, WithHeadings
{
    protected $memberId;

    public function __construct($memberId = null)
    {
        $this->memberId = $memberId;
    }

    public function collection()
    {
        $query = MemberMembership::with(['member', 'membershipType']);

        if ($this->memberId) {
            $query->where('member_id', $this->memberId);
        }

        return $query->get()->map(function ($item) {
            return [
                // From related 'members' table
                'Member No'   => $item->member->member_no ?? '',
                'Member Name' => $item->member->full_name ?? '',

                // From 'member_membership' table
                'ID'         => $item->id,
                'Member ID'  => $item->member_id,
                'Type ID'    => $item->type_id,
                'Membership Type' => $item->membershipType->type_name ?? '',
                'Start Date' => $this->formatDate($item->start_date),
                'End Date'   => $this->formatDate($item->end_date),
                'Is Active'  => $item->is_active ? 'Yes' : 'No',
                'Created At' => $this->formatDate($item->created_at),
                'Updated At' => $this->formatDate($item->updated_at),
                'Renew No'   => $item->renew_no,
                'Hide'       => $item->hide,
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
            'ID',
            'Member ID',
            'Type ID',
            'Membership Type',
            'Start Date',
            'End Date',
            'Is Active',
            'Created At',
            'Updated At',
            'Renew No',
            'Hide',
        ];
    }
}
