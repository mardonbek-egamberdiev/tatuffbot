<?php


namespace frontend\controllers;


use common\models\Client;
use common\models\Phone;
use common\models\Portfolio;
use common\models\Quarters;
use Exception;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\helpers\VarDumper;
use yii\web\Controller;

class TelegramController extends Controller
{
    public $user;

    public function beforeAction($action)
    {
        if ($action->id == 'index') {
            $this->enableCsrfValidation = false;
        }

        return parent::beforeAction($action);
    }

    public function actionIndex()
    {

        try {

            $token = '7602376777:AAGNMzkCpUIN_i53XG2FZprjlFowh17qlh8';
            $data = json_decode(file_get_contents("php://input"), true);
            $message = $data['message'] ?? null;
            $from = $message['from'] ?? null;
            $callback_query = $data['callback_query'] ?? null;
            $user_id = $from['id'] ?? '';
            $text = $message['text'] ?? null;
            $name = $from['first_name'] ?? null;
            $username = $from['username'] ?? null;

            $this->setMainVars($user_id, $name, $username);
            $this->messageHandler($message, $callback_query);

        } catch (\Exception $e) {
            // $this->debug($e->getMessage());
        }

    }

    public function messageHandler($message, $callback_query)
    {
        if (isset($message['text']) && ($message['text'] == '/start' || $message['text'] == '❌ Bekor qilish' || $message['text'] == '🏠 Bosh sahifa')) {
            $keyboard = json_encode([
                'keyboard' =>
                    [
                        [
                            ['text' => '❌ Bekor qilish']
                        ]
                    ],
                'resize_keyboard' => true,
            ]);

            $this->bot('sendMessage', [
                'chat_id' => $this->user->user_id,
                'text' => "📌A ssalomu alaykum. Ushbu bot orqali siz top100 uchun hujjat topshirishingiz mumkin.",
                'reply_markup' => $keyboard,
                'parse_mode' => 'html'
            ]);

            $this->bot('sendMessage', [
                'chat_id' => $this->user->user_id,
                'text' => "📌 Iltimos, endi Ism va Familiyangizni kiriting: <i>(Islomjon Muhammadjonov)</i>",
                'reply_markup' => $keyboard,
                'parse_mode' => 'html'
            ]);

            $this->user->step = "fio";
            $this->user->save();
        }
        if (isset($message['text']) && $message['text'] == "Sertifikat yo'q") {
            $inlineKeyboard = json_encode([
                'inline_keyboard' => [
                    [
                        [
                            'text' => 'Scientific Publication | RASMIY',
                            'url' => 'https://t.me/scientific_publication',
                            'one_time_keyboard' => true,
                        ],
                    ],
                ]
            ]);
            $keyboard = json_encode([
                'keyboard' =>
                    [
                        [
                            ['text' => 'Yuborish']
                        ],
                        [
                            ['text' => '❌ Bekor qilish']
                        ]
                    ],
                'resize_keyboard' => true,
            ]);
            $message_text =
                "👤 " . $this->user->full_name . "\n" .
                "📍 " . $this->getUserData('address') . "\n" .
                "📞 " . $this->getUserData('phone') . "\n" .
                "🏛 " . $this->getUserData('get_teach') . "\n" .
                "🔖 Sertifikat: bor";
            $this->bot('sendMessage', [
                'chat_id' => $this->user->user_id,
                'text' => $message_text,
                'reply_markup' => $inlineKeyboard,
            ]);
            $this->bot('sendMessage', [
                'chat_id' => $this->user->user_id,
                'text' => "📌 Kanalga azo bo'lib yuborish tugmasini bosing",
                'reply_markup' => $keyboard,
                'parse_mode' => 'html'
            ]);
            $this->user->step = "finish";
            $this->user->save();
        }
        if (isset($message['text']) && $message['text'] == 'Yuborish') {
//             $channelResult = $this->bot('GetChatMember', [
//                 'chat_id' => -1002137986505,
//                 'user_id' => $this->user->user_id,
//             ])->result->status;
//             if ($channelResult != 'left') {
//                 if ($this->user->file != '') {
//                     $message_text =
//                         "👤 " . $this->user->full_name . "\n" .
//                         "📍 " . $this->getUserData('address') . "\n" .
//                         "📞 " . $this->getUserData('phone') . "\n" .
//                         "🏛 " . $this->getUserData('get_teach') . "\n" .
//                         "🔖 Sertifikat: bor";
//                     $send = $this->bot('sendPhoto', [
//                         'chat_id' => 672765105,
//                         'photo' => 'https://' . Yii::$app->request->hostName . '/file/' . $this->user->file,
//                         'caption' => $message_text,
//                         'parse_mode' => 'html'
//                     ]);
//                     $file = $this->user->file;
//                     $savePath = "@frontend/web/payment/$file"; // Replace with the desired save path
//                     unlink(Yii::getAlias($savePath));
//                 } else {
//                     $message_text =
//                         "👤 " . $this->user->full_name . "\n" .
//                         "📍 " . $this->getUserData('address') . "\n" .
//                         "📞 " . $this->getUserData('phone') . "\n" .
//                         "🏛 " . $this->getUserData('get_teach') . "\n" .
//                         "🔖 Sertifikat: yo'q";
//                     $this->bot('sendMessage', [
//                         'chat_id' => $this->user->user_id,
//                         'text' => $message_text,
//                         'parse_mode' => 'html'
//                     ]);
// //                Yii::$app->resellerBot->bot('answerCallbackQuery', [
// //                    'callback_query_id' => $callback_query['id'],
// //                    'text' => $alert_message,
// //                    'show_alert' => true,
// //                ]);
//                 }
//             } else {
//                 $this->bot('sendMessage', [
//                     'chat_id' => $this->user->user_id,
//                     'text' => 'Kalaga azo bo\'lmagansiz'
//                 ]);
//             }

        }

        if ($this->user->step != "") {
            $this->setHandler($message);
            return true;
        }

    }

    public function stepHander($message)
    {

        if ($this->user->step == 'get_address') {
            $keyboard = json_encode([
                'keyboard' =>
                    [
                        [
                            ['text' => '❌ Bekor qilish']
                        ]
                    ],
                'resize_keyboard' => true,
            ]);
            $this->bot('sendMessage', [
                'chat_id' => $this->user->user_id,
                'text' => "📌 Yaxshi, endi iltimos Manzilingizni kiriting!<i><b> Masalan:</b> Farg'ona</i>",
                'reply_markup' => $keyboard,
                'parse_mode' => 'html'
            ]);
        }


        if ($this->user->step == 'get_phone') {

            $keyboard = json_encode([

                'keyboard' => [
                    [
                        [
                            'text' => '📱 Telefon raqamingizni yuboring!', 'request_contact' => true
                        ],
                    ],
                    [
                        ['text' => '❌ Bekor qilish'],
                    ],
                ],
                'resize_keyboard' => true,
            ]);

            $this->bot('sendMessage', [
                'chat_id' => $this->user->user_id,
                'text' => '📱 Telefon raqamingizni kiriting',
                'parse_mode' => 'html',
                'reply_markup' => $keyboard,
            ]);
        }
        if ($this->user->step == 'get_teach') {
            $keyboard = json_encode([
                'keyboard' =>
                    [
                        [
                            ['text' => '❌ Bekor qilish']
                        ]
                    ],
                'resize_keyboard' => true,
            ]);
            $this->bot('sendMessage', [
                'chat_id' => $this->user->user_id,
                'text' => "📌 Qayerda ta'lim olasiz(olgansiz) yoki ishlaysiz!",
                'reply_markup' => $keyboard,
                'parse_mode' => 'html'
            ]);
        }
        if ($this->user->step == 'get_language') {
            $keyboard = json_encode([
                'keyboard' =>
                    [
                        [
                            ['text' => "Sertifikat yo'q"],
                        ]
                    ],
                'resize_keyboard' => true,
            ]);
            $this->bot('sendMessage', [
                'chat_id' => $this->user->user_id,
                'text' => "📌 Agar bo‘lsa til bilish bo‘yicha sertifikatingizning suratini jo‘nating.!",
                'reply_markup' => $keyboard,
                'parse_mode' => 'html'
            ]);
        }

    }

    public function setHandler($message)
    {
        if ($this->user->step == "fio") {
            $this->saveData('fio', $message['text']);
            $this->setStep('get_fio');
            $this->stepHander($message);
            return 1;
        }

        if ($this->user->step == "get_fio") {
            if (strlen($message['text']) > 3) {
                $this->saveData('fio', $message['text']);
                $this->setStep('get_address');
                $this->stepHander($message);
                return 1;
            } else {
                $this->bot('sendMessage', [
                    'chat_id' => $this->user->user_id,
                    'text' => '<b>Ism</b> va <b>Familiya</b> 4 ta belgidan kam bo\'lmasligi kerak!',
                    'parse_mode' => 'html'
                ]);

            }

        }
        if ($this->user->step == "get_address") {
            if (strlen($message['text']) > 3) {
                $this->saveData('address', $message['text']);
                $this->setStep('get_phone');
                $this->stepHander($message);
                return 1;
            } else {
                $this->bot('sendMessage', [
                    'chat_id' => $this->user->user_id,
                    'text' => '<b>Manzil</b>  4 ta belgidan kam bo\'lmasligi kerak!',
                    'parse_mode' => 'html'
                ]);

            }

        }
        if ($this->user->step == 'get_phone') {

            if ($message['contact']['phone_number']) {
                $this->saveData('phone', $message['contact']['phone_number']);
                $this->setStep('get_teach');
                $this->stepHander($message);
                return 1;
            }
            if (!preg_match("/\+[9][9][8] [389][013789] [0-9][0-9][0-9] [0-9][0-9] [0-9][0-9]/", $message->text)) {
                $this->bot('sendMessage', [
                    'text' => 'Iltimos, quyidagicha kiriting: +998916509798',
                    'chat_id' => $this->user->user_id,
                ]);
            } else {
                $this->saveData('phone', $message['text']);
                $this->setStep('get_teach');
                $this->stepHander($message);
                return 1;
            }
            return 1;

        }
        if ($this->user->step == "get_teach") {
            if (strlen($message['text']) > 3) {
                $this->saveData('get_teach', $message['text']);
                $this->setStep('get_language');
                $this->stepHander($message);
                return 1;
            } else {
                $this->bot('sendMessage', [
                    'chat_id' => $this->user->user_id,
                    'text' => '<b>Qayerda ta\'lim olasiz(olgansiz) yoki ishlaysiz</b>  4 ta belgidan kam bo\'lmasligi kerak!',
                    'parse_mode' => 'html'
                ]);

            }

        }
        if ($this->user->step == 'get_language') {

            if (isset($message) && isset($message['photo'])) {

                if (isset($message['photo'][2])) {
                    $fileID = $message['photo'][2]['file_id'];
                } elseif (!isset($message['photo'][2]) && isset($message['photo'][1])) {
                    $fileID = $message['photo'][1]['file_id'];
                } else {
                    $fileID = $message['photo'][0]['file_id'];
                }
                $fileName = time() . $this->user->user_id . '.png'; // You can assign a custom file name here if needed

                $token = '6526966037:AAE4eR1ZbhvxX8QCXlsr8M8_T8WcrUW7UCQ';
                $getFileURL = "https://api.telegram.org/bot$token/getFile?file_id=$fileID";
                $response = file_get_contents($getFileURL);
                $fileObject = json_decode($response, true);
                $filePath = $fileObject['result']['file_path'];
                $downloadURL = "https://api.telegram.org/file/bot$token/$filePath";
                $savePath = "@frontend/web/file/$fileName"; // Replace with the desired save path
                $success = true;
                $transaction = Yii::$app->db->beginTransaction();
                try {
                    $this->user->file = $fileName;
                    $success &= $this->user->save();
                    file_put_contents(Yii::getAlias($savePath), file_get_contents($downloadURL));
                    $inlineKeyboard = json_encode([
                        'inline_keyboard' => [
                            [
                                [
                                    'text' => 'Scientific Publication | RASMIY',
                                    'url' => 'https://t.me/scientific_publication',
                                    'one_time_keyboard' => true,
                                ],
                            ],
                        ]
                    ]);
                    $keyboard = json_encode([
                        'keyboard' =>
                            [
                                [
                                    ['text' => 'Yuborish']
                                ],
                                [
                                    ['text' => '❌ Bekor qilish']
                                ]
                            ],
                        'resize_keyboard' => true,
                    ]);
                    $message_text =
                        "👤 " . $this->user->full_name . "\n" .
                        "📍 " . $this->getUserData('address') . "\n" .
                        "📞 " . $this->getUserData('phone') . "\n" .
                        "🏛 " . $this->getUserData('get_teach') . "\n" .
                        "🔖 Sertifikat: bor";


                    $send = $this->bot('sendPhoto', [
                        'chat_id' => $this->user->user_id,
                        'photo' => 'https://' . Yii::$app->request->hostName . '/file/' . $fileName,
                        'caption' => $message_text,
                        'reply_markup' => $inlineKeyboard,
                    ]);
                    $send = $this->bot('sendMessage', [
                        'chat_id' => $this->user->user_id,
                        'text' => "📌 Kanalga azo bo'lib yuborish tugmasini bosing",
                        'reply_markup' => $keyboard,
                        'parse_mode' => 'html'
                    ]);
                    if ($send->ok === false) {
                        $success &= false;
                    }
                    if ($success) {
                        $transaction->commit();
                        $this->setStep('finish');
                        $this->stepHander($message);
                        return 1;
                    }
                } catch (Exception $e) {

                }
            } else {
                $this->bot('sendMessage', [
                    'chat_id' => $this->user->user_id,
                    'text' => 'Faqat rasim yuborish mumkin'
                ]);
                return 1;
            }
        }

        if ($this->user->step == 'get_message') {
            $this->saveData('message', $message['text']);
            $this->setStep('get_end');
            $this->stepHander($message);
            return 1;
        }

    }

    public function saveData($key, $data)
    {
        $json = Json::decode($this->user->data);
        $json[$key] = $data;
        $this->user->data = Json::encode($json);
        $this->user->save(false);
    }

    public function setMainVars($user_id, $name, $username)
    {
        $user = Client::find()
            ->andWhere(['user_id' => $user_id])
            ->one();
        if (!$user) {
            $user = new Client();
            $user->user_id = $user_id;
            $user->full_name = $name;
            $user->username = $username;
            $user->status = Client::STATUS_INACTIVE;
            $user->save();
        }
        $this->user = $user;
    }

    public function setStep($step)
    {
        $this->user->step = $step;
        $this->user->save();
    }

    public function getUserData($key)
    {
        $data = Json::decode($this->user->data);
        return $data[$key];
    }

    public function getStreetArray()
    {

        $AllArray = [];

        $streets = Quarters::find()
            ->andWhere(['status' => Quarters::STATUS_ACTIVE])
            ->all();

        $streetCount = Quarters::find()
            ->andWhere(['status' => Quarters::STATUS_ACTIVE])
            ->count();

        $i = 0;

        $secondMassiv = [];

        foreach ($streets as $key => $street) {

            $i++;

            $massiv['text'] = $street->title;

            array_push($secondMassiv, $massiv);

            if ($i == 2) {

                $i = 0;
                array_push($AllArray, $secondMassiv);

                $secondMassiv = [];
            }

        }
        if ($streetCount % 2 == 1) {
            $secondMassiv = [];
            array_push($secondMassiv, $massiv);
            array_push($AllArray, $secondMassiv);
        }

        return $AllArray;
    }

    public function bot($method, $data = [], $token = '7602376777:AAGNMzkCpUIN_i53XG2FZprjlFowh17qlh8')
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://api.telegram.org/bot' . $token . '/' . $method);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $res = curl_exec($ch);
        return json_decode($res);

    }

}