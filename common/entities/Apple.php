<?php

namespace common\entities;

use common\models\Apple as AppleModel;
use Error;

class Apple
{
    const colors = ['red', 'green', 'blue'];

    /**
     * @var AppleModel|null
     */
    protected $appleModel = null;


    public function __construct($color)
    {
        $model = new AppleModel;
        $model->color = $color;
        $this->appleModel->appear_date = time() - random_int(3600 * 3, 3600 * 7);
        $model->save();
        $this->appleModel = $model;
    }

    public static function generateApples($count = 10)
    {
        for ($i = 1; $i < $count; $i++) {
            $color = static::colors[random_int(0, count(static::colors) - 1)];
            new Apple($color);
        }
    }

    public static function removeApples()
    {
        AppleModel::deleteAll();
    }

    public function selectApple($id): bool
    {
        $this->appleModel = AppleModel::findOne($id);
        return is_object($this->appleModel);
    }

    public function getColor(): string|null
    {
        return $this->appleModel ? $this->appleModel->color : null;
    }

    public function getSize(): float|null
    {
        return $this->appleModel ? $this->appleModel->size : null;
    }

    public function getStatus(): int|null
    {
        if (!$this->appleModel) return null;
        $this->checkStatus();
        return $this->appleModel->status;
    }

    public function fallToGround()
    {
        if (!$this->appleModel) return;

        if (AppleModel::STATUS_HANGING) {
            $this->appleModel->status = AppleModel::STATUS_FALLED;
            $this->appleModel->fall_date = time();
            $this->appleModel->save();
        }
    }

    public function eat($percent)
    {
        if ($percent < 0 || $percent > 100) return;
        if (!$this->appleModel) return;

        $this->checkStatus();

        if ($this->appleModel->status != AppleModel::STATUS_FALLED) {
            throw new Error('Яблоко еще на дереве!');
        }

        $this->appleModel->size = $this->appleModel->size - $percent / 100;

        if ($this->appleModel->size > 0) {
            $this->appleModel->save();
        } else {
            $this->delete();
        }
    }

    public function delete()
    {
        if (!$this->appleModel) return;

        $this->appleModel->delete();
        $this->appleModel = null;
    }

    protected function checkStatus()
    {
        if (!$this->appleModel) return;

        if ($this->appleModel->status == AppleModel::STATUS_FALLED) {
            $fallHours = (time() - $this->appleModel->fall_date) / 3600;

            if ($fallHours >= 5) {
                $this->appleModel->status = AppleModel::STATUS_BAD;
                $this->appleModel->save();
            }
        };
    }
}