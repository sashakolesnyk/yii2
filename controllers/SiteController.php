<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Logs;
use yii\data\ActiveDataProvider;
use yii\db\Query;
use yii\data\SqlDataProvider;

class SiteController extends Controller
{
    /**
     * @inheritdoc
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
     * @inheritdoc
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
		//проверка - если нажата кнопка генерации - то 1)очистить таблицю; 2)записать 200 штук
		if ($_GET['pressed']) {
			Logs::deleteAll(); // видаляє всі дані з таблиці logs
			
			Logs::generate200items(); //створює 200 нових тестових записів, де значення time має бути в періоді часу за останній рік і значення key - це 8 випадкових символів латинського алфавіту
			
			return $this->redirect(['']);
		}
		
		//вывод по умолчанию (если не нажата кнопка генерации
		$logs = Logs::find()->all();
		
		//WIDGET
		
		$count = Yii::$app->db->createCommand('SELECT COUNT(*) FROM logs')->queryScalar();
		
		
		
		$dataProvider = new SqlDataProvider([
			'sql' => 'SELECT * FROM logs',
			'totalCount' => $count,			
			'pagination' => ['pageSize' => 20],
			'sort' => ['attributes' => ['time']],
		]);
		$models = $dataProvider->getModels();
		
		
        return $this->render('index', ['logs' => $logs, 'dataProvider' => $dataProvider]);
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
            return $this->goBack();
        }
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
}
