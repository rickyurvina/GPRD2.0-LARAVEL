<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;

class DepartmentHasUsersException extends Exception
{
    public function __construct()
    {
        parent::__construct(trans('departments.messages.exceptions.disabled_parent'));
    }
}
