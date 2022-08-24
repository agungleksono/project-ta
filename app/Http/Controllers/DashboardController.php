<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseFormatter;
use App\Models\Customer;
use App\Models\Trainer;
use App\Models\Training;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function statistic()
    {
        $currentDate = now()->format('Y-m-d');

        $customers = Customer::all()->count();
        $trainers = Trainer::all()->count();
        $trainings = Training::all()->count();
        $trainingsActive = Training::where('training_end', '>', $currentDate)->get()->count();
        $trainingsEnd = Training::where('training_end', '<', $currentDate)->get()->count();

        $responseData = [
            'total_customers' => $customers,
            'total_trainers' => $trainers,
            'total_trainings' => $trainings,
            'total_training_active' => $trainingsActive,
            'total_training_end' => $trainingsEnd,
        ];

        return ResponseFormatter::success($responseData, 'success');
    }
}
