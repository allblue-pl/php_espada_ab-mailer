<?php namespace EC\ABMailer;
defined('_ESPADA') or die(NO_ACCESS);

use E, EC;
use EC\Mailer\CMail;

abstract class CMailProcessor {
    abstract public function process(string $toMail, string $toName, 
            array $data): string|null;
}