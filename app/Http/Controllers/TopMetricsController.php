<?php

namespace App\Http\Controllers;

use App\Repositories\TopMetricsRepository;

class TopMetricsController extends Controller
{
    public function __construct(private TopMetricsRepository $metricsRepository)
    {
    }

    public function index()
    {
        return response()->json($this->metricsRepository->getData()->toArray());
    }
}