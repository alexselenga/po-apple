<?php

namespace common\entities;

use common\models\Apple as AppleModel;
use Error;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;

class Apple implements AppleInterface
{
    const colors = ['Красное', 'Зеленое', 'Желтое', 'Розовое', 'Оранжевое'];

    /**
     * @var AppleModel|null
     */
    protected $_appleModel = null;


    public function __construct($color = null)
    {
        if (is_null($color)) return; //Не создаем запись в БД

        $model = new AppleModel;
        $model->loadDefaultValues();
        $model->color = $color;
        $model->appear_date = \Yii::$app->formatter->asDate(time() - random_int(0, 3600 * 10), 'php:Y-m-d H:i');
        $this->_appleModel = $model;
        $this->save();
    }

    public static function getApple($id): AppleInterface
    {
        $appleModel = AppleModel::findOne($id);

        if (!$appleModel) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $result = new Apple();
        $result->_appleModel = $appleModel;
        return $result;
    }

    public static function generateApples($count = 10)
    {
        static::removeApples();

        for ($i = 0; $i < $count; $i++) {
            $color = static::colors[random_int(0, count(static::colors) - 1)];
            new Apple($color);
        }
    }

    public static function removeApples()
    {
        AppleModel::deleteAll();
    }

    public function fallToGround()
    {
        $appleModel = $this->getAppleModel();

        if (AppleModel::STATUS_HANGING) {
            $appleModel->status = AppleModel::STATUS_FALLED;
            $appleModel->fall_date = \Yii::$app->formatter->asDate(time(), 'php:Y-m-d H:i');
            $this->save();
        }
    }

    public function eat($percent)
    {
        if ($percent < 0 || $percent > 100) return;
        $appleModel = $this->getAppleModel();

        if ($appleModel->status != AppleModel::STATUS_FALLED) {
            throw new Error('Яблоко еще на дереве!');
        }

        $appleModel->size = $appleModel->size - $percent / 100;

        if ($appleModel->size > 0) {
            $this->save();
        } else {
            $this->delete();
        }
    }

    public function delete()
    {
        $this->getAppleModel()->delete();
        $this->_appleModel = null;
    }

    public function getColor(): string
    {
        return $this->getAppleModel()->color;
    }

    public function getSize(): float
    {
        return $this->getAppleModel()->size;
    }

    public function getStatus(): int
    {
        return $this->getAppleModel()->status;
    }

    protected function save()
    {
        $appleModel = $this->getAppleModel();
        $appleModel->save();

        if ($appleModel->hasErrors()) {
            throw new HttpException('Apple entity error on save.');
        }
    }

    protected function getAppleModel(): AppleModel
    {
        if (!$this->_appleModel) {
            throw new HttpException('Apple entity error on get model.');
        };

        return $this->_appleModel;
    }
}