<?php

namespace Mitul456\LaravelMultiRoleAuth\Events;

use Illuminate\Foundation\Events\Dispatchable;

class UserRegistered
{
    use Dispatchable;
    
    public $user;
    
    public function __construct($user)
    {
        $this->user = $user;
    }
}