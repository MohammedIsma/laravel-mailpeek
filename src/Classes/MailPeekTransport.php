<?php 

namespace Misma\MailPeek\Classes;

use Session;
use Swift_Mime_SimpleMessage;

use Misma\MailPeek\Classes\eMailMessage;
use Misma\MailPeek\Classes\MailBox;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Mail\Transport\Transport;

class MailPeekTransport extends Transport
{
    protected $files;
    protected $Mailbox;

    private $files_path;


    public function __construct(Filesystem $files, $files_path, $iID)
    {
        $this->files = $files;
        $this->files_path = $files_path;
        $this->Mailbox = new Mailbox($iID, $files_path);
    }

    public function send(Swift_Mime_SimpleMessage $message, &$failedRecipients = null)
    {
        $this->beforeSendPerformed($message);
        
        $Mail = new eMailMessage($this->files_path, $message->getId());
        $Mail->setSubject($message->getSubject());
        $Mail->setBody($message->getBody());
        
        foreach ($message->getFrom() as $email => $name) {
            $Mail->setSender($name, $email);
        }

        foreach ($message->getTo() as $email => $name) {
            $Mail->addTo($name, $email);
        }

        foreach ($message->getChildren() as $child) {
            
            $cd = $child->getHeaders()->get('content-disposition');
            if($cd){
                $file_name = str_replace('attachment; filename=', null, $child->getHeaders()->get('content-disposition')->getFieldBody());
                $file_content = $child->getBody();
                $file_path = "$this->files_path/".$Mail->getId()."/attachments/$file_name";
                
                $this->files->put( $file_path, $file_content );
                
                $Mail->addAttachment($file_name, $file_path);
            }
        }

        $this->Mailbox->addEmailToMailbox($Mail);
    }

    

    protected function getMessageInfo(Swift_Mime_SimpleMessage $message)
    {
        return sprintf(
            "<!--\nFrom:%s, \nto:%s, \nreply-to:%s, \ncc:%s, \nbcc:%s, \nsubject:%s\n-->\n",
            json_encode($message->getFrom()),
            json_encode($message->getTo()),
            json_encode($message->getReplyTo()),
            json_encode($message->getCc()),
            json_encode($message->getBcc()),
            $message->getSubject()
        );
    }
}