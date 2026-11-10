<?php

namespace App\Controllers\Invoker;

class InvokerController
{


    public function status(): array
    {
        return ["httpCode" => 200, "content" => "I am up and awaiting to your orders :P"];
    }

}