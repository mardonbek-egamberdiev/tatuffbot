<?php


namespace frontend\controllers;


use common\models\Client;
use common\models\Phone;
use common\models\Portfolio;
use common\models\Quarters;
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

            $token = '5241136730:AAEVkfXP8djat5kgAmD7WVygHjKvKwntUCw';
            $data = json_decode(file_get_contents("php://input"), true);
            $message = $data['message'];
            $from = $message['from'];
            $callback_query = $data['callback_query'] ?? '';
            $user_id = $from['id'];
            $text = $message['text'];
            $name = $from['first_name'];
            $username = $from['username'] ?? '';
            $this->setMainVars($user_id, $name, $username);
            $this->messageHandler($message);

        } catch (\Exception $e) {
            // $this->debug($e->getMessage());
        }

    }

    public function messageHandler($message)
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
                'text' => "📌Assalomu alaykum! <b>Obod MFY</b>yoshlari! Ushbu bot orqali siz o'z ariza va shikoyatlarinigizga javob olishingiz mumkin.",
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

        if(isset($message['text']) && $message['text'] == '📃 Murojaat qoldirish'){

            $this->user->step = "get_message";
            $this->user->save();

            $this->stepHander($message);
            return 1;
        }

        if ($this->user->step != "") {
            $this->setHandler($message);
            return true;
        }

    }

    public function stepHander($message)
    {

        if ($this->user->step == 'get_date_birth') {
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
                'text' => "📌 Yaxshi, endi iltimos tug'ilgan sanangizni quyidagi formatda kiriting!<i><b>Masalan:</b> 10.02.1998</i>",
                'reply_markup' => $keyboard,
                'parse_mode' => 'html'
            ]);
        }
        if ($this->user->step == 'get_gender') {
            $keyboard = json_encode([
                'keyboard' =>
                    [
                        [
                            ['text' => '👨 Erkak'],
                            ['text' => '👩 Ayol']
                        ]
                    ],
                'resize_keyboard' => true,
            ]);
            $this->bot('sendMessage', [
                'chat_id' => $this->user->user_id,
                'text' => "📌 Jinsizngizni tanlang!",
                'reply_markup' => $keyboard,
                'parse_mode' => 'html'
            ]);
        }
        if ($this->user->step == 'get_street') {

            $keyboard = json_encode([

                'keyboard' => $this->getStreetArray(),
                'resize_keyboard' => true,
            ]);

            $this->bot('sendMessage', [
                'chat_id' => $this->user->user_id,
                'text' => '<b>' . $this->user->full_name . '</b>' . ", Iltimos,hududungizni tanlang!",
                'parse_mode' => 'html',
                'reply_markup' => $keyboard,
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
        if ($this->user->step == 'get_message') {
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
                'text' => "📌 <b>Obod MFY</b> yoshlar yetakchisi <b>Islomjon Muhammadjonovga</b> murojaatingizni yozib qoldiring!",
                'reply_markup' => $keyboard,
                'parse_mode' => 'html'
            ]);
        }
        if ($this->user->step == 'get_end') {
            $keyboard = json_encode([
                'keyboard' =>
                    [
                        [
                            ['text' => '🏠 Bosh sahifa'],
                            ['text' => '📃 Murojaat qoldirish']
                        ],
                    ],
                'resize_keyboard' => true,
            ]);

            $this->bot('sendMessage', [
                'chat_id' => $this->user->user_id,
                'text' => "📌 Xabaringiz uchun rahmat.Men 10 daqiqada siz bilan bog’lanaman. Ishingizga rivoj!\n\n Sizning yoshlar yetakchingiz.\n<b>Islomjon Muhammadjonov \n(+998999948782)</b>\n\nMeni tezlik bilan topish uchun quyida joylashuvimni yuboryabman👇",
                'reply_markup' => $keyboard,
                'parse_mode' => 'html'
            ]);

            $this->bot('sendLocation', [
                'chat_id' => $this->user->user_id,
                'latitude' => '40.170347',
                'longitude' => '71.731552',
            ]);

            $newData = Json::decode($this->user->data);

            if ($newData) {

                $street = Quarters::findOne(['id' => $this->user->street_id])->title;
                $client = Client::findOne(['id' => $this->user->id]);
                $gender = '';
                if ($client->gender == Client::TYPE_GENDER_A) {

                    $gender = "Ayol";
                }
                if ($client->gender == Client::TYPE_GENDER_E) {

                    $gender = 'Erkak';
                }
                $this->bot('sendMessage', [
                    'chat_id' => "-1001694795524",
                    'text' => "⚡ Yangi murojaat\n <b>F.I.O:</b> {$newData['fio']}\n<b>Hudud: </b> {$street}\n<b>Tug'ilgan sanasi:</b> {$newData['date_birth']}\n<b>Jinsi: </b>{$gender}\n<b>Tel: </b>{$newData['phone']}\n<b>Murojaat matni: </b>{$newData['message']}",
                    'parse_mode' => 'html'
                ]);
            }

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
                $this->setStep('get_date_birth');
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

        if ($this->user->step == 'get_date_birth') {
            if (!preg_match("/^(0[1-9]|[1-2][0-9]|3[0-1]).(0[1-9]|1[0-2]).[0-9]{4}$/", $message['text'])) {
                $this->bot('sendMessage', [
                    'chat_id' => $this->user->user_id,
                    'text' => '<b>Iltimos</b>, quyidagicha kiriting: <i>10.02.1998</i>',
                    'parse_mode' => 'html'
                ]);
            } else {
                $this->saveData('date_birth', $message['text']);
                $this->setStep('get_gender');
                $this->stepHander($message);
                return 1;
            }

        }

        if ($this->user->step == 'get_gender') {

            if ($message['text'] == '👨 Erkak' || $message['text'] == '👩 Ayol') {

                $genderUser = Client::findOne(['id' => $this->user->id]);

                if ($message['text'] == '👨 Erkak') {

                    $genderUser->gender = Client::TYPE_GENDER_E;
                    $genderUser->save(false);
                }
                if ($message['text'] == '👩 Ayol') {

                    $genderUser->gender = Client::TYPE_GENDER_A;
                    $genderUser->save(false);
                }
                $this->setStep('get_street');
                $this->stepHander($message);
                return 1;
            } else {
                $this->bot('sendMessage', [
                    'chat_id' => $this->user->user_id,
                    'text' => '❗ <b>Jinsingizni tanlang</b>',
                    'parse_mode' => 'html'
                ]);
            }
        }

        if ($this->user->step == 'get_street') {

            $street = Quarters::findOne(['title' => $message['text']]);

            if ($street) {
                $userModel = Client::findOne(['id' => $this->user->id]);
                $userModel->street_id = $street->id;
                $userModel->save(false);
                $this->setStep('get_phone');
                $this->stepHander($message);
                return 1;

            } else {
                $this->bot('sendMessage', [
                    'chat_id' => $this->user->user_id,
                    'text' => '❗️<b>Hududni tanlang!</b>',
                    'parse_mode' => 'html'
                ]);
            }
        }

        if ($this->user->step == 'get_phone')
        {
            if ($message['contact']['phone_number']) {
                $this->saveData('phone', $message['contact']['phone_number']);
                $this->setStep('get_message');
                $this->stepHander($message);
                return 1;
            }
            if (!preg_match("/\+[9][9][8] [389][013789] [0-9][0-9][0-9] [0-9][0-9] [0-9][0-9]/", $message->text)) {
                $this->bot('sendMessage',[
                    'text' =>'Iltimos, quyidagicha kiriting: +998931234567',
                    'chat_id' => $this->user->user_id,
                ]);
            } else {
                $this->saveData('phone', $message['text']);
                $this->setStep('get_message');
                $this->stepHander($message);
                return 1;
            }
            return 1;

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

    public function bot($method, $data = [], $token = '5241136730:AAEVkfXP8djat5kgAmD7WVygHjKvKwntUCw')
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://api.telegram.org/bot' . $token . '/' . $method);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $res = curl_exec($ch);
        return json_decode($res);

    }

}