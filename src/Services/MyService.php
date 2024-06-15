<?php

namespace App\Services;

class MyService
{
    public function __construct(readonly EmailService $emailService)
    {
    }

    final public function execute(string $name, string $mail): null|string
    {
        return $this
            ->emailService
            ->setSubject("Sent to $name")
            ->setHtml("Sent to <b>$name</b>.")
            ->setText("Sent to $name.")
            ->setTo([$mail])
            ->send()
        ;
    }
}