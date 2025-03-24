<?php
namespace App\Services\Admin;

use App\Http\Repositories\PlantRepository;
use App\Models\Habitus;
use App\Response\Response;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class PlantService
{
    protected $plantRepo;

    public function __construct(PlantRepository $plant_repository)
    {
        $this->plantRepo = $plant_repository;
    }
    public function create_plant(array $data)
    {
        try {
            $admin = Auth::user();

            $habitus = Habitus::withTrashed()->find($data['habitus_id']);
            if (! $habitus) {
                return Response::error('Habitus not found', null, 404);
            }

            // $existing_habitus = Plants::where('habitus_id', $data['habitus_id'])->first();
            // if ($existing_habitus) {
            //     return Response::error('Plant with this habitus already exists', null, 409);
            // }

            $plantData = array_merge($data, [
                'created_by' => $admin->id,
                'updated_by' => $admin->id,
            ]);

            $plant = $this->plantRepo->create_plant($plantData);

            // Gunakan ID yang baru saja dibuat untuk QR Code
            $qrData = route('plant.detail', ['id' => $plant->id]);
            $qrCode = QrCode::format('png')->size(200)->generate($qrData);

            $qrPath = "qrcodes/plants_{$plant->name}.png";
            Storage::disk('public')->put($qrPath, $qrCode);

            // Update plant dengan QR Code
            $plant->update(['qrcode' => $qrPath]);

            return $plant;

        } catch (\Throwable $th) {
            return Response::error('Failed to create data plant', $th->getMessage(), 500);
        }
    }

    public function get_all_plant()
    {
        try {
            $plants = $this->plantRepo->get_all_plant();
            if ($plants->isEmpty()) {
                return Response::error('Data not found', null, 404);
            }
            return $plants;
        } catch (\Throwable $th) {
            return Response::error('Failed to get data plant', $th->getMessage(), 500);
        }
    }

    public function get_detail_plant(int $id)
    {
        try {
            $plant = $this->plantRepo->get_detail_plant($id);

            if (is_null($plant)) {
                return Response::error('Data not found', null, 404);
            }

            return $plant;
        } catch (ModelNotFoundException $e) {
            return Response::error('Data not found', $e->getMessage(), 404);
        } catch (\Throwable $th) {
            return Response::error('Failed to get data plant', $th->getMessage(), 500);
        }
    }

    public function update_plant(array $data, int $id)
    {
        try {
            $admin = Auth::user();
            $plant = $this->plantRepo->get_detail_plant($id);
            if (! $plant) {
                return Response::error('Data not found', null, 404);
            }

            $habitus = Habitus::withTrashed()->find($data['habitus_id']);
            if (! $habitus) {
                return Response::error('Habitus not found', null, 404);
            }

            // $existing_habitus = Plants::where('habitus_id', $data['habitus_id'])
            //     ->where('id', '!=', $id)
            //     ->first();

            // if ($existing_habitus) {
            //     return Response::error('Plant with this habitus already exists', null, 409);
            // }

            if ($plant->qrcode && Storage::disk('public')->exists($plant->qrcode)) {
                Storage::disk('public')->delete($plant->qrcode);
            }

            $qrData = route('plant.detail', ['id' => $id]);
            $qrCode = QrCode::format('png')->size(200)->generate($qrData);

            $qrPath = "qrcodes/plants_{$data['name']}.png";
            Storage::disk('public')->put($qrPath, $qrCode);

            $updateData = array_merge($data, [
                'qrcode'     => $qrPath,
                'updated_by' => $admin->id,
            ]);

            return $this->plantRepo->update_plant($updateData, $id);
        } catch (ModelNotFoundException $e) {
            return Response::error('Data not found', $e->getMessage(), 404);
        } catch (\Throwable $th) {
            return Response::error('Failed to update data plant', $th->getMessage(), 500);
        }
    }

    public function delete_plant(int $id)
    {
        try {
            return $this->plantRepo->delete_plant($id);
        } catch (ModelNotFoundException $e) {
            return Response::error('Data not found', $e->getMessage(), 404);
        } catch (\Throwable $th) {
            return Response::error('Failed to delete data plant', $th->getMessage(), 500);
        }
    }

    public function getQrCode($fileName)
    {
        $path = "qrcodes/{$fileName}";

        if (! Storage::disk('public')->exists($path)) {
            return Response::error('QR Code not found', null, 404);
        }

        $url = asset("storage/{$path}");

        return Response::success('QR Code retrieved successfully', ['url' => $url], 200);
    }

}
