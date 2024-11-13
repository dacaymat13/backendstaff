<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{

    public function store(Request $request)
    {
        $request->validate([
            'Cust_lname' => "required|max:255",
            'Cust_fname' => "required|max:255",
            'Cust_mname' => "required|max:255",
            'Cust_image' => "string",
            'Cust_phoneno' => "string|required|max:11",
            'Cust_address'  => "string|required|max:100",
            'Cust_email'  => "string|required|max:50|unique:customers",
            'Cust_password' => "required|confirmed|min:8"
        ]);

        $data = $request->all();
        $data['Cust_password'] = Hash::make($request->Cust_password);

        $cust = Customer::create($data);

        $custList = Customer::orderBy('created_at', 'desc')->get();

        return response()->json([
            'message' => 'Customer added successfully',
            'Customer' => $cust,
            'Customer List' => $custList
        ], 201);
    }

    public function index()
    {
        $custList = Customer::select("*")->get();
        return $custList;
    }

    public function show($id)
    {
        $cust = Customer::where("Cust_ID", $id)->first();

        if (!$cust) {
            return response()->json(['message' => 'Transaction not found'], 404);
        }

        return response()->json($cust);
    }

}
