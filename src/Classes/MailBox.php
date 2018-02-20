<?php

namespace Misma\MailPeek\Classes;

use Config;
use File;
use Session;

use Misma\MailPeek\Classes\eMailMessage;
use Misma\MailPeek\Classes\PeekFilesystem as PFS;

class MailBox
{
    protected $iID;
    protected $MBOX;

    public function __construct($iID, $path=null){
        $this->iID = $iID;
        $this->cleanMailPeekBoxFiles();
        $this->MBOX = $this->getMailBox($iID);
    }

    private function getMailBox($id){
        $box = session("mailpeek_box");
        return isset($box[$id]) ? $box[$id] : $this->createMailBox($id);
    }

    private function createMailBox($id){
        $dir = Config::get("mailpeek.files_path") . $id;
        if(!file_exists($dir)){
            File::makeDirectory($dir, 0777, true);
        }
        
        session::put("mailpeek_box", [$id => ["messages"=>[]]]);
        $box = session("mailpeek_box");
        $this->MBOX = $box[$id];
    }

    public function addEmailToMailbox(eMailMessage $message){
        $box = session("mailpeek_box");
        $box[$this->iID]["messages"][] = $message;

        session(['mailpeek_box' => $box]);
    }


    // TODO: There's a better more efficient way
    public function getUnreadCount(){
        $count = 0;
        if(!isset($this->MBOX["messages"])){
            return $response;
        }
        foreach($this->MBOX["messages"] as $m){
            if(!$m->isRead()){
                $count++;
            }
        }

        return $count;

    }

    public function getAllMessages(){
        $response = [];
        if(!isset($this->MBOX["messages"])){
            return $response;
        }
        foreach($this->MBOX["messages"] as $m){
            $response[] = $m->toArray();
        }

        $response = array_reverse($response);

        return $response;

    }

    public function getSingleMessage($id){

        $index = $this->getMessageIndex($id);

        if(!($index === null)){
            $Message = $this->MBOX["messages"][$index];
            $this->markMessageRead($index);
            return $Message;
        }else{
            return null;
        }
            

    }

    public function getMessageIndex($id){

        $m_index = null;
        foreach($this->MBOX["messages"] as $k=>$M) {
            if ($M->getID() == $id) {
                $m_index = $k;
                break;
            }
        }

        return ($m_index === null) ? false : $m_index;
    }

    private function markMessageRead($index){
        $marked = $this->MBOX['messages'][$index];
        $marked->setRead();

        $this->MBOX["messages"][$index] = $marked;
        session::put("mailpeek_box", [$this->iID => $this->MBOX]);
    }


    public function cleanMailPeekBoxSession(){
        session(['mailpeek_box' => []]);
        $this->cleanMailPeekBoxFiles();
    }

    protected function cleanMailPeekBoxFiles(){
        $pfs = new PFS();
        $pfs->cleanDirectoryExcept(Config::get("mailpeek.files_path"),[$this->iID]);
    }

}