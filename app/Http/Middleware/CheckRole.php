<?php
/**
 * Short description for file
 *
 * @FileName		CheckRole.php
 * @Created On		11/04/2021
 * @author			Nafees Ahmad
 * @copyright		2021-2022 The PHP Group
 * @license			http://www.php.net
 * @Description		Middleware CheckRole
 */
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
// First copy this file into your middleware directoy
use Auth;
class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next) {
		
		try {
            $userRole = auth()->user()->role;
            $currentRouteName = Route::currentRouteName();
            //echo 'userRole=' . $userRole.'<br>';
            //echo 'currentRouteName=' . $currentRouteName.'<br>';
            //exit;

            
            // dd($this->userAccessRole()[$userRole], $userRole, $currentRouteName);
            if (in_array($currentRouteName, $this->userAccessRole()[$userRole])) {
                return $next($request);
            } else {
                abort(403, 'You are not allowed to access this page.');
            }
        } catch (\Throwable $th) {
            abort(403, 'You are not allowed to access this page this.');
        }
	}
	
	/**
     * The list of accessible resources for a specific user.
     *
     * @return void
     */
	
	private function userAccessRole()
    {
        return [
            'User' => [
                'dashboard',
            ],
            'Admin' => [
                'getVikaskhand',
                'dashboard',
                'grievance',
                'grievanceDetails',
                'saveComments',
                'downloadFiles',
                'details',
                'fullDetails',
                'award-tracking.index',
                'search',
                'product.index',
                'product.create',
                'product.store',
                'create',
                'stampdutystatus',
                'awardStatus',
                'award-tracking/search',
                //'award-tracking.show',
                'unitDetails',
                'viewUnitDetails',
                'GoalWisePerformance',
                'avedan',
                'rejectApplication',
                'meritList',
                'generalList',
                'scstList',
                'waitingList',
                'meritAvedanDetails',
                'totalAvedan',
                'rejectedAvedan',
                'approvedAvedan',
                'allocation',
                'getAvedanData',
                'saveAllocation',
                'allocationList',
                'candidateNotJoined',
                'documentVerification',
                'saveDocumnetVerification',
                'editUploadAvedan',
                'avedanUpdated',
                'changePassword',
                'uploadDocuments',
                'changePasswordIndex',
                'changePasswordPost',
                'scList',
                'stList',
                'avedanStatus',
                'avedanUpdatedDocuments',
                'avedanFullDetails',
                'avedanDistrictwise',
                'export',
            ],
            
            'Superadmin' => [
				'institute.create',
                'institute.store',
                'institute.edit',
                'institute.update',
                'institute.index',
                'institute.destroy',
                'avedanFullDetails',
                
                'setting.create',
                'setting.store',
                'setting.edit',
                'setting.update',
                'setting.index',
                'setting.destroy',
                
                'dashboard',
                'grievance',
                'grievanceDetails',
                'saveComments',
                'downloadFiles',
                'details',
                'fullDetails',
                'award-tracking.index',
                'search',
                'product.index',
                'product.create',
                'product.store',
                'create',
                'stampdutystatus',
                'awardStatus',
                'award-tracking/search',
                //'award-tracking.show',
                'unitDetails',
                'viewUnitDetails',
                'GoalWisePerformance',
                'avedan',
                'rejectApplication',
                'meritList',
                'generalList',
                'scstList',
                'editAvedan',
                'avedanUpdated',
                'totalAvedan',
                'rejectedAvedan',
                'approvedAvedan',
                'candidateNotJoined',
                'changePassword',
                'changePasswordIndex',
                'changePasswordPost',
                'scList',
                'stList',
                'avedanStatus',
                'export',
                
            ],
            
            /*
            'Superadmin' => [
                'admin',
                'divisions.create',
                'divisions.store',
                'divisions.edit',
                'divisions.update',
                'divisions.index',
                'divisions.destroy',
                'districts.create',
                'districts.store',
                'districts.edit',
                'districts.update',
                'districts.index',
                'districts.destroy',
                'zones.create',
                'zones.store',
                'zones.edit',
                'zones.update',
                'zones.index',
                'zones.destroy',
                'contents.create',
                'contents.store',
                'contents.edit',
                'contents.update',
                'contents.index',
                'contents.destroy',
                'users.create',
                'users.store',
                'users.edit',
                'users.update',
                'users.index',
                'users.destroy',
                'status',
                'grievance',
                'details',
                'allDetails',
                'index',
                'downloadFiles',
                'qanswer.create',
                'qanswer.store',
                'qanswer.edit',
                'qanswer.update',
                'qanswer.index',
                'qanswer.destroy',
                'designation.create',
                'designation.store',
                'designation.edit',
                'designation.update',
                'designation.index',
                'designation.destroy',
                'office.create',
                'office.store',
                'office.edit',
                'office.update',
                'office.index',
                'office.destroy',
                'NodalOfficer.create',
                'NodalOfficer.store',
                'NodalOfficer.edit',
                'NodalOfficer.update',
                'NodalOfficer.index',
                'NodalOfficer.destroy',
                'showContents',
                
            ],*/
        ];
    }
	
	
	
	
	
	
	/**
     * The default user access role.
     *
     * @return void
     */
    private function defaultUserAccessRole()
    {
        return [
            'admin' => [
                'user-permissions',
            ],
        ];
    }
}
