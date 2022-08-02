<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseFormatter;
use App\Models\Vacancy;
use Illuminate\Http\Request;

use function PHPUnit\Framework\returnSelf;

class VacancyController extends Controller
{
    public function index()
    {
        $vacancies = Vacancy::all();
        if(count($vacancies) > 0) {
            return ResponseFormatter::success($vacancies, 'Success');
        }

        return ResponseFormatter::error(null, 'Data not found', 400);
    }

    public function show($id)
    {
        $vacancy = Vacancy::find($id);

        if (!$vacancy) return ResponseFormatter::error(null, 'Data not found', 400);

        return ResponseFormatter::success($vacancy, 'Success');
    }
}
