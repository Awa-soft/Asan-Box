<?php

namespace App\Exports;

use App\Models\HR\EmployeeActivity;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExcelExport implements FromCollection, WithHeadings
{
    private $data, $heading, $hidden;

    public function __construct($data, $heading, $hidden= null)
    {
        $this->data = $data;
        $this->heading = $heading;
        $this->hidden = $hidden;

    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $this->data->get()
        ->map(function ($row) {
            return collect($this->heading)
                ->map(function ($key) use ($row) {
                    return $row[$key];
                })
                ->toArray();
        })
        ;
    }

    public function headings(): array
    {
        return $this->heading;
    }


}
