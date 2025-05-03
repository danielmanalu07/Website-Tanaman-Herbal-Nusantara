<?php
namespace App\Exports;

use App\Service\PlantService;
use DateTime;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class PlantExport implements FromView
{
    private $plantService;
    private $fromDate;
    private $toDate;

    public function __construct(PlantService $plantService, $fromDate = null, $toDate = null)
    {
        $this->plantService = $plantService;
        $this->fromDate     = $fromDate;
        $this->toDate       = $toDate;
    }

    public function view(): View
    {
        $plants = $this->plantService->get_all_plant();

        // Apply date filters if provided
        if ($this->fromDate || $this->toDate) {
            $plants = $plants->filter(function ($plant) {
                $createdAt = new DateTime($plant->created_at);
                $updatedAt = new DateTime($plant->updated_at);

                $fromDate = $this->fromDate ? new \DateTime($this->fromDate) : null;
                $toDate   = $this->toDate ? (new \DateTime($this->toDate))->modify('+1 day') : null;

                if ($fromDate && ! $toDate) {
                    return $createdAt >= $fromDate || $updatedAt >= $fromDate;
                }

                if (! $fromDate && $toDate) {
                    return $createdAt <= $toDate || $updatedAt <= $toDate;
                }

                return ($createdAt >= $fromDate && $createdAt <= $toDate) ||
                    ($updatedAt >= $fromDate && $updatedAt <= $toDate);
            });
        }

        $data = [
            'plants' => $plants,
        ];

        return view('admin.export.plant_export', $data);
    }
}
