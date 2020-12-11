<?php

namespace app\controllers;

use app\models\search\TransactionSearch;
use app\models\SignupForm;
use app\models\UserAccount;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\PasswordResetRequestForm;
use app\models\ResetPasswordForm;
use app\models\TasaDia;
use yii\helpers\ArrayHelper;


class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $model = new TasaDia();
        return $this->render('index', [
            'tasa_bolivar' => ArrayHelper::getValue(TasaDia::find()->orderBy(['id'=>SORT_DESC])->one(),'valor_bolivar'),
            'tasa_dolar' => ArrayHelper::getValue(TasaDia::find()->orderBy(['id'=>SORT_DESC])->one(),'valor_dolar'),
        ]);
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();

        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            //return $this->goBack();
            $searchModel = new TransactionSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
            return $this->render('/transaction/index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'saldo' => ArrayHelper::getValue(UserAccount::find()->where(['id_user' => Yii::$app->user->id])->one(),'btc_amount'),
                'tasa_bolivar' => ArrayHelper::getValue(TasaDia::find()->orderBy(['id'=>SORT_DESC])->one(),'valor_bolivar'),
                'tasa_dolar' => ArrayHelper::getValue(TasaDia::find()->orderBy(['id'=>SORT_DESC])->one(),'valor_dolar'),
            ]);
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionSignup()
    {
        $model = new SignupForm();

        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    if(Yii::$app->user->identity->name != 'admin'){
                        Yii::$app->telegram->sendMessage([
                            'chat_id' => '-396503432',
                            'text' => 'Se ha registrado un nuevo usuario. Usuario:'.Yii::$app->user->identity->name.' '.Yii::$app->user->identity->surname,
                        ]);
                    }
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->getSession()->setFlash('success', 'Check your email for further instructions.');
                return $this->redirect(['html' => 'passwordResetToken-html', 'text' => 'passwordResetToken-text']);
                //return $this->goHome();
            } else {
                Yii::$app->getSession()->setFlash('error', 'Sorry, we are unable to reset password for email provided.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    public function actionResetPassword()
    {
        // try {
        $model = new ResetPasswordForm();
        /* } catch (InvalidParamException $e) {
             throw new BadRequestHttpException($e->getMessage());
         }*/

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->getSession()->setFlash('success', 'New password was saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }
}
