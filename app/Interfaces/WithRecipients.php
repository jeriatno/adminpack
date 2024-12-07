<?php

namespace App\Interfaces;

interface WithRecipients
{
    public function setRecipients($data, $action, $config, $refId = null): array;
}
