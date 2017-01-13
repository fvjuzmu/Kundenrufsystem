<?php
namespace FVJUZ\Kundenrufsystem\Exceptions;

use Exception;

class FVDBConnectionFailed extends Exception
{
    /**
     * FVDBIncrementNextIDFailed constructor.
     *
     * @param Exception|null $previous Previous caught exception
     */
    public function __construct(Exception $previous = null)
    {
        parent::__construct("No DB connection found.", 201, $previous);
    }
}
