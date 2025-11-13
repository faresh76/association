<?php

namespace App\Exports;

use App\Models\MembershipType;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class MembersExport implements WithMultipleSheets
{
    public function sheets(): array
    {
        $sheets = [];

        // Get all membership types (Annual, Lifetime, Associate, etc.)
        $membershipTypes = MembershipType::all();

        foreach ($membershipTypes as $type) {
            $sheets[] = new MembersByTypeSheet($type);
        }

        return $sheets;
    }
}
