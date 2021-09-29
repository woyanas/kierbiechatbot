<?php

namespace App\Conversations;

use Illuminate\Foundation\Inspiring;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Question;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Outgoing\Question as BotManQuestion;
use BotMan\BotMan\Messages\Incoming\Answer as BotManAnswer;


class BookingConversation extends Conversation
{
    public function confirmBooking()
    {
        $user = $this->bot->userStorage()->find();
        $message = '---------------------------- <br>';
        $message .= 'Nama : ' . $user->get('name') . '<br>';
        //$message .= 'Email : ' . $user->get('email') . '<br>';
        $message .= 'No HP : ' . $user->get('mobile') . '<br>';
        $message .= 'Layanan : ' . $user->get('service') . '<br>';
        //$message .= 'Tanggal : ' . $user->get('date') . '<br>';
        //$message .= 'Waktu : ' . $user->get('time') . '<br>';
        $this->say('Terimakasih, telah memilih layanan kami. Berikut detail layanan yang anda pesan : <br>' . $message);
    }
    /**
     * Start the conversation.
     *
     * @return mixed
     */
    public function run()
    {
        $this->confirmBooking();
    }
}