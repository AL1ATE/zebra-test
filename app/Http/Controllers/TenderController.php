<?php

namespace App\Http\Controllers;

use App\Models\Tender;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Requests\StoreTenderRequest;

class TenderController extends Controller
{
    public function actionList(Request $request): JsonResponse
    {
        $query = Tender::query();

        if ($request->filled('name')) {
            $query->where('name', 'ilike', '%' . $request->name . '%');
        }

        if ($request->filled('date')) {
            $query->whereDate('updated_at_original', $request->date);
        }

        return response()->json($query->get());
    }

    public function actionShow($id): JsonResponse
    {
        return response()->json(Tender::findOrFail($id));
    }

    public function actionStore(StoreTenderRequest $request): JsonResponse
    {
        $tender = Tender::create($request->validated());
        return response()->json($tender, 201);
    }
}
