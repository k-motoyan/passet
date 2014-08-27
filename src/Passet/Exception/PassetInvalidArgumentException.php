<?php

namespace Passet\Exception;

class PassetInvalidArgumentException extends \InvalidArgumentException implements PassetExceptionMarker
{
    /** @const message when an argument should be a string. */
    const MESSAGE_ARGUMENT_SHOUD_BE_STRING = 'argument should be string.';

    /** @const message when an argument should be a positive integer. */
    const MESSAGE_ARGUMENT_SHOUL_BE_POSITIVE_INTEGER = 'argument should be positive integer.';
}
