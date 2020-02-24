<?php
header('Content-Type: text/html; charset=utf-8');
// подрубаем API
require_once("vendor/autoload.php");

// создаем переменную бота
$token = "937280419:AAHEKi-qdznCQXufkQWbRzjdbAtysyjoFCs";
$bot = new \TelegramBot\Api\Client($token);

// если бот еще не зарегистрирован - регистрируем
if(!file_exists("registered.trigger")){ 
	/**
	 * файл registered.trigger будет создаваться после регистрации бота. 
	 * если этого файла нет значит бот не зарегистрирован 
	 */
	 
	// URl текущей страницы
	$page_url = "https://".$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
	$result = $bot->setWebhook($page_url);
	if($result){
		file_put_contents("registered.trigger",time()); // создаем файл дабы прекратить повторные регистрации
	}
}

/* КОМАНДЫ*/

// обязательное. Запуск бота
// start c сообщением
// $bot->command('start', function ($message) use ($bot) {
//     $answer = 'Добро пожаловать! Вас приветствует ресторанно-Готельный комплекс "RELAX"';
//     $bot->sendMessage($message->getChat()->getId(), $answer);
// });
//start c кнопками
$bot->command("start", function ($message) use ($bot) {
        $keyboard = new \TelegramBot\Api\Types\Inline\InlineKeyboardMarkup(           
            [
                [['callback_data' => 'banya', 'text' => hex2bin('F09F9B80').' Баня'],
                ['callback_data' => 'hotel', 'text' => hex2bin('f09f9b8f').' Готель']],
                [['callback_data' => 'restourant', 'text' => hex2bin('F09F8DB4').' Ресторан'],
                ['callback_data' => 'contact', 'text' => hex2bin('F09F939D').' Контакти']],
            ]           
        );
        $video = 'https://relax.zt.ua/telbot/img/i.mp4';
        $bot->sendVideo($message->getChat()->getId(), $video);
        $bot->sendMessage($message->getChat()->getId(), "Що вас цiкавить" . hex2bin('E29D93'), null,false,null,$keyboard);
    });
        //////////////////////////////////// ГЛАВНАЯ//////////////////////////////////////////////
        $bot->on(function($update) use ($bot, $callback_loc, $find_command){
            $callback = $update->getCallbackQuery();
            $message = $callback->getMessage();
            $chatId = $message->getChat()->getId();
            $data = $callback->getData();
            
            if($data == "banya"){
                $bot->sendPhoto($message->getChat()->getId(), "https://relax.zt.ua/telbot/img/relax.jpg");
                $bot->sendMessage($message->getChat()->getId(), hex2bin('E282B4') . " Цiна: \nПн-Чт: 140 грн/год. \nПт-Нд: 180 грн/год. 
                \nЗамовити: \n" . hex2bin('E2988E') . "  +38067 410 22 04");
                $keyboard = new \TelegramBot\Api\Types\Inline\InlineKeyboardMarkup( 
                    [
                        [['callback_data' => 'relax', 'text' =>hex2bin('F09F8FA0').' Головна']] 
                    ] 
                );
                $bot->sendMessage($message->getChat()->getId(), "Повернутись на головну" . hex2bin('E29D97'), false, null,null,$keyboard);
            }
            if($data == "hotel"){
                $keyboard = new \TelegramBot\Api\Types\Inline\InlineKeyboardMarkup(   
                    [
                        [['callback_data' => 'room_1', 'text' => hex2bin('f09f9b8f') . ' Номер «Повний релакс»']],
                        [['callback_data' => 'room_2', 'text' => hex2bin('f09f9b8f') . ' Економ'],
                        ['callback_data' => 'room_3', 'text' => hex2bin('f09f9b8f') . ' Стандарт']],

                        [['callback_data' => 'room_4', 'text' =>hex2bin('f09f9b8f') . ' Стандарт покращений']],

                        [['callback_data' => 'room_5', 'text' => hex2bin('f09f9b8f') . ' Люкс'],
                        ['callback_data' => 'room_6', 'text' => 'СуперЛюкс'],
                        ['callback_data' => 'room_7', 'text' => hex2bin('f09f9b8f') . ' Vip']],

                        [['callback_data' => 'relax', 'text' => hex2bin('F09F8FA0') . ' Головна']]
                    ]   
                );
                $bot->sendMessage($message->getChat()->getId(), hex2bin('E29D93') . "Готель RELAX". hex2bin('E29D93'), false, null,null,$keyboard);
            }
            if($data == "restourant"){
                $keyboard = new \TelegramBot\Api\Types\Inline\InlineKeyboardMarkup(   
                    [
                        [['callback_data' => 'menu', 'text' => hex2bin('F09F9396') . ' Меню'],['callback_data' => 'bar', 'text' =>hex2bin('F09F8DB9') . 'Барна Карта']],
                        [['callback_data' => 'zakaz', 'text' => hex2bin('F09F918C') . 'Замовити стiл'],['callback_data' => 'relax', 'text' => hex2bin('F09F8FA0') . 'Головна']]
                    ]   
                );
                $bot->sendMessage($message->getChat()->getId(), hex2bin('F09F8DB4') . "Ресторан RELAX" . hex2bin('F09F8DB4'), false, null,null,$keyboard);
            }
            if($data == "contact"){
                $bot->sendPhoto($message->getChat()->getId(),"https://relax.zt.ua/telbot/img/location.jpg");
                $bot->sendMessage($message->getChat()->getId(),
                        "Ми знаходимося за адресою:
м. Житомир, Чуднівска (Черняховского) 103В

Звонити нам за номерами:
Готель: \n" . hex2bin('E2988E') . "  +38067 410 22 04

Ресторан: \n" . hex2bin('E2988E') . "  +38098 952 61 61\n"
 . hex2bin('E2988E') . "  +38093 116 62 41

Баня: \n" . hex2bin('E2988E') . "  +38067 410 22 04");
                        $keyboard = new \TelegramBot\Api\Types\Inline\InlineKeyboardMarkup( 
                            [
                                [['callback_data' => 'relax', 'text' => hex2bin('F09F8FA0') .' Головна']] 
                            ] 
                        );
                        $bot->sendMessage($message->getChat()->getId(), "Повернутись на головну" . hex2bin('E29D97'), false, null,null,$keyboard);
            }

        }, 
        function($update){
        $callback = $update->getCallbackQuery();
        if (is_null($callback) || !strlen($callback->getData()))
            return false;
        return true;
        });
        ///////////////////////////////////////////////// ГОТЕЛЬ-НОМЕРА///////////////////////////////////////////////////
        $bot->on(function($update) use ($bot, $callback_loc, $find_command){
            $callback = $update->getCallbackQuery();
            $message = $callback->getMessage();
            $chatId = $message->getChat()->getId();
            $data = $callback->getData();
            $keyboard = new \TelegramBot\Api\Types\Inline\InlineKeyboardMarkup(   
                [
                    [['callback_data' => 'hotel', 'text' => hex2bin('F09F9396') . ' Номери'],['callback_data' => 'zakaz_hotel', 'text' => hex2bin('F09F918C') . 'Замовити номер']],
                    [['callback_data' => 'relax', 'text' => hex2bin('F09F8FA0') . 'Головна']],
                ]   
            );
            
            if($data == "room_1"){
                $bot->sendPhoto($message->getChat()->getId(), "https://relax.zt.ua/telbot/img/polnui_scr1.jpg");
                $bot->sendPhoto($message->getChat()->getId(), "https://relax.zt.ua/telbot/img/polnui_scr2.jpg");
                $bot->sendPhoto($message->getChat()->getId(), "https://relax.zt.ua/telbot/img/polnui_scr3.jpg");
                $bot->sendPhoto($message->getChat()->getId(), "https://relax.zt.ua/telbot/img/relax_polnii1.jpg");
                $bot->sendMessage($message->getChat()->getId(), hex2bin('E29D93')." Куди далi" . hex2bin('E29D93'), false, null,null,$keyboard);
            }
            if($data == "room_2"){
                $bot->sendPhoto($message->getChat()->getId(), "https://relax.zt.ua/telbot/img/ekonom.jpg");
                $bot->sendPhoto($message->getChat()->getId(), "https://relax.zt.ua/telbot/img/relax_ekonom_1.jpg");
                $bot->sendMessage($message->getChat()->getId(), hex2bin('E29D93')." Куди далi" . hex2bin('E29D93'), false, null,null,$keyboard);
            }
            if($data == "room_3"){
                $bot->sendPhoto($message->getChat()->getId(), "https://relax.zt.ua/telbot/img/standart_scr.jpg");
                $bot->sendPhoto($message->getChat()->getId(), "https://relax.zt.ua/telbot/img/standart_scr1.jpg");
                $bot->sendPhoto($message->getChat()->getId(), "https://relax.zt.ua/telbot/img/relax_standart_1.jpg");
                $bot->sendMessage($message->getChat()->getId(), hex2bin('E29D93')." Куди далi" . hex2bin('E29D93'), false, null,null,$keyboard);
            }
            if($data == "room_4"){
                $bot->sendPhoto($message->getChat()->getId(), "https://relax.zt.ua/telbot/img/standart+.jpg");
                $bot->sendPhoto($message->getChat()->getId(), "https://relax.zt.ua/telbot/img/relax_standart+_1.jpg");
                $bot->sendMessage($message->getChat()->getId(), hex2bin('E29D93')." Куди далi" . hex2bin('E29D93'), false, null,null,$keyboard);
            }
            if($data == "room_5"){
                $bot->sendPhoto($message->getChat()->getId(), "https://relax.zt.ua/telbot/img/lyks1-2_scr.jpg");
                $bot->sendPhoto($message->getChat()->getId(), "https://relax.zt.ua/telbot/img/lyks1-2_scr1.jpg");
                $bot->sendPhoto($message->getChat()->getId(), "https://relax.zt.ua/telbot/img/relax_lyks1-2-1.jpg");
                $bot->sendPhoto($message->getChat()->getId(), "https://relax.zt.ua/telbot/img/lyks_scr.jpg");
                $bot->sendPhoto($message->getChat()->getId(), "https://relax.zt.ua/telbot/img/lyks_scr1.jpg");
                $bot->sendPhoto($message->getChat()->getId(), "https://relax.zt.ua/telbot/img/relax_lyks_1.jpg");
                $bot->sendMessage($message->getChat()->getId(), hex2bin('E29D93')." Куди далi" . hex2bin('E29D93'), false, null,null,$keyboard);
            }
            if($data == "room_6"){
                $bot->sendPhoto($message->getChat()->getId(), "https://relax.zt.ua/telbot/img/super-lyks_scr.jpg");
                $bot->sendPhoto($message->getChat()->getId(), "https://relax.zt.ua/telbot/img/super-lyks_scr1.jpg");
                $bot->sendPhoto($message->getChat()->getId(), "https://relax.zt.ua/telbot/img/relax_super-lyks_1.jpg");
                $bot->sendMessage($message->getChat()->getId(), hex2bin('E29D93')." Куди далi" . hex2bin('E29D93'), false, null,null,$keyboard);
            }
            if($data == "room_7"){
                $bot->sendPhoto($message->getChat()->getId(), "https://relax.zt.ua/telbot/img/vip_scr.jpg");
                $bot->sendPhoto($message->getChat()->getId(), "https://relax.zt.ua/telbot/img/relax_vip.jpg");
                $bot->sendMessage($message->getChat()->getId(), hex2bin('E29D93')." Куди далi" . hex2bin('E29D93'), false, null,null,$keyboard);
            }                              
        }, 
        function($update){
            $callback = $update->getCallbackQuery();
            if (is_null($callback) || !strlen($callback->getData()))
                return false;
            return true;
        });
        $bot->on(function($update) use ($bot, $callback_loc, $find_command){
            $callback = $update->getCallbackQuery();
            $message = $callback->getMessage();
            $chatId = $message->getChat()->getId();
            $data = $callback->getData();
            $keyboard = new \TelegramBot\Api\Types\Inline\InlineKeyboardMarkup(   
                [
                    [['callback_data' => 'hotel', 'url'=> 'https://www.booking.com/hotel/ua/restaurant-complex-relax.uk.html?aid=318615;label=Ukrainian_U
                    K_28510485865-814zpDHvTAAz%2ANPadXCRMgS217244757087%3Apl%3Ata%3Ap1%3Ap2%3Aac%3Aap%3Aneg%3Afi22759579648%3Atiaud-146342138710%3Adsa-
                    320865086129%3Alp1012846%3Ali%3Adec%3Adm;sid=1782581350b428b56e248d00e0d128ee;dest_id=-1060903;dest_type=city;dist=0;group_adults=2;
                    group_children=0;hapos=1;hpos=1;no_rooms=1;room1=A%2CA;sb_price_type=total;sr_order=popularity;srepoch=1582212910;srpvid=b5b86d97fce2009b;type=total;ucfs=1&#hotelTmpl', 
                    'text' => hex2bin('F09F938B') .' Booking']],
                    [['callback_data' => 'hotel', 'text' => hex2bin('F09F9396') . ' Номери'],['callback_data' => 'relax', 'text' => hex2bin('F09F8FA0') . 'Головна']],
                ]   
            );
            
            if($data == "zakaz_hotel"){
                $bot->sendMessage($message->getChat()->getId(),
"Звонити нам за номерам:
Готель: \n" . hex2bin('E2988E') . "  +38067 410 22 04.");
                $bot->sendMessage($message->getChat()->getId(), hex2bin('E29D93')." Куди далi" . hex2bin('E29D93'), false, null,null,$keyboard);
            }  
        }, 
        function($update){
            $callback = $update->getCallbackQuery();
            if (is_null($callback) || !strlen($callback->getData()))
                return false;
            return true;
        });
        ///////////////////////////////////////////////// РЕСТОРАН-МЕНЮ///////////////////////////////////////////////////
            $bot->on(function($update) use ($bot, $callback_loc, $find_command){
                $callback = $update->getCallbackQuery();
                $message = $callback->getMessage();
                $chatId = $message->getChat()->getId();
                $data = $callback->getData();
                if($data == "menu"){
                    $keyboard = new \TelegramBot\Api\Types\Inline\InlineKeyboardMarkup( 
                        [
                            [['callback_data' => 'menu_1', 'text' => hex2bin('F09F8D85') . ' Холодні закуски та Салати' . hex2bin('F09F8D83')]],
                            [['callback_data' => 'menu_2', 'text' => hex2bin('F09F8DB2') . ' Супи, Гарячі закуски, Пивні закуски' . hex2bin('F09F8DBA')]],
                            [['callback_data' => 'menu_3', 'text' => hex2bin('F09F8DB3') . ' Основні страви та Гарніри' . hex2bin('F09F8D9C')]],
                            [['callback_data' => 'menu_6', 'text' => hex2bin('F09F8D96') . ' Мангал'],['callback_data' => 'menu_5', 'text' => hex2bin('F09F8DB1') .  ' Бізнес ланчі']],
                            [['callback_data' => 'menu_4', 'text' => hex2bin('F09F8DB0') . ' Десерт'],['callback_data' => 'relax', 'text' => hex2bin('F09F8FA0') . ' Головна']] 
                        ] 
                    );
                    $bot->sendMessage($message->getChat()->getId(),hex2bin('F09F8DB4') . "Ресторан RELAX" . hex2bin('F09F8DB4'), false, null,null,$keyboard);
                }
                if($data == "bar"){
                    $bot->sendPhoto($message->getChat()->getId(), "https://relax.zt.ua/telbot/img/bar.jpg");
                    $bot->sendPhoto($message->getChat()->getId(), "https://relax.zt.ua/telbot/img/bar2.jpg");
                    $keyboard = new \TelegramBot\Api\Types\Inline\InlineKeyboardMarkup(   
                        [
                            [['callback_data' => 'menu', 'text' => hex2bin('F09F9396') . 'Меню'],['callback_data' => 'bar', 'text' => hex2bin('F09F8DB9') . 'Барна Карта']],
                            [['callback_data' => 'zakaz', 'text' => hex2bin('F09F918C') . 'Замовити стiл'],['callback_data' => 'relax', 'text' => hex2bin('F09F8FA0') . 'Головна']]
                        ]   
                    );
                    $bot->sendMessage($message->getChat()->getId(), hex2bin('E29D93')." Куди далi" . hex2bin('E29D93'), false, null,null,$keyboard);
                }
                if($data == "zakaz"){
                    $bot->sendMessage($message->getChat()->getId(), 
                    "Ресторан Relax: \n" . hex2bin('E2988E') . " +38098 952 61 61;\n" . hex2bin('E2988E') . " +38093 116 62 41");
                    $keyboard = new \TelegramBot\Api\Types\Inline\InlineKeyboardMarkup( 
                        [
                            [['callback_data' => 'relax', 'text' =>hex2bin('F09F8FA0') . ' Головна']] 
                        ] 
                    );
                    $bot->sendMessage($message->getChat()->getId(), "Повернутись на головну" . hex2bin('E29D97'), false, null,null,$keyboard);
                }
                if($data == "relax"){
                    $keyboard = new \TelegramBot\Api\Types\Inline\InlineKeyboardMarkup(           
                        [
                            [['callback_data' => 'banya', 'text' => hex2bin('F09F9B80').' Баня'],
                            ['callback_data' => 'hotel', 'text' => hex2bin('f09f9b8f').' Готель']],
                            [['callback_data' => 'restourant', 'text' => hex2bin('F09F8DB4').' Ресторан'],
                            ['callback_data' => 'contact', 'text' => hex2bin('F09F939D').' Контакти']],
                        ]           
                    );
                     $bot->sendMessage($message->getChat()->getId(), "Що вас цiкавить" . hex2bin('E29D93'), null,true,null,$keyboard);
                }
            }, 
            function($update){
                $callback = $update->getCallbackQuery();
                if (is_null($callback) || !strlen($callback->getData()))
                    return false;
                return true;
            });
            ////////////////////////////////////////////////////////////// МЕНЮ-КОНТЕНТ///////////////////////////////////////////////////////
                $bot->on(function($update) use ($bot, $callback_loc, $find_command){
                    $callback = $update->getCallbackQuery();
                    $message = $callback->getMessage();
                    $chatId = $message->getChat()->getId();
                    $data = $callback->getData();
                    $keyboard = new \TelegramBot\Api\Types\Inline\InlineKeyboardMarkup(   
                        [
                            [['callback_data' => 'menu', 'text' => hex2bin('F09F9396') . ' Меню'],['callback_data' => 'bar', 'text' => hex2bin('F09F8DB9') . ' Барна Карта']],
                            [['callback_data' => 'zakaz', 'text' => hex2bin('F09F918C') . 'Замовити стiл'],['callback_data' => 'relax', 'text' => hex2bin('F09F8FA0') . 'Головна']],
                        ]   
                    );
                    
                    if($data == "menu_1"){
                        $bot->sendPhoto($message->getChat()->getId(), "https://relax.zt.ua/telbot/img/hol_zakyski_salatu.jpg");
                        $bot->sendMessage($message->getChat()->getId(), hex2bin('E29D93')." Куди далi" . hex2bin('E29D93'), false, null,null,$keyboard);
                    }
                    if($data == "menu_2"){
                        $bot->sendPhoto($message->getChat()->getId(), "https://relax.zt.ua/telbot/img/garyachee_k_pivy.jpg");
                        
                        $bot->sendMessage($message->getChat()->getId(), hex2bin('E29D93')." Куди далi" . hex2bin('E29D93'), false, null,null,$keyboard);
                    }
                    if($data == "menu_3"){
                        $bot->sendPhoto($message->getChat()->getId(), "https://relax.zt.ua/telbot/img/ocnovni_garniru.jpg");
                        
                        $bot->sendMessage($message->getChat()->getId(), hex2bin('E29D93')." Куди далi" . hex2bin('E29D93'), false, null,null,$keyboard);
                    }
                    if($data == "menu_4"){
                        $bot->sendPhoto($message->getChat()->getId(), "https://relax.zt.ua/telbot/img/desertu.jpg");
                        $bot->sendMessage($message->getChat()->getId(), hex2bin('E29D93')." Куди далi" . hex2bin('E29D93'), false, null,null,$keyboard);
                    }
                    if($data == "menu_5"){
                        $bot->sendPhoto($message->getChat()->getId(), "https://relax.zt.ua/telbot/img/biznes_lanch.jpg"); 
                        $bot->sendMessage($message->getChat()->getId(), hex2bin('E29D93')." Куди далi" . hex2bin('E29D93'), false, null,null,$keyboard);
                    }
                    if($data == "menu_6"){
                        $bot->sendPhoto($message->getChat()->getId(), "https://relax.zt.ua/telbot/img/mangal.jpg");
                        $bot->sendMessage($message->getChat()->getId(), hex2bin('E29D93')." Куди далi" . hex2bin('E29D93'), false, null,null,$keyboard);
                    }                  
                }, 
                function($update){
                    $callback = $update->getCallbackQuery();
                    if (is_null($callback) || !strlen($callback->getData()))
                        return false;
                    return true;
                });


// // помощь
// $bot->command('help', function ($message) use ($bot) {
//     $answer = 'Команды:
// /help - помощ';
//     $bot->sendMessage($message->getChat()->getId(), $answer);
// });

// // передаем картинку
// $bot->command('getpic', function ($message) use ($bot) {
// 	$pic = "https://bipbap.ru/wp-content/uploads/2017/05/VOLKI-krasivye-i-ochen-umnye-zhivotnye.jpg";

//     $bot->sendPhoto($message->getChat()->getId(), $pic);
// });

// // передаем документ
// $bot->command('getdoc', function ($message) use ($bot) {
// 	$document = new \CURLFile('shtirner.txt');

//     $bot->sendDocument($message->getChat()->getId(), $document);
// });

// запускаем обработку
$bot->run();