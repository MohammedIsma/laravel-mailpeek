<?php

namespace Misma\MailPeek;

use Session;
use Swift_Mailer;

use Misma\MailPeek\Classes\MailPeekTransport;
use Misma\MailPeek\Classes\MailPeekTransportManager;

use Illuminate\Mail\MailServiceProvider;

class MailPeekMailProvider extends MailServiceProvider
{
    function registerSwiftMailer()
    {
        if ( 
            ($this->app['config']['mail.driver'] == 'mailpeek') && 
            ($this->app['config']['mailpeek.enabled'] == true) && 
            in_array( env("APP_ENV") , $this->app['config']['mailpeek.enabled_environments'])
        ){
            $this->registerPreviewSwiftMailer();
        } else {
            parent::registerSwiftMailer();
        }
    }
    /**
     * Register the Preview Swift Mailer instance.
     *
     * @return void
     */
    protected function registerPreviewSwiftMailer()
    {
        $PeekInstanceID = substr(md5(session()->getId()), 0, 16);
        
        $this->app->singleton('swift.mailer', function($app) use($PeekInstanceID) {
            return new Swift_Mailer( new MailPeekTransport(
                                        $app->make('Illuminate\Filesystem\Filesystem'),
                                        $app['config']['mailpeek.files_path'] . $PeekInstanceID,
                                        $PeekInstanceID
                                    ));
        });
    }
}
