<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCompanyRequest;
use App\Http\Resources\CompanyResource;
use App\Jobs\ProcessCompanyManager;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class CompanyController extends Controller implements HasMiddleware
{
    /**
     * Get the middleware that should be assigned to the controller.
     */
    public static function middleware(): array
    {
        return [
            new Middleware('auth:api', only: ['index', 'store', 'destroy']),
        ];
    }

    /**
     * Display a listing of records.
     */
    public function index(Request $request)
    {
        $data = Company::where('name', 'like', '%' . $request->search . '%')
            ->orderBy($request->sortBy ?? 'id', $request->order ?? 'asc')
            ->paginate();

        return CompanyResource::collection($data);
    }

    /**
     * Store a newly created record.
     */
    public function store(StoreCompanyRequest $request)
    {
        $companyData = $request->safe()->only(['name', 'email', 'phone']);
        $managerData = $request->safe()->only(['manager']);

        $company = new Company();
        $company->name = $companyData['name'];
        $company->email = $companyData['email'];
        $company->phone = $companyData['phone'];
        $company->save();

        ProcessCompanyManager::dispatch($company, $managerData['manager']);

        return response()->json([
            'message' => 'The company has been created.',
            'data' => new CompanyResource($company)
        ], 201);
    }

    /**
     * Remove the specified record.
     */
    public function destroy(Company $company)
    {
        $company->delete();

        return response()->json([
            'message' => 'The company has been deleted.',
        ]);
    }
}
