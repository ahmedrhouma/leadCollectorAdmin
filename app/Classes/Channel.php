<?php


namespace App\Classes;


use App\Models\Messages;
use App\Models\Requests;
use Illuminate\Support\Facades\Validator;
use Monarobase\CountryList\CountryList;

class Channel
{
    private $questions = [];
    private $error = "";
    private $replies = [];

    public function __construct($channel)
    {
        $this->channel = $channel;
        $this->questions = $channel->responder->questions()->orderby('order')->get();
        $this->responder = $channel->responder;
    }

    public function getNextQuestion($contact_id)
    {
        $requests = Requests::where(['contact_id' => $contact_id, 'channel_id' => $this->channel->id])->get();
        //$messages = Messages::where(['contact_id' => $contact_id, 'channel_id' => $this->channel->id])->get();
        $unrepliedRequest = $requests->where('status', 0)->first();
        if ($this->error != "") {
            $this->replies[] = $this->error;
        }
        if ($unrepliedRequest) {
            $this->replies[] = $this->questions[array_search($unrepliedRequest->toArray(), $requests->toArray())]->message;
            return $this->replies;
        } else
            if (isset($this->questions[$requests->count()])) {
                Requests::updateOrCreate(['channel_id' => $this->channel->id, 'contact_id' => $contact_id, 'responder_id' => $this->responder->id, 'source' => $this->responder->type, 'source_id' => $this->questions[$requests->count()]->id, 'status' => $this->questions[$requests->count()]->response == 0 ? 1 : 0]);
                $this->replies[] = $this->questions[$requests->count()]->message;
                if ($this->questions[$requests->count()]->response == 0) {
                    $this->getNextQuestion($contact_id);
                }
                return $this->replies;
            }
        return ["thanks for your time we will contact you ASAP :)"];
    }


    /**
     * @param $profile
     * @param $message
     * @return bool
     */
    public function validate($profile, $message)
    {
        $requests = Requests::where(['contact_id' => $profile->contact_id, 'channel_id' => $this->channel->id])->get();
        if (count($requests) !== 0) {
            $field = $this->questions[$requests->count() - 1]->field()->first();
            $validator = Validator::make([$field->tag => $message], [$field->tag => $field->format]);
            if ($field->tag == "email" && !$this->verifyEmail($message)) {
                $this->replies[] = "Email does not exist :( ! please set a valid email.";
                return false;
            }
            if ($validator->fails()) {
                $this->replies = $validator->errors()->all();
                return false;
            }
            if (array_key_exists($field->tag,$profile->getAttributes())) {
                $profile->update([$field->tag => $message]);
            }
            if (array_key_exists($field->tag,$profile->contact->getAttributes())) {
                $profile->contact->update([$field->tag => $message]);
            }
            $requests->where('status', 0)->first()->update(['status' => 1]);
            return true;
        }
        return false;
    }

    public function verifyEmail($email)
    {
        $vmail = new \App\Classes\VerifyEmail();
        $vmail->setStreamTimeoutWait(20);
        $vmail->Debug = TRUE;
        $vmail->Debugoutput = 'html';
        $vmail->setEmailFrom('ahmedweldrhouma@gmail.com');
        if ($vmail->check($email)) {
            return true;
        } else {
            return false;
        }
    }
}
