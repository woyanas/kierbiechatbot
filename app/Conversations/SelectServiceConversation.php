<?php

namespace App\Conversations;

use Illuminate\Foundation\Inspiring;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Question;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Outgoing\Question as BotManQuestion;
use BotMan\BotMan\Messages\Incoming\Answer as BotManAnswer;

class SelectServiceConversation extends Conversation
{
    public function askService()
    {
        $question = Question::create('Service apa yang kamu cari?')
            ->fallback('Unable to ask question')
            ->callbackId('select_service')
            ->addButtons([
                Button::create('HP')->value('HP'),
                Button::create('Laptop')->value('Laptop'),
                Button::create('PC')->value('PC'),
            ]);
        $this->ask($question, function (Answer $answer) {
            if ($answer->isInteractiveMessageReply()) {
                $this->bot->userStorage()->save([
                    'service' => $answer->getValue(),
                ]);
            } else {
                return $this->repeat('Layanan yang anda pilih tidak ada di daftar kami.');
            }
            $this->bot->startConversation(new BookingConversation());
        });
    }
    /**
     * Start the conversation.
     *
     * @return mixed
     */
    public function run()
    {
        $this->askService();
    }
}