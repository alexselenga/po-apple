<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model common\models\Apple */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Яблоки', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="apple-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php Pjax::begin([ 'id' => 'pjaxAppleView' ]); ?>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
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
                'value' => $model::STATUSES[$model->status],
            ],
            [
                'attribute' => 'size',
                'value' => $model->size * 100 . '%',
            ],
        ],
    ]) ?>

    <div class="form-group">
        <?= Html::button('Упасть', ['class' => 'btn btn-success', 'id' => 'apple-fall', 'disabled' => $model->status != $model::STATUS_HANGING]) ?>
        <hr>
        <?= Html::textInput('Упасть', null, ['id' => 'apple-eat-percent', 'disabled' => $model->status != $model::STATUS_FALLED]) ?>
        <?= Html::button('Съесть', ['class' => 'btn btn-danger', 'id' => 'apple-eat', 'disabled' => $model->status != $model::STATUS_FALLED]) ?>
    </div>

    <?php Pjax::end(); ?>
</div>
