<?php

namespace app\controllers;


use app\models\TasaDia;
use Yii;
use app\models\Request;
use app\models\UserAccount;
use app\models\search\RequestSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
//use aki\telegram\Telegram;

/**
 * RequestController implements the CRUD actions for Request model.
 */
class RequestController extends BaseController
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Request models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new RequestSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'saldo' => ArrayHelper::getValue(UserAccount::find()->where(['id_user' => Yii::$app->user->id])->one(),'btc_amount'),
            'tasa_bolivar' => ArrayHelper::getValue(TasaDia::find()->orderBy(['id'=>SORT_DESC])->one(),'valor_bolivar'),
            'tasa_dolar' => ArrayHelper::getValue(TasaDia::find()->orderBy(['id'=>SORT_DESC])->one(),'valor_dolar'),
        ]);
    }

    /**
     * Displays a single Request model.
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
    
    public function actionDashboard()
    {
        $model = new Request();
        $model->id_user = Yii::$app->user->identity->id;
        $model->id_request_status = 1;
        $model->date = date("Y-m-d H:i:s");
        if ($model->load(Yii::$app->request->post())) {
            if($model->save())
            {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }
    /**
     * Creates a new Request model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Request();
        if(Yii::$app->user->identity->id_user_rol != '1')
            $model->id_user = Yii::$app->user->identity->id;
        $model->id_request_status = 1;
        $model->date = date("Y-m-d H:i:s");
        if ($model->load(Yii::$app->request->post())) {
            if($model->save())
            {
                if(Yii::$app->user->identity->name != 'admin') {
                    Yii::$app->telegram->sendMessage([
                        'chat_id' => '-1001235461397',
                        'text' => 'Se ha hecho una nueva solicitud. Usuario:' . Yii::$app->user->identity->name . ' ' . Yii::$app->user->identity->surname,
                    ]);
                }
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Request model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Request model.
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
     * Finds the Request model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Request the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Request::findOne($id)) !== null) {
            //echo '<pre>'; print_r($model); echo '</pre>';
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    protected function findModelByUser($id)
    {
        if (($model = UserAccount::find()->asArray()->andwhere(['id_user' => $id])->all()) !== null) {
            //echo '<pre>'; print_r($model); echo '</pre>';
            return $model->btc_amount;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
