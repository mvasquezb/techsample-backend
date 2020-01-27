<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Return password reset token to API client.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function getPasswordResetToken(Request $request)
    {
        $this->validateEmail($request);

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $response = $this->broker()->getPasswordResetToken(
            $this->credentials($request)
        );

        return $response['result'] == CustomPasswordBroker::RESET_TOKEN_CREATED
                    ? $this->createResetTokenResponse($request, $response)
                    : $this->createResetTokenFailedResponse($request, $response);
    }

    /**
     * Get the response for a successful password reset link.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  array  $response
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    protected function createResetTokenResponse(Request $request, $response)
    {
        return response()->json([
            'token' => $response['token'],
        ]);
    }

    /**
     * Get the response for a failed password reset link.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $response
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    protected function createResetTokenFailedResponse(Request $request, $response)
    {
        return response()->json([
            'errors' => trans($response['result'])
        ], 401);
    }

    /**
     * Get the broker to be used during password reset.
     *
     * @return \App\Http\Controllers\Auth\CustomPasswordBroker
     */
    public function broker()
    {
        return Password::broker();
    }
}
