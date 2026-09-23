<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Maitri\ServiceRequestResource;
use App\Models\API\Servicerequest;
use App\Models\Maitri;
use App\Traits\FormatResponseTrait;
use Illuminate\Http\Request;
class MonthlyProgressReportController extends Controller
{
    use FormatResponseTrait;

    public function monthlyProgressReport(Request $request)
    {
        try {
            $maitri = auth()->user();
            if (!$maitri instanceof Maitri) {
                return $this->errorResponse('Maitri not authenticated', 401);
            }

            $query = Servicerequest::with(['user', 'maitri'])
                ->where('maitri_id', $maitri->id)
                ->orderBy('id', 'desc');

            if ($request->filled('month')) {
                $query->whereMonth('created_at', $request->month);
            }

            if ($request->filled('year')) {
                $query->whereYear('created_at', $request->year);
            }

            $perPage = (int) $request->input('per_page', 10);
            $data    = $query->paginate($perPage);

            return $this->successResponse(
                'Monthly progress report fetched successfully',
                200,
                ServiceRequestResource::collection($data),$data
            );
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }
}
