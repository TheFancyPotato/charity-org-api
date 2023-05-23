<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Invoice\StoreInvoiceRequest;
use App\Http\Requests\Invoice\UpdateInvoiceRequest;
use App\Http\Resources\InvoiceResource;
use App\Models\Invoice;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', Invoice::class);

        return InvoiceResource::collection(Invoice::query()->paginate(
            perPage: request('perPage'),
            page: request('page'),
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreInvoiceRequest $request)
    {
        $invoice = Invoice::create($request->validated() + [
            'date' => now(),
            'user_id' => auth()->id(),
        ]);

        return (new InvoiceResource($invoice))->response()->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Invoice $invoice)
    {
        $this->authorize('view', $invoice);

        return new InvoiceResource($invoice);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateInvoiceRequest $request, Invoice $invoice)
    {
        $invoice->update($request->validated());

        return new InvoiceResource($invoice);
    }

    /**
     * Move the specified resource to trash.
     */
    public function destroy(Invoice $invoice)
    {
        $this->authorize('delete', $invoice);

        $invoice->delete();

        return response(status: 204);
    }

    /**
     * Restore the specified resource from trash.
     */
    public function restore(int $invoice)
    {
        $invoice = Invoice::onlyTrashed()->findOrFail($invoice);

        $this->authorize('restore', $invoice);

        $invoice->restore();

        return response(status: 204);
    }

    /**
     * Delete the specified resource from storage.
     */
    public function forceDelete(int $invoice)
    {
        $invoice = Invoice::onlyTrashed()->findOrFail($invoice);

        $this->authorize('forceDelete', $invoice);

        $invoice->forceDelete();

        return response(status: 204);
    }
}
