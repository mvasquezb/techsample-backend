<?php

namespace App\Http\Controllers;

use App\Filters\UserFilters;
use App\User;
use App\UserType;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Display user's dashboard
     * 
     * @param \Illuminate\Http\Request $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function dashboard(Request $request)
    {
        $userType = $request->user()->userType;
        return response()->json([
            'data' => $this->buildDefaultDashboard($request, $userType),
        ]);
    }

    /**
     * Build default user dashboard
     * 
     * @param \Illuminate\Http\Request
     * 
     * @return array
     */
    private function buildDefaultDashboard(Request $request, UserType $userType) {
        return $userType == UserType::developer()
                        ? $this->buildDefaultDevDashboard($request)
                        : $this->buildDefaultPlayerDashboard($request);
    }

    /**
     * Build default player dashboard
     * 
     * @param \Illuminate\Http\Request
     * 
     * @return array
     */
    private function buildDefaultPlayerDashboard(Request $request)
    {
        $user = $request->user();
        $input = $request->all();

        $developers = $this->buildDeveloperList($request);

        return [
            'developers' => $developers,
        ];
    }
    
    /**
     * Build default developer dashboard
     * 
     * @param \Illuminate\Http\Request
     * 
     * @return array
     */
    private function buildDefaultDevDashboard(Request $request)
    {
        $user = $request->user();
        $input = $request->all();

        $total = $this->buildUsersCount($request);
        $byCountry = $this->buildByCountry($request);
        $byGender = $this->buildByGender($request);
        $developers = $this->buildDeveloperList($request);

        return [
            'total' => $total,
            'byCountry' => $byCountry,
            'byGender' => $byGender,
            'developers' => $developers,
        ];
    }

    private function buildUsersCount(Request $request)
    {
        $filters = ['count' => true];
        return $this->applyFilters($request, $filters);
    }

    private function buildByCountry(Request $request)
    {
        $filters = ['byCountry' => true];
        return $this->applyFilters($request, $filters);
    }

    private function buildByGender(Request $request)
    {
        $filters = ['byGender' => true];
        return $this->applyFilters($request, $filters);
    }

    private function buildDeveloperList(Request $request)
    {
        $filters = ['type' => UserType::developer()];
        return $this->applyFilters($request, $filters);
    }

    private function applyFilters(Request $request, array $params)
    {
        $request->replace($params);
        $filters = new UserFilters($request);
        return User::filter($filters)->get();
    }

    /**
     * Update a user's report
     * 
     * @param \Illuminate\Http\Request $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
    }
}
