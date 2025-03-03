<?php

namespace backend\controllers;

use backend\models\SendMessage;
use common\models\Client;
use common\models\search\ClientSearch;
use Yii;
use yii\helpers\Url;
use yii\helpers\VarDumper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\UploadedFile;

/**
 * ClientController implements the CRUD actions for Client model.
 */
class ClientController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
                'access' => [
                    'class' => AccessControl::className(),
                    'rules' => [
                        [
                            'allow' => true,
                            'roles' => ['@'],
                        ],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Client models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ClientSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Client model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Client model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Client();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Client model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Client model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Client model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Client the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Client::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionSelect(){

        $selects = Yii::$app->request->post('selection');

        Yii::$app->session->set('selects',$selects);

        $selectForm = new SendMessage();

        return $this->render('selectForm',[
            'selectForm' => $selectForm
        ]);
    }

    public function actionSendMessage(){

        $selectForm = new SendMessage();

        $selects = Yii::$app->session->get('selects');

        if ($selectForm->load(Yii::$app->request->post())){

            $gender = $selectForm->gender;

            $selectForm->img = UploadedFile::getInstance($selectForm, 'img');

            if ($selectForm->validate() && isset($selectForm->img)) {

                $selectForm->img->saveAs('@frontend/web/uploads/smsfile/' . $selectForm->img->baseName . '.' . $selectForm->img->extension);

                $fileName = Yii::getAlias('@frontend/web/uploads/smsfile/') . $selectForm->img->baseName . '.' . $selectForm->img->extension;

                $url = 'https://buston11-maktab.uz/frontend/web/uploads/smsfile/'.$selectForm->img->baseName . '.' . $selectForm->img->extension;

                if (isset($selectForm->img)) {

                    foreach ($selects as $select) {

                        if ($gender == Client::TYPE_GENDER_A){

                            $client = Client::find()
                                ->andWhere(['id' => $select])
                                ->andWhere(['gender' => Client::TYPE_GENDER_A])
                                ->one();
                        }
                        if ($gender == Client::TYPE_GENDER_E){

                            $client = Client::find()
                                ->andWhere(['id' => $select])
                                ->andWhere(['gender' => Client::TYPE_GENDER_E])
                                ->one();
                        }
                        if ($gender == 2){

                            $client = Client::find()
                                ->andWhere(['id' => $select])
                                ->one();
                        }

                        if($client){
                            $this->bot('sendPhoto', [
                                'chat_id' => $client->user_id,
                                'photo' => $url,
                                'caption' => $selectForm->message,
                                'parse_mode' => 'html'
                            ]);
                        }
                    }
                }

            }

            if (!isset($selectForm->img)) {

                foreach ($selects as $select) {

                    if ($gender == Client::TYPE_GENDER_A){

                        $client = Client::find()
                            ->andWhere(['id' => $select])
                            ->andWhere(['gender' => Client::TYPE_GENDER_A])
                            ->one();
                    }
                    if ($gender == Client::TYPE_GENDER_E){

                        $client = Client::find()
                            ->andWhere(['id' => $select])
                            ->andWhere(['gender' => Client::TYPE_GENDER_E])
                            ->one();
                    }
                    if ($gender == 2){

                        $client = Client::find()
                            ->andWhere(['id' => $select])
                            ->one();
                    }

                    if ($client){

                        $this->bot('sendMessage', [
                            'chat_id' => $client->user_id,
                            'text' => $selectForm->message,
                            'parse_mode' => 'html'
                        ]);
                    }
                }
            }

        }
        if (isset($selectForm->img)){
            unlink($fileName);
        }

        Yii::$app->session->remove('selects');
        return $this->redirect(['client/index']);

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
