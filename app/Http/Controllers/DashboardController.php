<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseFormatter;
use App\Models\Customer;
use App\Models\Trainer;
use App\Models\Training;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    public function trainerStatistic()
    {
        $currentDate = now()->format('Y-m-d');
        $trainer = Trainer::where('user_id', Auth::id())->first();

        $trainings = Training::where('trainer_id', $trainer->id)->get()->count();
        $trainingsActive = Training::where('training_end', '>', $currentDate)->where('trainer_id', $trainer->id)->get()->count();
        $trainingsEnd = Training::where('training_end', '<', $currentDate)->where('trainer_id', $trainer->id)->get()->count();

        $responseData = [
            'total_trainings' => $trainings,
            'total_training_active' => $trainingsActive,
            'total_training_end' => $trainingsEnd,
        ];

        return ResponseFormatter::success($responseData, 'success');
    }
}
