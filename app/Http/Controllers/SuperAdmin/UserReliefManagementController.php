<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Models\User;
use App\Models\Admin;
use App\Models\ReliefGood;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserReliefManagementController extends Controller
{

    private $admin;

    /**
     * Undocumented function
     *
     * @param Admin $admin
     */
    public function __construct(Admin $admin)
    {
        $this->middleware(['role:super_admin', 'auth:admin']);
        $this->admin = $admin;
    }

    /**
     * Undocumented function
     *
     * @param Request $request
     * @return void
     */
    public function showVolunteersWithReliefAsst(Request $request)
    {
        if ($request->wantsJson())
        {
            return response()->json($this->admin->superAdmin()->getUsersWithReliefAssistance(), 200);
        }

        return view('admins.super-admin.user-relief-assistance-mngmt.volunteer');
    }

    /**
     * Undocumented function
     *
     * @param Request $request
     * @return void
     */
    public function approveReliefAsst(Request $request)
    {
        if ($request->wantsJson())
        {
            $isApproved = $this->admin
                                ->superAdmin()
                                ->approveReliefAssistance($request->user_id, $request->relief_good_id);

            $message = $this->prepareMessageResponse(
                $isApproved,
                'Success',
                'Failed'
            );

            $code = $this->prepareCodeResponse(
                $isApproved,
                200,
                422
            );
            return response()->json(
            [
                'from' => 'Approve Relief Assistance Controller',
                'user_id' => $request->user_id,
                'relief_good_id' => $request->relief_good_id,
                'message' => $message
            ], $code);
        }
    }

    /**
     * Undocumented function
     *
     * @param Request $request
     * @return void
     */
    public function disapproveReliefAsst(Request $request)
    {
        if ($request->wantsJson())
        {
            $isDisapproved = $this->admin
                                    ->superAdmin()
                                    ->disapproveReliefAssistance($request->user_id, $request->relief_good_id);

            $message = $this->prepareMessageResponse(
                $isDisapproved,
                'Success',
                'This relief assistance was already receive, disapproval is invalid'
            );

            $code = $this->prepareCodeResponse(
                $isDisapproved,
                200,
                422
            );

            return response()->json(
            [
                'from' => 'Disapprove Relief Assistance Controller',
                'user_id' => $request->user_id,
                'relief_good_id' => $request->relief_good_id,
                'message' => $message
            ], $code);
        }
    }

    /**
     * Undocumented function
     *
     * @param Request $request
     * @return void
     */
    public function reliefAsstHasReceived(Request $request)
    {
        if ($request->wantsJson())
        {
            $isReceived = $this->admin
                                ->superAdmin()
                                ->reliefAsstHasReceived($request->user_id, $request->relief_good_id);

            $message = $this->prepareMessageResponse(
                $isReceived,
                'The relief assistance has been received',
                'Approval is needed before collecting'
            );

            $code = $this->prepareCodeResponse(
                $isReceived,
                200,
                406
            );

            return response()->json(
            [
                'from' => 'Relief Has Receive Controller',
                'user_id' => $request->user_id,
                'relief_good_id' => $request->relief_good_id,
                'message' => $message,
            ], $code);
        }
    }

    /**
     * Undocumented function
     *
     * @param Request $request
     * @return void
     */
    public function relieveReceivedReliefAsst(Request $request)
    {
        if ($request->wantsJson())
        {
            $isRelieved = $this->admin
                                ->superAdmin()
                                ->relieveReceivedReliefAsst($request->user_id, $request->relief_good_id);

            $message = $this->prepareMessageResponse(
                $isRelieved,
                'Success',
                'Approval is needed before collecting'
            );

            $code = $this->prepareCodeResponse(
                $isRelieved,
                200,
                406
            );

            return response()->json([
                'from' => 'Remove A Received Relief Asst',
                'user_id' => $request->user_id,
                'relief_good_id' => $request->relief_good_id,
                'message' => $message,
            ], $code);
        }
    }

    /**
     * Undocumented function
     *
     * @param Request $request
     * @return void
     */
    public function dispatchReliefAsst(Request $request)
    {

        if ($request->wantsJson())
        {
            $userId = $request->user_id;
            $reliefGoodId = $request->relief_good_id;
            $recipientId = $request->recipient_id;
            $dispatchDate = $request->dispatched_at;

            $isDispatched = $this->admin
                                ->superAdmin()
                                ->dispatchReliefAsstOf($userId, $reliefGoodId, $recipientId, $dispatchDate);

            $message = $this->prepareMessageResponse(
                $isDispatched,
                'The relief assistance has been dispatch',
                'Approval and Collecting of the Relief Assistance are needed before dispatching'
            );

            $code = $this->prepareCodeResponse(
                $isDispatched,
                200,
                406
            );

            $this->admin->onDispatchReliefAsstEvent(
                $isDispatched,
                User::find($userId),
                User::find($recipientId),
                ReliefGood::find($reliefGoodId)
            );

            return response()->json(
            [
                'from' => 'Dispatch Relief Assistance',
                'user_id' => $userId,
                'relief_good_id' => $reliefGoodId,
                'message' => $message,
            ], $code);
        }

    }

    /**
     * Undocumented function
     *
     * @param Request $request
     * @return void
     */
    public function undispatchReliefAsst(Request $request)
    {

        if ($request->wantsJson())
        {
            $userId = $request->user_id;
            $reliefGoodId = $request->relief_good_id;
            $recipientId = $request->recipient_id;

            $isDispatched = $this->admin
                                ->superAdmin()
                                ->undispatchReliefAsstOf($userId, $reliefGoodId, $recipientId);

            $message = $this->prepareMessageResponse(
                $isDispatched,
                'Success',
                'Fail'
            );

            $code = $this->prepareCodeResponse(
                $isDispatched,
                200,
                406
            );

            $this->admin->onUndispatchReliefAsstEvent(
                $isDispatched,
                User::find($userId),
                User::find($recipientId),
                ReliefGood::find($reliefGoodId)
            );

            return response()->json(
            [
                'from' => 'Undispatch Relief Assistance',
                'user_id' => $userId,
                'relief_good_id' => $reliefGoodId,
                'message' => $message,
            ], $code);
        }

    }


    /**
     * Undocumented function
     *
     * @param Request $request
     * @return void
     */
    public function removeReliefAsst(Request $request)
    {
        if ($request->wantsJson())
        {
            $userId = $request->user_id;
            $reliefGoodId = $request->relief_good_id;
            $recipientId = $request->recipient_id;

            $isReliefAsstRemoved = $this->admin
                ->superAdmin()
                ->removeReliefAssistanceOf($userId, $reliefGoodId);

            $this->admin
                ->onRemoveReliefAsstEvent(
                    $isReliefAsstRemoved,
                    User::find($userId),
                    User::find($recipientId),
                    ReliefGood::find($reliefGoodId)
                );


            return response()->json([
                'from' => 'Remove Relief Assistance Controller',
                'user_id' => $userId,
                'relief_good_id' => $reliefGoodId
            ], 200);
        }
    }

    /**
     * Undocumented function
     *
     * @param [type] $boolean
     * @param string $successMessage
     * @param string $errorMessage
     * @return void
     */
    public function prepareMessageResponse($boolean, string $successMessage, string $errorMessage)
    {
        return $boolean ? $successMessage : $errorMessage;
    }

    public function prepareCodeResponse($boolean, int $successCode, int $errorCode)
    {
        return $boolean ? $successCode : $errorCode;
    }

}
