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
    public function index(Request $request)
    {
        $this->authorize('view', Expense::class);
        $expenses = Expense::orderBy('id', 'desc')->paginate(10);
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
            'type' => 'required|in:يومية,شهرية',
            'date' => 'nullable|date',
            'category' => 'required',
            'notes' => 'nullable|string',
            'amount' => 'required|numeric|min:0',
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
        $this->authorize('edit', Expense::class);
        $expense = Expense::findOrFail($id);
        $btn_label = "تعديل";
        return view('dashboard.expenses.edit', compact('expense','btn_label'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->authorize('edit', Expense::class);
        $request->validate([
            'type' => 'required|in:يومية,شهرية',
            'date' => 'nullable|date',
            'category' => 'required',
            'notes' => 'nullable|string',
            'amount' => 'required|numeric|min:0',
            'payment_status' => 'required',
            'payment_method' => 'required',
        ]);
        $expense = Expense::findOrFail($id);
        $expense->update($request->all());
        return redirect()->route('dashboard.expense.index')->with('success', __('Expense updated successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->authorize('delete', Expense::class);
        $expense = Expense::findOrFail($id);
        $expense->delete();
        return redirect()->route('dashboard.expense.index')->with('success', __('Expense deleted successfully.'));
    }
}
