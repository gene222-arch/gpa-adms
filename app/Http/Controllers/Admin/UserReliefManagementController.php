<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserReliefManagementController extends Controller
{

    private $admin;
    private $superAdmin;
    private $user;

    /**
     * The Constructor instance will prevent non super-admin users to access this functionality
     *
     * @return void
     */
    public function __construct()
    {
        /**
         * ! Admin
         */
        $this->middleware(['role:super_admin', 'auth:admin']);
        $this->admin = new Admin;
        $this->superAdmin = $this->admin
            ->whereHas('roles', fn($q) => $q->where('name', 'super_admin'))->first();
        /**
         * ! User
         */
        $this->user = new User;
    }

    /**
     * Fetching Users who's role is volunteer and with relief assistance
     *
     * @param $request
     * @return JSON Response
     */
    public function showVolunteersWithReliefAsst(Request $request)
    {
        if ($request->wantsJson())
        {
            return response()->json($this->superAdmin->getUserWithReliefAssistance());
        }
        return view('admins.user-relief-assistance-mngmt.volunteer');
    }

    /**
     * Approving a user's/volunteers relief assistance
     *
     * @param $request
     * @return JSON
     */
    public function approveReliefAsst(Request $request)
    {
        if ($request->wantsJson())
        {
            /**
             * Todo
             * Notify the user that the relief goods that he/she created/sent was approve
             */
            $isApproved = $this->superAdmin->approveReliefAssistance($request->user_id, $request->relief_good_id);
            return response()->json(
            [
                'from' => 'Approve Relief Assistance Controller',
                'user_id' => $request->user_id,
                'relief_good_id' => $request->relief_good_id
            ], 200);
        }
    }

    /**
     * Disapproving a user's/volunteers relief assistance
     *
     * @param $request
     * @return JSON
     */
    public function disapproveReliefAsst(Request $request)
    {
        if ($request->wantsJson())
        {
            $isDisapproved = $this->superAdmin->disapproveReliefAssistance($request->user_id, $request->relief_good_id);
            return response()->json(
            [
                'from' => 'Disapprove Relief Assistance Controller',
                'user_id' => $request->user_id,
                'relief_good_id' => $request->relief_good_id
            ], 200);
        }
    }


    public function reliefAsstHasReceived(Request $request)
    {
        if ($request->wantsJson())
        {
            $isReceived = $this->superAdmin->reliefAsstHasReceived($request->user_id, $request->relief_good_id);
            $message = $isReceived ? 'The relief assistance has been received' : 'Approval is needed before collecting';
            $code = $isReceived ? 200 : 406;
            return response()->json(
            [
                'from' => 'Relief Has Receive Controller',
                'user_id' => $request->user_id,
                'relief_good_id' => $request->relief_good_id,
                'message' => $message,
            ], $code);
        }
    }

    public function relieveReceivedReliefAsst(Request $request)
    {
        if ($request->wantsJson())
        {
            $isRelieved = $this->superAdmin->relieveReceivedReliefAsst($request->user_id, $request->relief_good_id);
            $message = $isRelieved ? 'Success' : 'Approval is needed before collecting';
            $code = $isRelieved ? 200 : 406;
            return response()->json([
                'from' => 'Remove A Received Relief Asst',
                'user_id' => $request->user_id,
                'relief_good_id' => $request->relief_good_id,
                'message' => $message,
            ], $code);
        }
    }


    /**
     * Removing a user's/volunteers relief assistance
     *
     * @param $request
     * @return JSON
     */
    public function removeReliefAsst(Request $request)
    {
        if ($request->wantsJson())
        {
            $isRemoved = $this->superAdmin->removeReliefAssistanceOf($request->user_id, $request->relief_good_id);
            return response()->json([
                'from' => 'Remove Relief Assistance Controller',
                'user_id' => $request->user_id,
                'relief_good_id' => $request->relief_good_id
            ], 200);
        }
    }

}
