<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Digiflazz\Balance;
use App\Models\Digiflazz\TopUp;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class AdminController extends Controller
{
    public function dashboard()
    {
        $total_transaction = TopUp::count();
        $total_payout = TopUp::where('user_id', Auth::user()->id)->sum('price');
        $pending_transaction = TopUp::where('user_id', Auth::user()->id)->where('status', 'Pending')->count();
        // $balance = Auth::user()->balance;
        $balance = Balance::firstOrCreate(['id' => 1])->balance;
        return Inertia::render('Admin/Dashboard', [
            'total_transaction' => $total_transaction,
            'total_payout' => $total_payout,
            'pending_transaction' => $pending_transaction,
            'balance' => $balance,
        ]);
    }

    public function products()
    {
        $products = Product::paginate(10);

        return Inertia::render('Admin/Products', [
            'products' => $products
        ]);
    }

    public function transactions()
    {
        $transactions = TopUp::where('user_id', Auth::user()->id)->with('product')->paginate(10);
        $totalTransactions = TopUp::where('user_id', Auth::user()->id)->count();
        $totalPayment = TopUp::where('user_id', Auth::user()->id)->sum('price');

        return Inertia::render('Admin/Transactions', [
            'transactions' => $transactions,
            'total_transaction' => $totalTransactions,
            'total_payment' => $totalPayment
        ]);
    }

    public function balances()
    {
        $balance = Auth::user()->balance;
        $totalTransactions = TopUp::where('user_id', Auth::user()->id)->sum('price');

        return Inertia::render('Admin/Balances', [
            'balance' => $balance,
            'total_transaction' => $totalTransactions
        ]);
    }
}
