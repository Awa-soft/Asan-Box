<?php

namespace App\Exports;

use App\Models\HR\EmployeeActivity;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExcelExport implements FromCollection, WithHeadings
{
    private $data, $heading;

    public function __construct($data, $heading)
    {
        $this->data = $data;
        $this->heading = $heading;

    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $this->data->get();
    }

    public function headings(): array
    {
        return $this->heading;
    }


}
