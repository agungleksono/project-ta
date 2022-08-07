<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseFormatter;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Training;
use App\Models\TrainingRecord;
use Facade\FlareClient\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

use function PHPUnit\Framework\isEmpty;

class TrainingController extends Controller
{
    public function index()
    {
        $trainings = Training::all();
        if(count($trainings) == 0) {
            return ResponseFormatter::error(null, 'Data not found', 400);
        }

        return ResponseFormatter::success($trainings, 'success');
    }

    public function create()
    {
        
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'training_name' => 'required|string',
            'training_img' => 'required|image',
            'training_desc' => 'required|string',
            'training_price' => 'required|numeric',
            'register_start' => 'required|date',
            'register_end' => 'required|date',
            'training_start' => 'required|date',
            'training_end' => 'required|date',
            'trainer_id' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'error' => 'Invalid request',
                'data' => $validator->errors()
            ], 400);
        }

        $training_img = $request->file('training_img')->store('training', ['disk' => 'public']);
        $path = asset('uploads/' . $training_img);

        Training::create([
            'training_name' => $request->post('training_name'),
            'training_img' => $path,
            'training_desc' => $request->post('training_desc'),
            'training_price' => $request->post('training_price'),
            'register_start' => $request->post('register_start'),
            'register_end' => $request->post('register_end'),
            'training_start' => $request->post('training_start'),
            'training_end' => $request->post('training_end'),
            'trainer_id' => $request->post('trainer_id'),

        ]);

        return ResponseFormatter::success(null, 'success');
    }

    public function show($id)
    {
        $training = Training::find($id);        
        if (!$training) {
            return ResponseFormatter::error(null, 'Data not found', 400);
        }
        
        // check is customer have been registered the training
        $customer_id = Customer::where('user_id', Auth::id())->first()->id;
        $isRegistered = TrainingRecord::where('training_id', $id)->where('customer_id', $customer_id)->first();
        if (empty($isRegistered)) {
            $training->status = 0;
        } else {
            $training->status = 1;
        }
        
        return ResponseFormatter::success($training, 'success');
    }

    public function edit($id)
    {
        
    }
    
    public function update(Request $request, int $id)
    {
        $validator = Validator::make($request->all(), [
            'training_name' => 'required|string',
            'training_img' => '',
            'training_desc' => 'required|string',
            'training_price' => 'required|numeric',
            'register_start' => 'required|date',
            'register_end' => 'required|date',
            'training_start' => 'required|date',
            'training_end' => 'required|date',
            'trainer_id' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'error' => 'Invalid request',
                'data' => $validator->errors()
            ], 400);
        }

        $training = Training::find($id);
        if (!$training) return response()->json([
            'status' => 404,
            'error' => 'Data not found',
            'data' => null,
        ], 404);

        $training->training_name = $request->post('training_name', $training->training_name);
        $training->training_img = $request->post('training_img', $training->training_img);
        $training->training_desc = $request->post('training_desc', $training->training_desc);
        $training->training_price = $request->post('training_price', $training->training_price);
        $training->register_start = $request->post('register_start', $training->register_start);
        $training->register_end = $request->post('register_end', $training->register_end);
        $training->training_start = $request->post('training_start', $training->training_start);
        $training->training_end = $request->post('training_end', $training->training_end);
        $training->trainer_id = $request->post('trainer_id', $training->trainer_id);
        $training->save();

        return response()->json([
            'status' => 200,
            'error' => null,
            'data' => null,
        ], 200);
    }
    
    public function destroy($id)
    {
        $training = Training::find($id);
        if (!$training) return response()->json([
            'status' => 404,
            'error' => 'Data not found',
            'data' => null,
        ], 404);

        $training->delete();

        return response()->json([
            'status' => 200,
            'error' => null,
            'data' => null,
        ], 200);
    }

    public function registerTraining(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'training_id' => 'required',
        ]);

        if ($validator->fails()) {
            return ResponseFormatter::error(null, $validator->errors()->first(), 400);
        }

        try {
            $customer = Customer::where('user_id', Auth::id())->get();
            $customer_id = $customer[0]->id;
            $date = now()->format('Ymd');
            $invoice_number = $date . Str::upper(Str::random(8));    
            $training = Training::findOrFail($request->training_id);
            $invoice_total = $training->training_price;

            DB::transaction(function () use ($request, $invoice_number, $customer_id, $invoice_total) {
                TrainingRecord::create([
                    // 'scheme' => $request->post('scheme'),
                    // 'trainer_id' => $request->post('trainer_id'),
                    'customer_id' => $customer_id,
                    'training_id' => $request->post('training_id'),
                ]);
                
        
                Invoice::create([
                    'invoice_number' => $invoice_number,
                    'invoice_total' => $invoice_total,
                    'invoice_status' => 0,
                    // 'invoice_payment_method'
                    // 'invoice_payment_deadline' => now()->addDay(),
                    'invoice_payment_date' => now(),
                    'training_id' => $request->post('training_id'),
                    'customer_id' => $customer_id,
                ]);
            });
            return ResponseFormatter::success(null, 'Upload success');            
        } catch (\Throwable $th) {
            return ResponseFormatter::error(null, 'Register training failed', 400);
        }



    }
}
