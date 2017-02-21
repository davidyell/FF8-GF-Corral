<?php

/**
 * InvalidXmlException.php
 *
 * @author David Yell <neon1024@gmail.com>
 */

namespace neon1024\Exceptions;

class InvalidXmlException extends \Exception
{
    protected $message = 'Cannot load XML';
}
