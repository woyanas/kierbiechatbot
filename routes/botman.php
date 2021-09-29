<?php
use App\Http\Controllers\BotManController;
$botman = resolve('botman');
$botman->hears('.*(Hai|Hallo).*', BotManController::class . '@startConversation');