<?php
 
namespace App\Conversations;
 
use Illuminate\Foundation\Inspiring;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Question;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Outgoing\Question as BotManQuestion;
use BotMan\BotMan\Messages\Incoming\Answer as BotManAnswer;
 
 
class IntroductionConversation extends Conversation
{
    public function askName()
    {
        $this->ask('Siapa nama kamu?', function (Answer $answer) {
            $this->bot->userStorage()->save([
                'name' => $answer->getText(),
            ]);
            $this->say('Halo ' . $answer->getText());
            $this->askMobile();
        });
    }

    public function askEmail()
    {
        $this->ask('apa nama alamat emailmu?', function (Answer $answer) {
            
            $validator = Validator::make(['email' => $answer->getText()], ['email' => 'email']);
            
            if ($validator->fails()) {
                return $this->repeat('Email yang anda masukkan tidak valid');
            }
            
            $this->bot->userStorage()->save([
                'email' => $answer->getText(),
            ]);
            
            $this->askMobile();
        });
    }
    
    public function askMobile()
    {
        $this->ask('berapa nomor telepon kamu?', function (Answer $answer) {
            $this->bot->userStorage()->save([
                'mobile' => $answer->getText(),
            ]);
            $this->say('Terimakasih');
            // move to another conversation
            $this->bot->startConversation(new SelectServiceConversation());
        });
    }

    public function run()
    {
        //$this->askHadits();
        //$this->cariLagi();
        $this->askName();
        //$this->askEmail();
        //$this->askMobile();
    }
}