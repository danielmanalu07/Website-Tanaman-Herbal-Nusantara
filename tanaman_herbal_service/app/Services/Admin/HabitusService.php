<?php
namespace App\Services\Admin;

use App\Http\Repositories\HabitusRepository;
use App\Response\Response;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class HabitusService
{
    protected $habitusRepo;
    public function __construct(HabitusRepository $habitusRepository)
    {
        $this->habitusRepo = $habitusRepository;
    }

    public function create_habitus(array $data)
    {
        try {
            $admin = Auth::user();

            // Simpan data ke database tanpa QR Code terlebih dahulu
            $habitus = $this->habitusRepo->createHabitus([
                'name'       => $data['name'],
                'created_by' => $admin->id,
                'updated_by' => $admin->id,
            ]);

            // Gunakan ID yang baru saja dibuat untuk QR Code
            $qrData = route('habitus.detail', ['id' => $habitus->id]);
            $qrCode = QrCode::format('png')->size(200)->generate($qrData);

            $qrPath = "qrcodes/habitus_{$habitus->name}.png";
            Storage::disk('public')->put($qrPath, $qrCode);

            // Update habitus dengan QR Code
            $habitus->update(['qrcode' => $qrPath]);

            return $habitus;
        } catch (\Throwable $th) {
            return Response::error('Failed to create data habitus', $th->getMessage(), 500);
        }
    }

    public function get_all_habitus()
    {
        try {
            $habitus = $this->habitusRepo->get_all_habitus();
            if ($habitus->isEmpty()) {
                return Response::error('Data not found', null, 404);
            }

            return $habitus;
        } catch (\Throwable $th) {
            return Response::error('Failed to get data habitus', $th->getMessage(), 500);
        }
    }

    public function get_detail_habitus(int $id)
    {
        try {
            $habitus = $this->habitusRepo->get_detail_habitus($id);
            if (! $habitus) {
                return Response::error('data not found', null, '404');
            }

            return $habitus;
        } catch (ModelNotFoundException $e) {
            return Response::error('Data not found', $e->getMessage(), 404);
        } catch (\Throwable $th) {
            return Response::error('Failed to get data habitus', $th->getMessage(), 500);
        }
    }

    public function update_habitus(array $data, int $id)
    {
        try {
            $admin   = Auth::user();
            $habitus = $this->habitusRepo->get_detail_habitus($id);

            if (! $habitus) {
                return Response::error('Data not found', null, 404);
            }

            if ($habitus->qrcode && Storage::disk('public')->exists($habitus->qrcode)) {
                Storage::disk('public')->delete($habitus->qrcode);
            }

            $qrData = route('habitus.detail', ['id' => $id]);
            $qrCode = QrCode::format('png')->size(200)->generate($qrData);

            $qrPath = "qrcodes/habitus_{$data['name']}.png";
            Storage::disk('public')->put($qrPath, $qrCode);

            $updatedData = [
                'name'       => $data['name'],
                'qrcode'     => $qrPath,
                'updated_by' => $admin->id,
            ];

            $updatedHabitus = $this->habitusRepo->update_habitus($id, $updatedData);

            return $updatedHabitus;
        } catch (ModelNotFoundException $e) {
            return Response::error('Data not found', $e->getMessage(), 404);
        } catch (\Throwable $th) {
            return Response::error('Failed to update habitus data', $th->getMessage(), 500);
        }
    }

    public function delete_habitus(int $id)
    {
        try {
            return $this->habitusRepo->delete_habitus($id);
        } catch (ModelNotFoundException $e) {
            return Response::error('Data not found', $e->getMessage(), 404);
        } catch (\Throwable $th) {
            return Response::error('Failed to delete habitus data', $th->getMessage(), 500);
        }
    }

    public function getQrCode($fileName)
    {
        $path = "qrcodes/{$fileName}";

        // Cek apakah file ada
        if (! Storage::disk('public')->exists($path)) {
            return Response::error('QR Code not found', null, 404);
        }

        $url = asset("storage/{$path}");

        return Response::success('QR Code retrieved successfully', ['url' => $url], 200);
    }

}
