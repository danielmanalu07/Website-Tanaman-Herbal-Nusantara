<?php
namespace App\Exports;

use App\Service\PlantValidationService;
use DateTime;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class PlantValidationExport implements FromView
{
    private $plant_val_Service;
    private $fromDate;
    private $toDate;

    public function __construct(PlantValidationService $plantValidationService, $fromDate = null, $toDate = null)
    {
        $this->plant_val_Service = $plantValidationService;
        $this->fromDate          = $fromDate;
        $this->toDate            = $toDate;
    }

    public function view(): View
    {
        $plant_validations = $this->plant_val_Service->get_all_validation();

        // Apply date filters if provided
        if ($this->fromDate || $this->toDate) {
            $plant_validations = $plant_validations->filter(function ($plant) {
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
            'plant_validations' => $plant_validations,
        ];

        return view('admin.export.plant_validation_export', $data);
    }
}
