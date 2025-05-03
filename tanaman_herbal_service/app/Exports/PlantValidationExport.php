<?php
namespace App\Exports;

use App\Models\PlantValidation;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PlantValidationExport implements FromCollection, WithHeadings, WithMapping
{
    private $validations;

    public function collection()
    {
        $this->validations = PlantValidation::with(['plants', 'users'])->get(); // Menghilangkan hubungan dengan images
        return $this->validations;
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama Tanaman',
            'Nama Latin',
            'Nama Habitus',
            'User Validasi',
            'Tanggal',
            'Kondisi',
            'Deskripsi',
        ];
    }

    public function map($row): array
    {
        static $no = 1;
        return [
            $no++,
            $row->plants->name ?? '-',
            $row->plants->latin_name ?? '-',
            $row->plants->habituses->name ?? '-',
            $row->users->full_name ?? '-',
            $row->date_validation ? \Carbon\Carbon::parse($row->date_validation)->format('d-m-Y') : '-',
            ucfirst($row->condition),
            $row->description,
        ];
    }
}
