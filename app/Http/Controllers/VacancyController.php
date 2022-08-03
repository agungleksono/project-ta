<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseFormatter;
use App\Models\Administrator;
use App\Models\Vacancy;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    public function store(Request $request)
    {
        if (Auth::user()->status != 1) return ResponseFormatter::error(null, 'Permission denied', 400);

        $admin = Administrator::where('user_id', Auth::id())->get();

        $validator = Validator::make($request->all(), [
            'company_name' => 'required|string',
            'job_position' => 'required|string',
            'job_description' => 'required|string',
            'job_requirements' => 'required|string',
            'deadline' => 'required|date'
        ]);

        if ($validator->fails()) {
            return ResponseFormatter::error(null, $validator->errors()->first(), 400);
        }

        Vacancy::create([
            'company_name' => $request->post('company_name'),
            'job_position' => $request->post('job_position'),
            'job_description' => $request->post('job_description'),
            'job_requirements' => $request->post('job_requirements'),
            'deadline' => $request->post('deadline'),
            'admin_id' => $admin[0]->id,

        ]);

        return ResponseFormatter::success(null, 'Saved successfully');
    }
}
