<?php

use App\Jobs\AdminNotifyEmailJob;
use App\Jobs\UserNotifyEmailJob;
use App\Services\SMSService;

/**
 * @param array 
 * - 'email': The email address of the recipient.
 * - 'name': The name of the recipient.
 * - 'type': The type of recipient ('User' or 'Admin').
 *
 * @return A JSON response indicating that the email has been queued.
 */
function sendEmail($requestParams)
{
    $emailData = [
        'to' => $requestParams['email'],
        'name' => $requestParams['name'],
    ];

    if ($requestParams['type'] == 'User') {
        UserNotifyEmailJob::dispatch($emailData);
    } else {
        AdminNotifyEmailJob::dispatch($emailData);
    }

    return response()->json(['message' => 'Email has been queued.']);
}

/**
 * @param array
 * - 'phone_number': The recipient's phone number.
 * - 'message': The content of the SMS message.
 *
 * @return A JSON response containing the result of the SMS sending operation.
 */
function sendSMS($requestParams)
{
    $to = $requestParams['phone_number'];
    $message = $requestParams['message'];

    $smsService = app(SMSService::class);
    $response = $smsService->sendSMS($to, $message);

    return response()->json($response);
}
