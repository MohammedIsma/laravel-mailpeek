<?php
namespace Misma\MailPeek\Classes;

use File;

class eMailMessage
{
    protected $id;
    protected $timestamp;
    protected $from = [];
    protected $to = [];
    protected $cc = [];
    protected $bcc = [];
    protected $reply_to = [];
    protected $subject = [];
    protected $body = [];
    protected $attachments = [];
    protected $read = false;
    protected $files_path;
    protected $attachments_path;

    public function __construct($path, $id){
        $this->id = $id;
        $this->timestamp = time();
        $this->files_path = $path;

        $attachments_path = $this->files_path . "/" . $this->getID() . "/attachments/";
        File::makeDirectory($attachments_path, 0777, true);
    }

    public function getID(){ return $this->id; }
    public function getFrom(){ return $this->from["name"] . " <".$this->from["email"].">"; }
    public function getSubject(){ return $this->subject; }
    public function getTo(){ return $this->to; }
    public function getCC(){ return $this->cc; }
    public function getBCC(){ return $this->bcc; }
    public function getBody(){ return $this->body; }
    public function getAttachments(){ return $this->attachments; }
    public function isRead(){ return $this->read; }

    public function setSender($name, $email){
    	$this->from["name"] = $name;
    	$this->from["email"] = $email;
    }

    public function setBody($bod){ $this->body = $bod; }
    public function setSubject($subj){ $this->subject = $subj; }

    public function addTo($name, $email){ $this->to[] = ["name"=>$name, "email"=>$email]; }
    public function addAttachment($filename, $filepath){ $this->attachments[] = ["name"=>$filename, "email"=>$filepath]; }

    public function toArray(){
        $arr["id"] = $this->id;
        $arr["from"] = $this->from;
        $arr["to_primary"] = $this->to[0];
        $arr["to"] = $this->to;
        $arr["cc"] = $this->cc;
        $arr["bcc"] = $this->bcc;
        $arr["reply_to"] = $this->reply_to;
        $arr["subject"] = $this->subject;
        $arr["body"] = $this->body;
        $arr["attachments"] = $this->attachments;
        $arr["datetime"] = $this->get_pretty_datetime();
        $arr["attributes"] = [
                                "unread"=>!$this->read,
                                "read"=>$this->read
                            ];

        return $arr;
    }



    function get_pretty_datetime(){
        $time_difference = time() - $this->timestamp;

        if( $time_difference < 1 ) { return 'less than 1 second ago'; }
        $condition = array( 12 * 30 * 24 * 60 * 60 =>  'year',
                    30 * 24 * 60 * 60       =>  'month',
                    24 * 60 * 60            =>  'day',
                    60 * 60                 =>  'hour',
                    60                      =>  'minute',
                    1                       =>  'second'
        );

        foreach( $condition as $secs => $str )
        {
            $d = $time_difference / $secs;

            if( $d >= 1 )
            {
                $t = round( $d );
                return 'about ' . $t . ' ' . $str . ( $t > 1 ? 's' : '' ) . ' ago';
            }
        }
    }

    function setRead(){
        $this->read = true;
    }
}
