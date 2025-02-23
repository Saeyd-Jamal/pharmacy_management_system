<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Expense;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // public function index()
    // {
    //     $this->authorize('view', Expense::class);

    //     $request = request();
    //     if ($request->ajax()) {
    //         $expenses = Expense::query();

    //         return DataTables::of($expenses)
    //             ->addIndexColumn()
                
    //             ->addColumn('created_by', function ($expense) {
    //                 return $expense->user->name ?? 'غير محدد';
    //             })
               
    //             ->addColumn('edit', function ($expense) {
    //                 return $expense->slug;
    //             })
    //             ->addColumn('delete', function ($expense) {
    //                 return $expense->slug;
    //             })
    //             ->make(true);
    //     }

    //     $expenses = Expense::all();

    //     return view('dashboard.expenses.index' ,compact('expenses'));
    // }

    public function index(Request $request)
{
    $this->authorize('view', Expense::class);

    $expenses = Expense::paginate(10);

    return view('dashboard.expenses.index', compact('expenses'));
}


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Expense::class);
        $expense = new Expense();
        return view('dashboard.expenses.create', compact('expense'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Expense::class);
        $request->validate([
            'type' => 'required',
            'date' => 'nullable|date',
            'category' => 'required',
            'notes' => 'required',
            'amount' => 'required',
            'payment_status' => 'required',
            'payment_method' => 'required',
    
        ]);

        
        $expense = Expense::create($request->all());

        return redirect()->route('dashboard.expense.index')->with('success', __('Expense created successfully.'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
