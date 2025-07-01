<?php

namespace App\Http\Controllers;

use App\Models\Tender;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\StoreTenderRequest;
use App\Http\Requests\TenderFilterRequest;

class TenderController extends Controller
{
    /**
     * @group Tenders
     *
     * Получить список тендеров
     *
     * Возвращает список тендеров с возможностью фильтрации по названию и дате.
     *
     * @queryParam name string Фильтр по названию. Example: оборудование
     * @queryParam date date Дата в формате YYYY-MM-DD. Example: 2024-07-01
     * @authenticated
     *
     * @response 200 scenario="Успешно" [{
     *   "id": 1,
     *   "external_code": 152467180,
     *   "number": "17660-2",
     *   "status": "Закрыто",
     *   "name": "Лабораторная посуда",
     *   "updated_at_original": "2022-08-14 19:25:14",
     *   "created_at": "2025-07-01T12:00:00Z",
     *   "updated_at": "2025-07-01T12:00:00Z"
     * }]
     */
    public function actionList(TenderFilterRequest $request): JsonResponse
    {
        $query = Tender::query();

        if ($request->filled('name')) {
            $query->where('name', 'ilike', '%' . $request->input('name') . '%');
        }

        if ($request->filled('date')) {
            $query->whereDate('updated_at_original', $request->input('date'));
        }

        return response()->json($query->get());
    }

    /**
     * @group Tenders
     *
     * Получить информацию о тендере
     *
     * Возвращает данные одного тендера по его ID.
     *
     * @urlParam id integer required ID тендера. Example: 1
     * @authenticated
     *
     * @response 200 scenario="Успешно" {
     *   "id": 1,
     *   "external_code": 152467180,
     *   "number": "17660-2",
     *   "status": "Закрыто",
     *   "name": "Лабораторная посуда",
     *   "updated_at_original": "2022-08-14 19:25:14",
     *   "created_at": "2025-07-01T12:00:00Z",
     *   "updated_at": "2025-07-01T12:00:00Z"
     * }
     */
    public function actionShow(int $id): JsonResponse
    {
        $tender = Tender::findOrFail($id);
        return response()->json($tender);
    }

    /**
     * @group Tenders
     *
     * Создать новый тендер
     *
     * Создаёт новый тендер в системе.
     *
     * @bodyParam external_code integer required Внешний код. Example: 152467180
     * @bodyParam number string required Номер. Example: 17660-2
     * @bodyParam status string required Статус. Example: Закрыто
     * @bodyParam name string required Название. Example: Лабораторная посуда
     * @bodyParam updated_at_original datetime required Дата в формате Y-m-d H:i:s. Example: 2024-07-01 12:00:00
     * @authenticated
     *
     * @response 201 scenario="Успешно" {
     *   "id": 1,
     *   "external_code": 152467180,
     *   "number": "17660-2",
     *   "status": "Закрыто",
     *   "name": "Лабораторная посуда",
     *   "updated_at_original": "2022-08-14 19:25:14",
     *   "created_at": "2025-07-01T12:00:00Z",
     *   "updated_at": "2025-07-01T12:00:00Z"
     * }
     */
    public function actionStore(StoreTenderRequest $request): JsonResponse
    {
        $tender = Tender::create($request->validated());
        return response()->json($tender, 201);
    }
}
