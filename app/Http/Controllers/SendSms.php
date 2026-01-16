<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\SmsLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class SendSms extends Controller
{
    private $numbers;
    private $message;
    private $isTesting;
    private $action;

    public function getNumber()
    {
        return $this->numbers;
    }

    public function setNumber($numbers)
    {
        if (is_array($numbers)) {
            $this->numbers = $numbers;
        } else {
            $this->numbers = [$numbers];
        }
        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message)
    {
        $this->message = $message;
        return $this;
    }

    public function setAction(string $action)
    {
        $this->action = $action;
        return $this;
    }

    public function getAction()
    {
        return $this->action;
    }

    public function setIsTesting(bool $isTesting)
    {
        $this->isTesting = $isTesting;
        return $this;
    }

    public function isTesting()
    {
        return $this->isTesting;
    }

    public function send()
    {
        if (SmsLog::whereStatus(1)->sum('value') < User::find(1)->sms_balance) {
            if (!$this->isTesting()) {
                $response = $this->bulkSmsBd();
            } else {
                $response = [
                    'status' => true,
                    'message' => 'SMS Testing Successfull',
                    ];
            }
        } else {
            $response = [
                'status' => false,
                'message' => 'SMS balance is not enough',
                ];
        }

        $this->smsLog($response);
    }

    public function smsLog($response)
    {
        $smsLog = new SmsLog();
        $smsLog->user_id = Auth::check() ? Auth::id() : null;
        $smsLog->sender = config('sms.senderid');
        $smsLog->massage = $this->getMessage();
        $smsLog->to = implode(',', $this->getNumber());
        $smsLog->status = $response['status'] ? 1 : null;
        $smsLog->value = config('sms.value') * SmsCounter::multipartLength($this->getMessage());
        $smsLog->action = $this->getAction();
        $smsLog->response = $response['message'];
        $smsLog->save();
    }

    public function zammanIt()
    {
        $data = [
            'senderid' => config('sms.senderid'),
            'msg' => $this->getMessage(),
            'contacts' => implode(',', $this->getNumber()),
            'type' => config('sms.type'),
            'api_key' => config('sms.api_key')
        ];

        $response = Http::post(config('sms.url'), $data);

        return [
            'status' => $response->status() == 200 ? true : false,
            'message' => $response->body(),
        ];
    }

    public function bulkSmsBd()
    {
        $data = [
            'senderid' => config('sms.senderid'),
            'message' => $this->getMessage(),
            'number' => implode(',', $this->getNumber()),
            'type' => config('sms.type'),
            'api_key' => config('sms.api_key'),
            'label' => 'transactional',
        ];

        $response = Http::post(config('sms.url'), $data);

        return [
            'status' => $response->status() == 200 ? true : false,
            'message' => $response->body(),
        ];
    }
}
