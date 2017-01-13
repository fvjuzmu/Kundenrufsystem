<?php
namespace FVJUZ\Kundenrufsystem\Exceptions;

use Exception;

class FVDBDeleteFailed extends Exception
{
    /**
     * FVDBDeleteFailed constructor.
     *
     * @param Exception|null $previous Previous caught exception
     */
    public function __construct(Exception $previous = null)
    {
        $msg = "Löschen der Daten fehlgeschlagen.";

        parent::__construct($msg, 203, $previous);
    }
}
