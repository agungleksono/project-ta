<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Helpers\ResponseFormatter;
use App\Models\Customer;
use App\Models\CustomerDocument;
use App\Models\TrainingRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class TrainingRecordController extends Controller
{
    public function index()
    {
        //
    }

    public function getCustomerTrainingRecords()
    {
        $customer = Customer::where('user_id', Auth::id())->first();
        // $trainings = TrainingRecord::where('customer_id', $customer->id)->get();
        $trainings = TrainingRecord::with(['training'])->where('customer_id', '=', $customer->id)->get();
        if ($trainings->isEmpty()) {
            return ResponseFormatter::error(null, 'You have not register any training', 400);
        }
        
        $data = [];
        foreach ($trainings as $training) {
            $responseData = [
                'id' => $training->training->id,
                'training_name' => $training->training->training_name,
            ];

            if ($training->training->training_end < now()) {
                $responseData += ['status' => 1];
            } else {
                $responseData += ['status' => 0];
            }
            array_push($data, $responseData);
        }
        return ResponseFormatter::success($data, 'success');
    }

    public function showCustomerTrainingRecord($id) {
        // $training = TrainingRecord::find($id);
        $trainingRecord = TrainingRecord::with(['training', 'customer'])->find($id);
        // $customerDocuments = CustomerDocument::find($trainingRecord->customer->id, 'customer_id')->first();
        $customerDocuments = CustomerDocument::where('customer_id', $trainingRecord->customer->id)->first();
                
        $responseData = [
            'id' => $trainingRecord->id,
            'training_img' => $trainingRecord->training->training_img,
            'training_name' => $trainingRecord->training->training_name,
            'training_desc' => $trainingRecord->training->training_desc,
            'training_start' => $trainingRecord->training->training_start,
            'training_end' => $trainingRecord->training->training_end,
            'whatsapp_group' => $trainingRecord->training->whatsapp_group,
            'trainer_name' => $trainingRecord->training->trainer['name'],
            'trainer_cv' => $trainingRecord->training->trainer['cv'],
            'training_materials' => $trainingRecord->training->training_materials,
            'training_certificate' => $trainingRecord->training_certificate,
            'competence_certificate' => $trainingRecord->competence_certificate,
        ];

        if ($trainingRecord->training->training_end < now()) {
            $responseData += ['training_status' => 1];
        } else {
            $responseData += ['training_status' => 0];
        }
        
        if (!$customerDocuments) {
            $responseData += ['requirement_status' => 'Belum diunggah'];
        } elseif (
            !$customerDocuments->cv || !$customerDocuments->ktp 
            || !$customerDocuments->ijazah || !$customerDocuments->work_experience 
            || !$customerDocuments->portfolio
            ) {
                $responseData += ['requirement_status' => 'Belum lengkap'];
            // $file = '';
    
            // if (!$customerDocuments->cv) {
            //     $file .= 'CV, ';
            // }
            // if (!$customerDocuments->ktp) {
            //     $file .= 'KTP, ';
            // }
            // if (!$customerDocuments->ijazah) {
            //     $file .= 'Ijazah, ';
            // }
            // if (!$customerDocuments->work_experience ) {
            //     $file .= 'Pengalaman kerja, ';
            // }
            // if (!$customerDocuments->portfolio) {
            //     $file .= 'Portfolio ';
            // }
            
            // $responseData += ['requirement_status' => $file . 'belum diunggah'];
        } 
        else {
            $responseData += ['requirement_status' => 'Lengkap'];
        }

        return $responseData;
    }

    public function uploadTrainingRequirements(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'cv' => 'required|file',
            'ktp' => 'required|file',
            'ijazah' => 'required|file',
            'work_experience' => 'required|file',
            'portfolio' => 'required|file',
        ]);

        if ($validator->fails()) {
            return ResponseFormatter::error(null, $validator->errors()->first(), 400);
        }

        $customer = Customer::where('user_id', Auth::id())->first();
        $customerDocuments = CustomerDocument::where('customer_id', $customer->id)->first();

        $cv = $request->file('cv')->store('customer_documents/' . $customer->id, ['disk' => 'public']);
        $cvPath = asset('uploads/' . $cv);

        $ktp = $request->file('ktp')->store('customer_documents/' . $customer->id, ['disk' => 'public']);
        $ktpPath = asset('uploads/' . $ktp);

        $ijazah = $request->file('ijazah')->store('customer_documents/' . $customer->id, ['disk' => 'public']);
        $ijazahPath = asset('uploads/' . $ijazah);

        $workExperience = $request->file('work_experience')->store('customer_documents/' . $customer->id, ['disk' => 'public']);
        $workExperiencePath = asset('uploads/' . $workExperience);

        $portfolio = $request->file('portfolio')->store('customer_documents/' . $customer->id, ['disk' => 'public']);
        $portfolioPath = asset('uploads/' . $portfolio);

        if (!$customerDocuments) {
            try {
                CustomerDocument::create([
                    'cv' => $cvPath,
                    'ktp' => $ktpPath,
                    'ijazah' => $ijazahPath,
                    'work_experience' => $workExperiencePath,
                    'portfolio' => $portfolioPath,
                    'customer_id' => $customer->id,
                ]);
                
                return ResponseFormatter::success(null, 'File uploaded');
            } catch (\Throwable $th) {
                Helper::deleteFileOnStorage([$cvPath, $ktpPath, $ijazahPath, $workExperiencePath, $portfolioPath]);
                return ResponseFormatter::error(null, 'insert error: ' . $th, 400);
            }
        } elseif ($customerDocuments) {
            Helper::deleteFileOnStorage([$cvPath, $ktpPath, $ijazahPath, $workExperiencePath, $portfolioPath]);
            return ResponseFormatter::error(null, 'Already upload the file', 400);
        }
        // else {
        //     try {
        //         DB::table('customer_documents')->where('customer_id', $customer->id)->update([
        //             'cv' => $cvPath,
        //             'ktp' => $ktpPath,
        //             'ijazah' => $ijazahPath,
        //             'work_experience' => $workExperiencePath,
        //             'portfolio' => $portfolioPath,
        //             'customer_id' => $customer->id,
        //         ]);

        //         // Helper::deleteFileOnStorage([
        //         //     $customerDocuments->cv,
        //         //     $customerDocuments->ktp,
        //         //     $customerDocuments->ijazah,
        //         //     $customerDocuments->work_experience,
        //         //     $customerDocuments->portfolio,
        //         // ]);

        //         return ResponseFormatter::success(null, 'File uploaded');
        //     } catch (\Throwable $th) {
        //         Helper::deleteFileOnStorage([$cvPath, $ktpPath, $ijazahPath, $workExperiencePath, $portfolioPath]);
        //         return ResponseFormatter::error(null, 'update error: ' . $th, 400);
        //     }
        // }
        return ResponseFormatter::error(null, 'Failed to upload', 400);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
