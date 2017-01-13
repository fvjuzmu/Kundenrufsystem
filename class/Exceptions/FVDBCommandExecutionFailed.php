<?php
namespace FVJUZ\Kundenrufsystem\Exceptions;

use Exception;

class FVDBCommandExecutionFailed extends Exception
{
    /**
     * FVDBCommandExecutionFailed constructor.
     *
     * @param Exception|null $previous Previous caught exception
     */
    public function __construct(Exception $previous = null)
    {
        $msg = "There was an error with the execution of the database command.";

        parent::__construct($msg, 200, $previous);
    }
}
