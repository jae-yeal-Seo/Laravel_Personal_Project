<?php

namespace App\Http\Controllers;

use App\Models\Chart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class ChartController extends Controller
{
    public function create(Request $request)
    {

        $today = date("Y-m-d");
        $month = date("Y-m");
        $year = date("Y");
        $chart = Chart::create([
            "negative" => $request->negative,
            "positive" => $request->positive,
            "neutral" => $request->neutral,
            "worry_id" => $request->worryid,
            "user_id" => Auth::user()->id,
            "title" => $request->title,
            "untilday" => $today,
            "untilmonth" => $month,
            "untilyear" => $year,
        ]);

        return $request;
    }

    public function index(Request $reqeust)
    {
        $charts = Chart::where('user_id', Auth::user()->id)->get();


        return Inertia::render('ChartShow', ['charts' => $charts]);
    }
    public function dayfeeling(Request $request)
    {
        $today = $request->today;

        $positive = DB::table('Charts')
            ->where('created_at', 'like', $today . '%')
            ->avg('positive');

        $neutral = DB::table('Charts')
            ->where('created_at', 'like', $today . '%')
            ->avg('neutral');

        $negative = DB::table('Charts')
            ->where('created_at', 'like', $today . '%')
            ->avg('negative');

        $dayfeeling = array();
        array_push($dayfeeling, [$positive, $neutral, $negative]);

        return $dayfeeling;
    }

    public function monthfeeling(Request $request)
    {
        $month = $request->month;

        $positive = DB::table('Charts')
            ->where('created_at', 'like', $month . '%')
            ->avg('positive');

        $neutral = DB::table('Charts')
            ->where('created_at', 'like', $month . '%')
            ->avg('neutral');

        $negative = DB::table('Charts')
            ->where('created_at', 'like', $month . '%')
            ->avg('negative');

        $monthfeeling = array();
        array_push($monthfeeling, [$positive, $neutral, $negative]);

        return $monthfeeling;
    }

    public function realindex()
    {
        $charts = Chart::where('user_id', Auth::user()->id)->get();


        return Inertia::render('RealChartShow', ['charts' => $charts]);
    }

    public function realdayindex()
    {
        $days = DB::table('charts')
            ->selectRaw('untilday, avg(positive) as positive, avg(neutral) as neutral,avg(negative) as negative')
            ->groupBy('untilday')
            ->get();

        return $days;
    }

    public function realmonthindex()
    {
        $months = DB::table('charts')
            ->selectRaw('untilmonth, avg(positive) as positive, avg(neutral) as neutral,avg(negative) as negative')
            ->groupBy('untilmonth')
            ->get();

        return $months;
    }

    public function realyearindex()
    {
        $years = DB::table('charts')
            ->selectRaw('untilyear, avg(positive) as positive, avg(neutral) as neutral,avg(negative) as negative')
            ->groupBy('untilyear')
            ->get();

        return $years;
    }
}
