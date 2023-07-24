<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\InvoiceResource;
use App\Models\Family;

class FamilyInvoicesController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Family $family)
    {
        $this->authorize('view', $family);

        return InvoiceResource::collection($family->invoices()->with('user:id,name,username')->orderBy('id', 'desc')->paginate(30));
    }
}
