<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Intervention;
use App\Models\Company;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReportsController extends Controller
{
    private function daysToBeMarked($startDate, $endDate, $id)
    {
        $days = array_fill(0, 32, array());
        $interventions = DB::select("SELECT DISTINCT day FROM interventions WHERE company_id = ? AND day >= ? AND day < ? ORDER BY day", [$id, $startDate, $endDate]);
        $products = DB::select("SELECT DISTINCT day FROM products WHERE company_id = ? AND day >= ? AND day < ? ORDER BY day", [$id, $startDate, $endDate]);

        foreach ($interventions as $intervention) {
            $days[intval(substr($intervention->day, -2))][] = 'intervention-mark';
        }

        foreach($products as $product) {
            $days[intval(substr($product->day, -2))][] = 'product-mark';
        }

        return $days;
    }

    public function monthlyReport($id, $reportDate)
    {
        $startDate = new Carbon($reportDate);
        $startDate->day = 1;
        $endDate = new Carbon($startDate);
        $endDate->addMonth();

        $client = Company::find($id);
        $totalTime = DB::select("SELECT SUM(end_at - start_at) AS time FROM interventions WHERE company_id = ? AND day >= ? AND day < ?", [$id, $startDate, $endDate]);
        $interventions = DB::select("SELECT end_at - start_at AS time, day FROM interventions WHERE company_id = ? AND day >= ? AND day < ? ORDER BY day", [$id, $startDate, $endDate]);
        $products = DB::select("SELECT * FROM products WHERE company_id = ? AND day >= ? AND day < ? ORDER BY day ASC", [$id, $startDate, $endDate]);

        return view('monthly-reports')
                ->with('client', $client->name)
                ->with('id', $id)
                ->with('totalTime', $totalTime[0]->time)
                ->with('interventions', $interventions)
                ->with('products', $products)
                ->with('markedDays', self::daysToBeMarked($startDate, $endDate, $id));
    }

    public function interventionReport($id, $reportDate)
    {
        $startDate = new Carbon($reportDate);
        $startDate->day = 1;
        $endDate = new Carbon($startDate);
        $endDate->addMonth();

        $client = Company::find($id);
        $interventions = DB::select("SELECT * FROM interventions WHERE day = ? AND company_id = ? ORDER BY start_at", [$reportDate, $id]);
        $products = DB::select("SELECT * FROM products WHERE day = ? AND company_id = ? ORDER BY name", [$reportDate, $id]);

        return view('intervention-report')
                ->with('client', $client->name)
                ->with('reportDate', $reportDate)
                ->with('interventions', $interventions)
                ->with('products', $products)
                ->with('companyId', $id)
                ->with('markedDays', self::daysToBeMarked($startDate, $endDate, $id));
    }
}
