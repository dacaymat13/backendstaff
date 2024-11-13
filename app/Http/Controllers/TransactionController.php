<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $trans = DB::table('transactions')
        // ->leftJoin('customers', 'customers.Cust_ID', '=', 'transactions.Cust_ID')
        // ->leftJoin('transaction_details', 'transactions.Transac_ID', '=', 'transaction_details.Transac_ID')
        // ->leftJoin('additional_services', 'transactions.Transac_ID', '=', 'additional_services.Transac_ID')
        // ->leftJoin('laundry_categories', 'laundry_categories.Categ_ID', '=', 'transaction_details.Categ_ID')
        // ->leftJoin('payments', 'transactions.Transac_ID', '=', 'payments.Transac_ID')
        // ->leftJoin('proof_of_payments', 'payments.Payment_ID', '=', 'proof_of_payments.Payment_ID')
        // ->select(
        //     'transactions.Transac_ID',
        //     'customers.Cust_ID',
        //     DB::raw("CONCAT(customers.Cust_fname, ' ', customers.Cust_mname, ' ', customers.Cust_lname) AS `CustomerName`"),
        //     'customers.Cust_phoneno',
        //     'transactions.Tracking_number',
        //     'transactions.Transac_date',
        //     'transactions.Received_datetime',
        //     'transactions.Transac_status',
        //     DB::raw('SUM(transaction_details.Price) AS `amount`'),
        //     DB::raw("IF(payments.Mode_of_Payment IS NULL, 'unpaid', payments.Mode_of_Payment) AS `payment`")
        // )
        // ->whereNotIn('transactions.Transac_status', ['completed', 'canceled'])
        // ->groupBy(
        //     'transactions.Transac_ID',
        //     'customers.Cust_ID',
        //     'customers.Cust_fname',
        //     'customers.Cust_mname',
        //     'customers.Cust_lname',
        //     'customers.Cust_phoneno',
        //     'transactions.Tracking_number',
        //     'transactions.Transac_date',
        //     'transactions.Received_datetime',
        //     'transactions.Transac_status',
        //     'payments.Amount',
        //     'payments.Mode_of_Payment'
        // )
        // ->get();

        $trans = DB::table('transactions')
    ->leftJoin('customers', 'customers.Cust_ID', '=', 'transactions.Cust_ID')
    ->leftJoin('transaction_details', 'transactions.Transac_ID', '=', 'transaction_details.Transac_ID')
    ->leftJoin('additional_services', 'transactions.Transac_ID', '=', 'additional_services.Transac_ID')
    ->leftJoin('laundry_categories', 'laundry_categories.Categ_ID', '=', 'transaction_details.Categ_ID')
    ->leftJoin('payments', 'transactions.Transac_ID', '=', 'payments.Transac_ID')
    ->leftJoin('proof_of_payments', 'payments.Payment_ID', '=', 'proof_of_payments.Payment_ID')
    ->leftJoin('admins', 'transactions.Admin_ID', '=', 'admins.Admin_ID')
    ->select(
        'transactions.Transac_ID',
        'customers.Cust_ID',
        DB::raw("CONCAT(customers.Cust_fname, ' ', customers.Cust_mname, ' ', customers.Cust_lname) AS CustomerName"),
        'customers.Cust_phoneno',
        'transactions.Tracking_number',
        'transactions.Transac_date',
        'transactions.Transac_status',
        DB::raw('SUM(CASE WHEN transactions.Received_datetime IS NOT NULL AND transactions.Admin_ID = admins.Admin_ID THEN transaction_details.Price ELSE NULL END) AS amount'),
        DB::raw('CASE WHEN SUM(transaction_details.Price) IS NOT NULL AND transactions.Admin_ID = admins.Admin_ID THEN transactions.Received_datetime ELSE NULL END AS Received_datetime'),
        DB::raw("IF(payments.Mode_of_Payment IS NULL, 'unpaid', payments.Mode_of_Payment) AS payment"),
        // Adding the receiving_type logic
        DB::raw("CASE
            WHEN EXISTS (
                SELECT 1
                FROM additional_services
                WHERE additional_services.AddService_name = 'Pick-up Service' AND additional_services.Transac_ID = transactions.Transac_ID
            )
            THEN 'Pick-up Service'
            ELSE 'Drop-off'
        END AS receiving_type")
    )
    ->whereNotIn('transactions.Transac_status', ['completed', 'canceled'])
    ->groupBy(
        'transactions.Transac_ID',
        'customers.Cust_ID',
        'customers.Cust_fname',
        'customers.Cust_mname',
        'customers.Cust_lname',
        'customers.Cust_phoneno',
        'transactions.Tracking_number',
        'transactions.Transac_date',
        'transactions.Received_datetime',
        'transactions.Transac_status',
        'payments.Amount',
        'transactions.Admin_ID',
        'admins.Admin_ID',
        'payments.Mode_of_Payment'
    )
    ->get();
        // DB::raw("DATE_FORMAT(transactions.Received_datetime, '%Y-%m-%d') AS `date`"),
        // DB::raw("DATE_FORMAT(transactions.Received_datetime, '%H:%i:%s') AS `time`"),
            // ->whereNotIn('transactions.Transac_status', ['completed', 'canceled'])

        if(is_null($trans)){
            return response()->json(['message' => 'Transaction not found'], 404);
        }
        return response()->json($trans,200);
    }

    public function showTransCust($id)
    {
        $trans = DB::table('transactions')
        ->leftJoin('customers', 'customers.Cust_ID', '=', 'transactions.Cust_ID')
        ->leftJoin('transaction_details', 'transactions.Transac_ID', '=', 'transaction_details.Transac_ID')
        ->leftJoin('additional_services', 'transactions.Transac_ID', '=', 'additional_services.Transac_ID')
        ->leftJoin('laundry_categories', 'laundry_categories.Categ_ID', '=', 'transaction_details.Categ_ID')
        ->leftJoin('payments', 'transactions.Transac_ID', '=', 'payments.Transac_ID')
        ->leftJoin('proof_of_payments', 'payments.Payment_ID', '=', 'proof_of_payments.Payment_ID')
        ->select(
            'transactions.Transac_ID',
            'customers.Cust_ID',
            DB::raw("CONCAT(customers.Cust_fname, ' ', customers.Cust_mname, ' ', customers.Cust_lname) AS `CustomerName`"),
            'customers.Cust_phoneno',
            'customers.Cust_address',
            'transactions.Tracking_number',
            'transactions.Transac_date',
            'transactions.Received_datetime',
            'transactions.Transac_status',
            'transaction_details.TransacDet_ID',
            DB::raw('sum(transaction_details.Price) AS TotalPrice'),
            'additional_services.AddService_name',
            'additional_services.AddService_price',
            DB::raw('SUM(transaction_details.Price) AS `amount`'),
            DB::raw("IF(payments.Mode_of_Payment IS NULL, 'unpaid', payments.Mode_of_Payment) AS `payment`")
        )
        ->where('transactions.Transac_ID', $id)
        ->whereNotIn('transactions.Transac_status', ['completed', 'canceled'])
        ->groupBy(
            'transactions.Transac_ID',
            'customers.Cust_ID',
            'customers.Cust_fname',
            'customers.Cust_mname',
            'customers.Cust_lname',
            'customers.Cust_phoneno',
            'customers.Cust_address',
            'transactions.Tracking_number',
            'transactions.Transac_date',
            'transactions.Received_datetime',
            'transactions.Transac_status',
            'transaction_details.TransacDet_ID',
            'additional_services.AddService_name',
            'additional_services.AddService_price',
            'payments.Amount',
            'payments.Mode_of_Payment'
        )
        ->get();

        // DB::raw("DATE_FORMAT(transactions.Received_datetime, '%Y-%m-%d') AS `date`"),
        // DB::raw("DATE_FORMAT(transactions.Received_datetime, '%H:%i:%s') AS `time`"),
            // ->whereNotIn('transactions.Transac_status', ['completed', 'canceled'])

        if(is_null($trans)){
            return response()->json(['message' => 'Transaction not found'], 404);
        }
        return response()->json($trans,200);
    }

    public function showLaundryDetails($id){
        $laundryDetails = DB::table('transaction_details')
            ->join('laundry_categories', 'transaction_details.Categ_ID', '=', 'laundry_categories.Categ_ID')
            ->leftJoin('addlaundry_services', 'transaction_details.TransacDet_ID', '=', 'addlaundry_services.TransacDet_ID')
            ->select(
                'laundry_categories.Categ_ID',
                'laundry_categories.Category',
                'laundry_categories.Price',
                'transaction_details.Qty',
                'transaction_details.Weight',
                'transaction_details.Price AS EachPrice',
                DB::raw("GROUP_CONCAT(CONCAT(' ', addlaundry_services.AddLaundryServ_name) SEPARATOR ' + ') AS AddLaundry_Services"),
                DB::raw('SUM(transaction_details.Price) AS TotalPrice'),
                'transaction_details.TransacDet_ID'
            )
            ->where('transaction_details.Transac_ID', $id)
            ->groupBy(
                'laundry_categories.Categ_ID',
                'laundry_categories.Category',
                'laundry_categories.Price',
                'transaction_details.Qty',
                'transaction_details.Weight',
                'transaction_details.Price',
                'transaction_details.TransacDet_ID'
            )
            ->get();

            if(is_null($laundryDetails)){
                return response()->json(['message' => 'Laundry Details not found'], 404);
            }
            return response()->json($laundryDetails,200);
    }

    public function getAddService($id){
        $service = DB::table('additional_services')
            ->select(
                'AddService_ID',
                'AddService_name AS result',
                'AddService_price AS service_price',
                'Transac_ID')
            ->where('Transac_ID', $id)

            // Using union for the second part
            ->unionAll(
                DB::table(DB::raw('(SELECT NULL AS AddService_ID, "none" AS result, NULL AS service_price, NULL AS Transac_ID) AS sub'))
                ->whereNotExists(function ($query) use ($id) {
                    $query->select(DB::raw(1))
                        ->from('additional_services')
                        ->where('Transac_ID', $id);
                })
            )
            ->get();

            if(is_null($service)){
                return response()->json(['message' => 'Laundry Details not found'], 404);
            }
            return response()->json($service,200);
    }

    public function totalPrice($id){
        $totalPrice = DB::table('transaction_details')
            ->select(DB::raw('SUM(Price) AS Total'))
            ->where('Transac_ID', $id)
            ->groupBy('Transac_ID')
            ->get();

            if(is_null($totalPrice)){
                return response()->json(['message' => 'Laundry Details not found'], 404);
            }
            return response()->json($totalPrice,200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'Cust_ID' => "required",
            'Admin_ID' => "required",
            'Transac_date' => "date|required",
            'Transac_status' => "string|required",
            'Tracking_number' => "string|required",
            'Pickup_datetime'  => "date|required",
            'Delivery_datetime' => "date|required"
        ]);

        $data = $request->all();
        $data['Cust_ID'] != null; //make it that the ID should be visible in their respective tables
        $data['Admin_ID'] != null;

        $custHist = Transaction::create($data);

        $custHistList = Transaction::orderBy('created_at', 'desc')->get();

        return response()->json([
            'message' => 'Transaction added successfully',
            'Customer History' => $custHist,
            'Customer History List' => $custHistList
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // $trans = Transaction::where("transactions.Cust_ID", $id)
        //     ->join("customers", "transactions.Cust_ID", "=", "customers.Cust_ID")
        //     ->join("transaction_details", "transactions.Transac_ID", "=", "transaction")
        //     ->select("transactions.*")
        //     ->get();

        $trans = Transaction::where("transactions.Cust_ID", $id)
            ->join('customers', 'transactions.Cust_ID', '=', 'customers.Cust_ID')
            ->leftJoin('transaction_details', 'transactions.Transac_ID', '=', 'transaction_details.Transac_ID')
            ->leftJoin('laundry_categories', 'transaction_details.Categ_ID', '=', 'laundry_categories.Categ_ID')
            ->leftJoin('admins', 'admins.Admin_ID', '=', 'transactions.Admin_ID')
            ->select(
                'transactions.Transac_ID as Transac_ID',
                'transactions.Tracking_number as Tracking_number',
                'transactions.Transac_date as Transac_date',
                DB::raw("GROUP_CONCAT(CONCAT(' ', transaction_details.Weight, ' kg of ', laundry_categories.Category, ' (', transaction_details.Qty, ' pieces)') SEPARATOR ', ') AS Laundry_Details"),
                DB::raw('SUM(transaction_details.price) AS amount'),
                'transactions.Transac_status as Transac_status',
                DB::raw("concat(admins.Admin_fname, ' ', admins.Admin_mname, ' ', admins.Admin_lname) as staff_name")
            )
            ->groupBy(
                'transactions.Transac_ID',
                'transactions.Tracking_number',
                'transactions.Transac_date',
                'transactions.Transac_status',
                'admins.Admin_fname',
                'admins.Admin_mname',
                'admins.Admin_lname',
                )
            ->get();

        if(is_null($trans)){
            return response()->json(['message' => 'Transaction not found'], 404);
        }
        return response()->json($trans,200);


        // $trans = Transaction::where("Cust_ID", $id)->first();

        // if (!$trans) {
        //     return response()->json(['message' => 'Transaction not found'], 404);
        // }

        // return response()->json($trans);
    }

    public function saveLaundryDetails(Request $request)
    {
        foreach ($request->laundryDetails as $laundryDetail) {
            DB::table('transaction_details')
                ->where('TransacDet_ID', $laundryDetail['TransacDet_ID'])
                ->update([
                    'Weight' => $laundryDetail['Weight'],
                    'Price' => $laundryDetail['Price']
                ]);
        }

        return response()->json(['message' => 'Laundry details updated successfully.']);
    }



    public function getCash($id)
    {
        $results = DB::table('cash')
        ->leftJoin('admins', 'cash.Admin_ID', '=', 'admins.Admin_ID')
        ->where('Staff_ID', $id)
        ->whereNull('Remittance')
        ->get();

        if(is_null($results)){
            return response()->json(['message' => 'Cash not found'], 404);
        }
        return response()->json($results,200);
    }

    public function addRem(Request $request)
    {
        $validatedData = $request->validate([
            'Remittance' => 'required|string', // adjust validation rules as needed
        ]);

        $updated = DB::table('cash')
            ->where('Cash_ID', '1')
            ->update([
                'Remittance' => $validatedData['Remittance'],
                'Datetime_Remittance' => now()
            ]);

        if ($updated) {
            return response()->json(['message' => 'Remittance updated successfully.'], 200);
        } else {
            return response()->json(['message' => 'Update failed.'], 500);
        }
    }

    public function submitLaundryTrans(Request $request, $id){
        $validatedData = $request->validate([
            'Admin_ID' => 'required',
        ]);

        $updated = DB::table('transactions')
            ->where('Cust_ID', $id)
            ->update([
                'Admin_ID' => $validatedData['Admin_ID'],
                'Transac_status' => 'received',
                'Received_datetime' => now()
            ]);

        if ($updated) {
            return response()->json(['message' => 'Remittance updated successfully.'], 200);
        } else {
            return response()->json(['message' => 'Update failed.'], 500);
        }
    }

    public function updateStatus(Request $request, $id){
        $validatedData = $request->validate([
            'status'=> 'required',
            'staffID' => 'required'
        ]);


        $validatedData['staffID'] != null;

        $updateStatus = DB::table('transactions')
        ->where('Transac_ID', $id)
        ->where('Admin_ID', $validatedData['staffID'])
        ->update(['Transac_status' => $validatedData['status']]);

        if ($updateStatus) {
            return response()->json(['message' => 'Transaction status updated successfully.'], 200);
        } else {
            return response()->json(['message' => 'Update failed.'], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTransactionRequest $request, Transaction $transaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction)
    {
        //
    }
}
