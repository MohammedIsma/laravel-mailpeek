<?php

namespace Misma\MailPeek\Classes;

use Misma\MailPeek\Classes\MailPeekTransport;

use Illuminate\Mail\TransportManager;

class MailPeekTransportManager extends TransportManager
{
    protected function createMPDriver()
    {
        $config = $this->app['config']->get('mailpeek', []);

        return new MailPeekTransport($this->guggle($config), $config['secret'], $config['domain'] );
    }

}