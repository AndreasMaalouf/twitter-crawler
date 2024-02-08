<?php

namespace App\Http\Controllers;

use App\Repositories\MetricsRepository;

class MetricsController extends Controller
{
    public function __construct(private MetricsRepository $metricsRepository)
    {
    }

    public function get(int $days)
    {
        abort_if($days > 5*365, 400, 'Invalid Date Range');

        return response()->json($this->metricsRepository->setDaysSince($days)->getData()->toArray());
    }
}