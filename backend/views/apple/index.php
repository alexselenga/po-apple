<?php

use common\models\Apple as AppleModel;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\AppleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Яблоки';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="apple-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php Pjax::begin([ 'id' => 'pjaxAppleIndex' ]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'color',
            [
                'attribute' => 'appear_date',
                'format' => 'datetime',
            ],
            [
                'attribute' => 'fall_date',
                'format' => 'datetime',
            ],
            [
                'attribute' => 'status',
                'value' => function (AppleModel $appleModel) {
                    return AppleModel::STATUSES[$appleModel->status];
                },
                'filter' => AppleModel::STATUSES,
            ],
            [
                'attribute' => 'size',
                'value' => function (AppleModel $appleModel) {
                    return $appleModel->size * 100 . '%';
                },
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}',
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

    <div class="form-group">
        <?= Html::button('Повесить яблоки', ['class' => 'btn btn-success', 'id' => 'apples-generate']) ?>
    </div>
</div>
