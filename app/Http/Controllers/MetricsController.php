<?php

namespace App\Http\Controllers;

use App\Http\Requests\MetricRequest;
use App\Repositories\MetricsRepository;
use Symfony\Component\HttpFoundation\Response;

class MetricsController extends Controller
{
    public function __construct(private MetricsRepository $metricsRepository)
    {
    }

    /**
     * Returns top 15 instruments in the given timeframe
     *
     * @response 200 [{"instrument":"$BTC","total":7},{"instrument":"$AAPL","total":4}]
     * @response 404 Invalid Date Range
     */
    public function get(MetricRequest $request)
    {
        $days = $request->route('days');

        return response()->json($this->metricsRepository->setDaysSince($days)->getData()->toArray());
    }
}