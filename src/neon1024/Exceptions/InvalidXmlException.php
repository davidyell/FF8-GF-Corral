<?php

/**
 * InvalidXmlException.php
 *
 * @author David Yell <neon1024@gmail.com>
 */

namespace neon1024\FF8Corral\Exceptions;

class InvalidXmlException extends \Exception
{
    protected $message = 'Cannot load XML';
}
