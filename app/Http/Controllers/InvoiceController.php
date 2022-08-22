<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseFormatter;
use App\Models\Invoice;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function index()
    {
        $data = Invoice::with(['customer', 'training'])->orderBy('created_at', 'DESC')->get();
        return ResponseFormatter::success($data, 'success');
    }

    public function show($id)
    {
        $data = Invoice::with(['customer', 'training'])->where('id', $id)->first();
        return ResponseFormatter::success($data, 'success');
    }

    public function destroy($id)
    {
        $invoice = Invoice::findOrFail($id);
        if (!$invoice) return ResponseFormatter::error(null, 'Data not found', 400);

        $invoice->delete();

        return ResponseFormatter::success(null, 'success');
    }
}
