<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ReportRequest;
use App\Models\Order;
use App\Models\Report;
use App\Models\Reservation;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        return Report::all();
    }

    public function show(Report $report)
    {
        return $report;
    }

    public function getData(Report $report)
    {
        if ($report->type == 'Product') {
            return Order::whereDate('created_at', '>=', $report->from)
                ->whereDate('created_at', '<=', $report->to)
                ->get();
        } else if ($report->type == 'Service') {
            return Reservation::whereDate('created_at', '>=', $report->from)
                ->whereDate('created_at', '<=', $report->to)
                ->get();
        }
    }

    public function store(ReportRequest $request)
    {
        return Report::create($request->validated());
    }

    public function update(Report $report, ReportRequest $request)
    {
        return $report->update($request->validated());
    }
}
