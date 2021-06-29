<?php


namespace App\Classes;


use App\Models\Messages;
use App\Models\Requests;

class Channel
{
    private $questions = [];

    public function __construct($channel)
    {
        $this->channel = $channel;
        $this->questions = $channel->responder->questions()->orderby('order')->get();
        $this->responder = $channel->responder;
    }

    public function getNextQuestion($contact_id)
    {
        $requests = Requests::where(['contact_id' => $contact_id, 'channel_id' => $this->channel->id])->get();
        $messages = Messages::where(['contact_id' => $contact_id, 'channel_id' => $this->channel->id])->get();
        if ($requests->count() <= $messages->count()) {
            if (isset($this->questions[$requests->count()])) {
                Requests::create(['source'=>$this->responder->type,'source_id'=>$this->questions[$requests->count()]->id,'status'=>0,'channel_id'=>$this->channel->id,'contact_id'=>$contact_id,'responder_id'=>$this->responder->id]);
                return $this->questions[$requests->count()]->message;
            }
            return "thanks for your time we will contact you ASAP :)";
        }
//        if ($requests->count() <= $messages->count()) {
//            if (isset($this->questions[$requests->count() + 1])) {
//                return $this->questions[$requests->count() + 1]->message;
//            }
//        }
    }
}
