<?php
namespace App\Http\Controllers;
 
use BotMan\BotMan\BotMan;
use App\Conversations\ExampleConversation;
use App\Conversations\IntroductionConversation;
use App\Conversations\SelectServiceConversation;
use App\Conversations\BookingConversation;
use BotMan\BotMan\Cache\LaravelCache;
use BotMan\BotMan\BotManFactory;
use BotMan\BotMan\Drivers\DriverManager;
 
 
class BotManController extends Controller
{
    /**
     * Place your BotMan logic here.
     */
    
    public function startConversation(BotMan $bot)
    {
        $bot->startConversation(new IntroductionConversation());
    }
    
    public function handle()
    {
        // Load the driver(s) you want to use
        DriverManager::loadDriver(\BotMan\Drivers\Telegram\TelegramDriver::class);
 
        $config = [
            // Your driver-specific configuration
            "telegram" => [
               "token" => "2002798331:AAGVPC4FmhTvIrCetNVVvtLBJ1eNPwdVx68"
            ]
        ];
        $botman = BotManFactory::create($config, new LaravelCache());
 
        $botman->hears('/islam|islam|hadist|muslim', function (BotMan $bot) {
            $user = $bot->getUser();
            $bot->reply('Assalamualaikum '.$user->getFirstName().', Selamat Datang di Kierbie Chatbot!. ');
            $bot->startConversation(new ExampleConversation());
        })->stopsConversation();

        $botman->hears('/oke|oke|sip|Okay|Ok|Okee|Sip|Siip|Siap', function (BotMan $bot) {
            //$user = $bot->getUser();
            $bot->reply('Baiklah.');
            //$bot->startConversation(new IntroductionConversation());
        })->stopsConversation();
 
        $botman->hears('/kitab|kitab', function (BotMan $bot) {
            $bot->startConversation(new ExampleConversation());
        })->stopsConversation();

        $botman->hears('/hai|hai|halo', function (BotMan $bot) {
            $bot->startConversation(new IntroductionConversation());
        })->stopsConversation();
 
        $botman->hears('/lapor|lapor|laporkan', function (BotMan $bot) {
            $bot->reply('Silahkan laporkan di email pakarbitcoin@gmail.com . Laporan kamu akan sangat berharga buat kemajuan bot ini.');
        })->stopsConversation();
 
        $botman->hears('/tentang|about|tentang', function (BotMan $bot) {
            $bot->reply('Kierbie Chatbot produk buatan Indonesia. Mohon maaf jika server terasa lamban, dikarenakan menggunakan free hosting dari Ngrok. Data didapatkan dari https://s.id/zXj6S .');
        })->stopsConversation();
 
        $botman->listen();
    }
}