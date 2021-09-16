<?php


namespace App\Classes;


use App\Helper\Countries;
use App\Models\Messages;
use App\Models\Requests;
use Hashids\Hashids;
use Illuminate\Support\Facades\Validator;

class Channel
{
    private $questions = [];
    private $error = "";
    private $replies = ["suggestions" => array(), "messages" => array()];

    public function __construct($channel)
    {
        $this->channel = $channel;
        $this->responder = $channel->responder;
        if ($this->responder->type == 1) {
            $this->questions = $this->channel->responder->questions()->orderby('order')->get();
        }
    }

    /**
     * @param $profile
     * @return array|void
     */
    public function getNextQuestion($profile)
    {
        if ($this->responder->type == 1) {
            $this->replies['templated'] = false;
            $this->getQuestionMessage($profile);
            return $this->replies;
        } elseif ($this->responder->type == 2) {
            $this->replies['templated'] = true;
            $hashids = new Hashids("Diamond Secret", 10);
            $this->questions = [route('forms.responder', ['id' => $hashids->encode([$this->channel->responder->questions->id, $profile->id])])];
            $this->getFormMessage($profile);
            return $this->replies;
        }
    }

    /**
     * @param $profile
     */
    function getFormMessage($profile)
    {
        $this->replies["messages"] = $this->questions;
    }

    /**
     * @param $profile
     */
    function getQuestionMessage($profile)
    {
        $requests = Requests::where(['contact_id' => $profile->contact_id, 'channel_id' => $this->channel->id])->get();
        //$messages = Messages::where(['contact_id' => $contact_id, 'channel_id' => $this->channel->id])->get();
        $unrepliedRequest = $requests->where('status', 0)->first();
        if ($this->error != "") {
            $this->replies["messages"][] = $this->error;
        }
        if ($unrepliedRequest) {
            $this->replies["messages"][] = $this->questions[array_search($unrepliedRequest->toArray(), $requests->toArray())]->message;
            $this->setQuickReplies($this->questions[array_search($unrepliedRequest->toArray(), $requests->toArray())], $profile);
        } elseif (isset($this->questions[$requests->count()])) {
            Requests::updateOrCreate(['channel_id' => $this->channel->id, 'contact_id' => $profile->contact_id, 'responder_id' => $this->responder->id, 'source' => $this->responder->type, 'source_id' => $this->questions[$requests->count()]->id, 'status' => $this->questions[$requests->count()]->response == 0 ? 1 : 0]);
            $this->replies["messages"][] = $this->questions[$requests->count()]->message;
            $this->setQuickReplies($this->questions[$requests->count()], $profile);
            if ($this->questions[$requests->count()]->response == 0) {
                $this->getNextQuestion($profile);
            }
        } else {
            $this->replies["messages"] = ["thanks for your time we will contact you ASAP :)"];
        }
    }

    /**
     * @param $profile
     * @param $message
     * @return bool
     */
    public function validate($profile, $message, $requests)
    {
        if ($requests->count() !== 0 && $this->responder->type !=2 ) {
            $field = $this->questions[$requests->count() - 1]->field()->first();
            $validator = Validator::make([$field->tag => $message], [$field->tag => $field->format]);
            if ($field->tag == "country") {
                if (Countries::exist($message)) {
                    $message = Countries::getCountries($message);
                } else {
                    $this->replies["messages"][] = "Sorry i didin't understand :(";
                    return false;
                }
            }
            if ($validator->fails()) {
                $this->replies["messages"] = $validator->errors()->all();
                return false;
            }
            if ($field->tag == "birthday") {
                $message = date('Y-m-d', strtotime($message));
            }
            if (array_key_exists($field->tag, $profile->getAttributes())) {
                $profile->update([$field->tag => $message]);
            }
            if (array_key_exists($field->tag, $profile->contact->getAttributes())) {
                $profile->contact->update([$field->tag => $message]);
            }
            $requests->where('status', 0)->first()->update(['status' => 1]);
            return true;
        }
        return false;
    }

    /**
     * @param $question
     * @param $profile
     */
    public function setQuickReplies($question, $profile)
    {
        $field = $question->field()->first();
        if ($field) {
            if (array_key_exists($field->tag, $profile->getAttributes()) && !is_null($profile->getAttributes()[$field->tag])) {
                $this->replies["suggestions"][] = array("content_type" => "text",
                    "title" => $profile->getAttributes()[$field->tag],
                    "payload" => $profile->getAttributes()[$field->tag]);
            } elseif (array_key_exists($field->tag, $profile->contact->getAttributes()) && !is_null($profile->contact->getAttributes()[$field->tag])) {
                $this->replies["suggestions"][] = array("content_type" => "text",
                    "title" => $profile->contact->getAttributes()[$field->tag],
                    "payload" => $profile->contact->getAttributes()[$field->tag]);
            }
        }
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
