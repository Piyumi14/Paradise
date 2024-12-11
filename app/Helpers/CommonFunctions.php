<?php

use App\Jobs\AdminNotifyEmailJob;
use App\Jobs\UserNotifyEmailJob;

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
