<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseFormatter;
use App\Models\Administrator;
use App\Models\Vacancy;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use function PHPUnit\Framework\returnSelf;

class VacancyController extends Controller
{
    public function index()
    {
        // $vacancies = Vacancy::all()->orderBy('created_at', 'DESC');
        $currentDate = now()->format('Y-m-d');
        $vacancies = DB::table('vacancies')->where('deadline', '>=', $currentDate)->orderByDesc('created_at')->get();
        if(count($vacancies) > 0) {
            return ResponseFormatter::success($vacancies, 'Success');
        }

        return ResponseFormatter::success(null, 'Data empty');
    }

    public function indexAdmin()
    {
        // $vacancies = Vacancy::all()->orderBy('created_at', 'DESC');
        $vacancies = DB::table('vacancies')->orderByDesc('created_at')->get();
        if(count($vacancies) > 0) {
            return ResponseFormatter::success($vacancies, 'Success');
        }

        return ResponseFormatter::success(null, 'Data empty');
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

    public function update(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'company_name' => 'required|string',
                'job_position' => 'required|string',
                'job_description' => 'required|string',
                'job_requirements' => 'required|string',
                'deadline' => 'required',
            ]);
    
            if ($validator->fails()) {
                return ResponseFormatter::error(null, $validator->errors()->first(), 400);
            }
            
            $vacancy = Vacancy::findOrFail($id);
            if (!$vacancy) return ResponseFormatter::error(null, 'Data not found', 400);

            $vacancy->company_name = $request->post('company_name', $vacancy->company_name);
            $vacancy->job_position = $request->post('job_position', $vacancy->job_position);
            $vacancy->job_description = $request->post('job_description', $vacancy->job_description);
            $vacancy->job_requirements = $request->post('job_requirements', $vacancy->job_requirements);
            $vacancy->deadline = $request->post('deadline', $vacancy->deadline);
            $vacancy->save();
            return ResponseFormatter::success(null, 'Success');
        } catch (\Throwable $th) {
            return ResponseFormatter::error(null, $th, 400);
        }
    }

    public function destroy($id)
    {
        try {
            $vacancy = Vacancy::findOrFail($id);
            if (!$vacancy) return ResponseFormatter::error(null, 'Data not found', 400);
    
            $vacancy->delete();
            return ResponseFormatter::success(null, 'Success');
        } catch (\Throwable $th) {
            return ResponseFormatter::error(null, $th, 400);
        }
    }
}
