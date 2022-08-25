<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Helpers\ResponseFormatter;
use App\Models\Customer;
use App\Models\CustomerDocument;
use App\Models\Training;
use App\Models\TrainingRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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
        // return $trainings;
        if ($trainings->isEmpty()) {
            // return ResponseFormatter::error(null, 'You have not register any training', 200);
            return ResponseFormatter::success(null, 'You have not register any training');
        }
        
        $data = [];
        foreach ($trainings as $training) {
            $responseData = [
                'id' => $training->id,
                'training_name' => $training->training->training_name,
            ];

            if ($training->training->training_end < now()) {
                $responseData += ['status' => 'Selesai'];
            } else {
                $responseData += ['status' => 'Sedang Berjalan'];
            }
            array_push($data, $responseData);
        }
        return ResponseFormatter::success($data, 'success');
    }

    public function showCustomerTrainingRecord($id) {
        // $training = TrainingRecord::find($id);
        $trainingRecord = TrainingRecord::with(['training', 'customer'])->find($id);
        if (!$trainingRecord) {
            return ResponseFormatter::error(null, 'Data not found', 400);
        }
        // return $trainingRecord->training->trainer['cv'];
        // $customerDocuments = CustomerDocument::find($trainingRecord->customer->id, 'customer_id')->first();
        $customerDocuments = CustomerDocument::where('customer_id', $trainingRecord->customer->id)->first();
                
        $responseData = [
            'id' => $trainingRecord->id,
            'training_img' => $trainingRecord->training->training_img ? url('storage/' . $trainingRecord->training->training_img) : null,
            'training_name' => $trainingRecord->training->training_name,
            'training_desc' => $trainingRecord->training->training_desc,
            'training_start' => $trainingRecord->training->training_start,
            'training_end' => $trainingRecord->training->training_end,
            'whatsapp_group' => $trainingRecord->training->whatsapp_group,
            'trainer_name' => $trainingRecord->training->trainer['name'],
            'trainer_cv' => $trainingRecord->training->trainer['cv'] ? url('storage/' . $trainingRecord->training->trainer['cv']) : null,
            'training_materials' => $trainingRecord->training->training_materials ? url('storage/' . $trainingRecord->training->training_materials) : null,
            'training_certificate' => $trainingRecord->training_certificate ? url('storage/' . $trainingRecord->training_certificate) : null,
            'competence_certificate' => $trainingRecord->competence_certificate ? url('storage/' . $trainingRecord->competence_certificate) : null,
        ];

        if ($trainingRecord->training->training_end < now()) {
            $responseData += ['status' => 'Selesai'];
        } else {
            $responseData += ['status' => 'Sedang Berjalan'];
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

        return ResponseFormatter::success($responseData, 'success');
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

        $cv = $request->file('cv')->store('public/uploads/customer_documents/' . $customer->id);
        $cvPath = asset('storage/' . $cv);

        $ktp = $request->file('ktp')->store('public/uploads/customer_documents/' . $customer->id);
        $ktpPath = asset('storage/' . $ktp);

        $ijazah = $request->file('ijazah')->store('public/uploads/customer_documents/' . $customer->id);
        $ijazahPath = asset('storage/' . $ijazah);

        $workExperience = $request->file('work_experience')->store('public/uploads/customer_documents/' . $customer->id);
        $workExperiencePath = asset('storage/' . $workExperience);

        $portfolio = $request->file('portfolio')->store('public/uploads/customer_documents/' . $customer->id);
        $portfolioPath = asset('storage/' . $portfolio);

        if (!$customerDocuments) {
            try {
                CustomerDocument::create([
                    'cv' => Str::remove('public/', $cv),
                    'ktp' => Str::remove('public/', $ktp),
                    'ijazah' => Str::remove('public/', $ijazah),
                    'work_experience' => Str::remove('public/', $workExperience),
                    'portfolio' => Str::remove('public/', $portfolio),
                    'customer_id' => $customer->id,
                ]);
                
                return ResponseFormatter::success(null, 'File uploaded');
            } catch (\Throwable $th) {
                Helper::deleteFileOnStorage([$cvPath, $ktpPath, $ijazahPath, $workExperiencePath, $portfolioPath]);
                return ResponseFormatter::error(null, 'insert error: ' . $th, 400);
            }
        } elseif ($customerDocuments) {
            try {
                CustomerDocument::where('customer_id', $customer->id)->update([
                    'cv' => Str::remove('public/', $cv),
                    'ktp' => Str::remove('public/', $ktp),
                    'ijazah' => Str::remove('public/', $ijazah),
                    'work_experience' => Str::remove('public/', $workExperience),
                    'portfolio' => Str::remove('public/', $portfolio),
                    'customer_id' => $customer->id,
                ]);
                
                return ResponseFormatter::success(null, 'File uploaded');
            } catch (\Throwable $th) {
                Helper::deleteFileOnStorage([$cvPath, $ktpPath, $ijazahPath, $workExperiencePath, $portfolioPath]);
                return ResponseFormatter::error(null, 'insert error: ' . $th, 400);
            }
            // Helper::deleteFileOnStorage([$cvPath, $ktpPath, $ijazahPath, $workExperiencePath, $portfolioPath]);
            // return ResponseFormatter::error(null, 'Already upload the file', 400);
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

    public function getTrainingCustomers($training_id)
    {
        $customers = TrainingRecord::with(['customer', 'training'])->where('training_id', $training_id)->get();
        return ResponseFormatter::success($customers, 'success');
    }

    public function uploadCompetenceCertificate(Request $request, $trainingRecorId)
    {
        $competenceCertificate = $request->file('competence_certificate')->store('public/uploads/certificate/competence');
        // $trainingCertificate = $request->file('training_certificate')->store('public/uploads/certificate/training');

        DB::table('training_records')
            ->where('id', $trainingRecorId)
            ->update([
                'competence_certificate' => Str::remove('public/', $competenceCertificate),
                // 'training_certificate' => Str::remove('public/', $trainingCertificate),
            ]);
        
        return ResponseFormatter::success(null, 'success');
    }

    public function uploadTrainingCertificate(Request $request, $trainingRecorId)
    {
        $trainingCertificate = $request->file('training_certificate')->store('public/uploads/certificate/training');

        DB::table('training_records')
            ->where('id', $trainingRecorId)
            ->update([
                'training_certificate' => Str::remove('public/', $trainingCertificate),
            ]);
        
        return ResponseFormatter::success(null, 'success');
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
