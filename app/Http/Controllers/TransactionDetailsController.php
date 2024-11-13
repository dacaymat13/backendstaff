<?php

namespace App\Http\Controllers;

use App\Models\Transaction_Details;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionDetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storeTransCust(Request $request)
    {
        $request->validate([
            "Cust_ID" => 'required|integer',
            "Tracking_number" => 'required|string',
        ]);

        $data = [
            'Cust_ID' => $request->Cust_ID,
            'Transac_date' => now(),
            'Transac_status' => 'pending',
            'Tracking_number' => $request->Tracking_number
        ];

        $data['Cust_ID'] != null;
        $transCust = DB::table('transactions')->insert($data);

        $transCustList = DB::table('transactions')->orderBy('created_at', 'desc')->get();

        return response()->json([
            'message' => $transCust ? 'Transaction successfully added.' : 'Failed to add transaction.',
            'Transaction List' => $transCustList
        ]);


    }

    public function storeTransDetCust(Request $request)
    {
        $request->validate([
            "Categ_ID" => 'required|integer',
            "Transac_ID" => 'required|integer',
            "Qty" => 'required|integer'
        ]);

        $data = [
            'Categ_ID' => $request->Categ_ID,
            'Transac_ID' => $request->Transac_ID,
            'Qty' => $request->Qty
        ];

        $data['Categ_ID'] != null;
        $data['Transac_ID'] != null;
        $transDetCust = DB::table('transaction_details')->insert($data);

        $transDetCustList = DB::table('transaction_details')->orderBy('created_at', 'desc')->get();

        return response()->json([
            'message' => $transDetCust ? 'Transaction successfully added.' : 'Failed to add transaction.',
            'Transaction List' => $transDetCustList
        ]);


    }

    /**
     * Display the specified resource.
     */
    public function show(Transaction_Details $transaction_Details)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTransaction_DetailsRequest $request, Transaction_Details $transaction_Details)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction_Details $transaction_Details)
    {
        //
    }
}
