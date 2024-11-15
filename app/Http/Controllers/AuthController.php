<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Expense;
use App\Models\Payment;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Laravel\Sanctum\PersonalAccessToken;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function register(Request $request){
        $request->validate([
            'Admin_lname'=>"required|max:255",
            'Admin_fname'=>"required|max:255",
            'Admin_mname'=>"required|max:255",
            'Admin_image'=>"string",
            'Birthdate'=>"nullable|date",
            'Phone_no'=>"required|string|max:12",
            'Address'=>"required|string|max:255",
            'Role'=>"required|string|max:25",
            'Email'=>"required|email|max:255|unique:admins",
            'Password'=>"required|confirmed|min:6"
        ]);

        $data = $request->all();
        $data['Password'] = Hash::make($request->Password);

        $staff = Admin::create($data);

        $staffList = Admin::orderBy('created_at', 'desc')->get();

        return response()->json([
            'message' => 'Staff added successfully',
            'staff' => $staff,
            'staffList' => $staffList
        ], 201);
    }


    public function login(Request $request){
        $request->validate([
            'email'=>"required|email|exists:admins,Email",
            "password"=>"required"
        ]);

        $user = Admin::where('Email', $request->email)->first();

        if(!$user || !Hash::check($request->password, $user->Password)){
            return response()->json([
                'message' => "The provided credentials are incorrect"
            ], 401);
        }

        $token = $user->createToken($user->Admin_lname);

        return response()->json([
            'user'=>$user,
            'token'=>$token->plainTextToken
        ]);
    }


    public function logout(Request $request){
        $token = $request->bearerToken();

        if (!$token) {
            return response()->json(['error' => 'Token not provided'], 401);
        }

        $personalAccessToken = PersonalAccessToken::findToken($token);

        if (!$personalAccessToken) {
            return response()->json(['error' => 'Token not found or invalid'], 401);
        }

        if ($request->user()->Admin_ID !== $personalAccessToken->tokenable_id) {
            return response()->json(['error' => 'Token does not belong to the authenticated user'], 403);
        }

        $personalAccessToken->delete();

        return response()->json(['message' => 'Logged out successfully'], 200);

        // return response()->json([
        //     $request->user()->Admin_ID
        // ], 200);
    }

    public function displayincome(Request $request)
    {

        $date = now()->toDateString(); 

        $allPayments = Admin::join('payments', 'admins.Admin_ID', '=', 'payments.Admin_ID')
            ->join('transactions','payments.Transac_ID','=','transactions.Transac_ID')
            ->select(
                'payments.Admin_ID',
                'admins.Admin_lname',
                'admins.Admin_fname',
                'admins.Admin_mname',
                'transactions.Tracking_number',
                DB::raw("CONCAT(admins.Admin_fname, ' ', admins.Admin_mname, ' ', admins.Admin_lname) AS name"),
                DB::raw('SUM(payments.Amount) as paymentsAmount'),
                DB::raw('MONTH(payments.Datetime_of_Payment) as paymentMonth'),
                DB::raw('DAY(payments.Datetime_of_Payment) as paymentDay'),
                DB::raw('YEAR(payments.Datetime_of_Payment) as paymentYear')
            )
            ->groupBy(
                'payments.Admin_ID',
                'admins.Admin_lname',
                'admins.Admin_fname',
                'admins.Admin_mname',
                'transactions.Tracking_number',
                'paymentMonth',
                'paymentDay',
                'paymentYear'
            )
            ->whereDate('Datetime_of_Payment', $date)
            ->get();

        $allExpenses = Admin::join('expenses', 'admins.Admin_ID', '=', 'expenses.Admin_ID')
            ->select(
                'expenses.Admin_ID',
                'admins.Admin_lname',
                'admins.Admin_fname',
                'admins.Admin_mname',
                'expenses.Amount',
                'expenses.Desc_reason',
                'Datetime_taken',
                DB::raw("CONCAT(admins.Admin_fname, ' ', admins.Admin_mname, ' ', admins.Admin_lname) AS name"),
                // DB::raw('SUM(expenses.Amount) as expenseAmount')
            )
            ->whereDate('Datetime_taken', $date)
            // ->groupBy(
            //     'expenses.Admin_ID',
            //     'admins.Admin_lname',
            //     'admins.Admin_fname',
            //     'admins.Admin_mname'
            // )
            ->get();

        $expense = Expense::whereDate('Datetime_taken', $date)->sum('Amount');
        $payments = Payment::whereDate('Datetime_of_Payment', $date)->sum('Amount');

        $totalall = $payments - $expense;

        return response()->json([
            'payment' => $allPayments,
            'expenses' =>  $allExpenses,
            'totalpayment' => $payments,
            'totalexpenses' => $expense,
            'overalltal' =>  $totalall
        ], 200);
    }
}
