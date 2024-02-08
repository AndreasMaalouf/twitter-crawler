<?php

namespace App\Http\Controllers;

use App\Repositories\TopMetricsRepository;

class TopMetricsController extends Controller
{
    public function __construct(private TopMetricsRepository $metricsRepository)
    {
    }

    /**
     * Returns top 15 instruments of all time
     *
     * @response [{"instrument":"$BTC","total":7},{"instrument":"$AAPL","total":4}]
     */
    public function index()
    {
        return response()->json($this->metricsRepository->getData()->toArray());
    }
}