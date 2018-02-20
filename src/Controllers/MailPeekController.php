<?php
namespace Misma\MailPeek\Controllers;

use Config;
use Session;
use Response;
use Misma\MailPeek\Classes\MailBox;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class MailPeekController extends BaseController
{
	public function test(){
    	
    	$box = session("mailpeek_box");
    	// dd($box);

    	return view("laravel-mailpeek::layout");
    }

    public function get_mailbox_data(){
    	$peekInstanceID = substr(md5(session()->getId()),0,16);
    	$Mailbox = new Mailbox($peekInstanceID);
		
        $response["messages"] = $Mailbox->getAllMessages();
		$response["meta"] = [
                                "unread_count" => $Mailbox->getUnreadCount()
                            ];

    	return json_encode($response);
    }

    public function display_message($id){

    	$peekInstanceID = substr(md5(session()->getId()),0,16);
    	$Mailbox = new Mailbox($peekInstanceID);
    	
    	$Msg = $Mailbox->getSingleMessage($id);

		if($Msg){
			return view("laravel-mailpeek::message")->with(["Message"=>$Msg]);
		}else{
			echo "Can not find message";
		}
    }

    public function download_file($message_id, $file_name){
        $peekInstanceID = substr(md5(session()->getId()),0,16);
        $Mailbox = new Mailbox($peekInstanceID);

        $file = Config::get("mailpeek.files_path") . "$peekInstanceID/$message_id/attachments/$file_name";

        if(file_exists($file)){
            return Response::download($file);
        }

        return redirect()->back();
    }

    public function empty_mailbox(){
        $peekInstanceID = substr(md5(session()->getId()),0,16);
        $Mailbox = new Mailbox($peekInstanceID);
        $Mailbox->cleanMailPeekBoxSession();

    }
}
