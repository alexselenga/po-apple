<?php

namespace backend\controllers;

use common\entities\AppleInterface;
use common\entities\Apple;
use Yii;
use common\models\Apple as AppleModel;
use common\models\AppleSearch;
use yii\filters\AccessControl;
use yii\web\Controller;

/**
 * AppleController implements the CRUD actions for Apple model.
 */
class AppleController extends Controller
{
    /**
     * @var AppleInterface
     */
    public $appleClass = Apple::class;

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionGenerate()
    {
        $this->appleClass::generateApples();
        return 0;
    }

    public function actionFallToGround($id)
    {
        $apple = $this->appleClass::getApple($id);
        $apple->fallToGround();
        return 0;
    }

    public function actionEat($id, $percent)
    {
        $apple = $this->appleClass::getApple($id);
        $apple->eat($percent);
        return 0;
    }

    /**
     * Lists all Apple models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AppleSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Apple model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = AppleModel::findOne($id);

        if (!$model) {
            $this->redirect($this->defaultAction);
        }

        return $this->render('view', [
            'model' => $model,
        ]);
    }
}
