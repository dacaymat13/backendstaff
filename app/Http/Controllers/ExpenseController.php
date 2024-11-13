<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class ExpenseController extends Controller
{
    public function index()
    {
        $expList = DB::table('expenses')
        ->leftJoin('admins', 'expenses.Admin_ID', '=', 'admins.Admin_ID')
        ->select(
            'expenses.Expense_ID',
            DB::raw("CONCAT(admins.Admin_fname, ' ', admins.Admin_mname, ' ', admins.Admin_lname) AS `AdminName`"),
            'expenses.Amount',
            'expenses.Desc_reason',
            'expenses.Receipt_filenameimg',
            'expenses.Datetime_taken'
        )
        ->groupBy(
            'expenses.Expense_ID',
            'admins.Admin_fname',
            'admins.Admin_mname',
            'admins.Admin_lname',
            'expenses.Amount',
            'expenses.Desc_reason',
            'expenses.Receipt_filenameimg',
            'expenses.Datetime_taken'
        )
        ->get();

        return $expList;
    }

    public function store(Request $request)
    {
        $request->validate([
            'Admin_ID' => "required",
            'Amount' => "required",
            'Desc_reason' => "required|max:255",
            'Receipt_filenameimg' => "required|string",
            'Datetime_taken' => "date"
        ]);

        $data = $request->all();
        $data['Datetime_taken'] = now();

        $exp = Expense::create($data);

        $expList = Expense::orderBy('created_at', 'desc')->get();

        return response()->json([
            'message' => 'Expense added Successfully',
            'Expense' => $exp,
            'Expense List' => $expList
        ], 201);
    }

    public function show($id)
    {
        $expList = DB::table('expenses')
        ->leftJoin('admins', 'expenses.Admin_ID', '=', 'admins.Admin_ID')
        ->select(
            'expenses.Expense_ID',
            DB::raw("CONCAT(admins.Admin_fname, ' ', admins.Admin_mname, ' ', admins.Admin_lname) AS `AdminName`"),
            'expenses.Amount',
            'expenses.Desc_reason',
            'expenses.Receipt_filenameimg',
            'expenses.Datetime_taken'
        )
        ->where('expenses.Expense_ID', $id)
        ->groupBy(
            'expenses.Expense_ID',
            'admins.Admin_fname',
            'admins.Admin_mname',
            'admins.Admin_lname',
            'expenses.Amount',
            'expenses.Desc_reason',
            'expenses.Receipt_filenameimg',
            'expenses.Datetime_taken'
        )
        ->get();

        return $expList;
    }

    public function upload(Request $request)
    {
        $request->validate([
            'Expense_ID' => 'required',
            'file' => 'required|file|mimes:jpg,jpeg,png,webp'
        ]);

        if($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = time() . '_' . $file->getClientOriginalName();

            $filePath = $file->storeAs('expReceipts', $filename, 'public');

            $expense = Expense::find($request->input('Expense_ID'));

            if (!$expense) {
                return response()->json([
                    'message' => 'Expense not found.'
                ], 404);
            }

            // $media = new Media();
            // $media->Expense_ID = $request->input('Expense_ID');
            // $media->type = $file->getClientOriginalExtension();
            // $media->filename = $filePath;
            // $media->save();
            $expense->Receipt_filenameimg = $filePath;
            $expense->save();

            return response()->json([
                'message' => 'Expense Receipt Uploaded.',
                'file' => $filePath
            ], 200);
        }
    }

    public function destroy(Expense $expense)
    {
        //
    }
}
