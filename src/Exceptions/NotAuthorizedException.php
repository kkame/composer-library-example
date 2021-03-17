<?php

declare(strict_types=1);

namespace Kkame\ModernPug\Exceptions;

use Exception;

class NotAuthorizedException extends Exception
{
    protected $message = "인증이 실패하였습니다";

}