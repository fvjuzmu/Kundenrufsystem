<?php
/**
 * Converts an Exception into a JSON response message
 *
 * @param Exception $exception
 *
 * @return string
 */
function convertExceptionIntoNotification($exception)
{
    $message = "<b>" . $exception->getMessage() . "</b><br>" . $exception->getFile() . "(" . $exception->getLine() . ")" . "<br>"
        . $exception->getTraceAsString() . "<br>" . $exception->getPrevious();

    return newNotification("error", $message);
}

/**
 * Returns a JSON response message
 *
 * @param $type
 * @param $message
 *
 * @return string
 */
function newNotification($type, $message)
{
    $notification[ "type" ] = $type;
    $notification[ "message" ] = $message;

    return json_encode([ "notifications" => [ $notification ] ]);
}
