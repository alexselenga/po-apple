<?php

namespace common\models;

/**
 * This is the model class for table "apple".
 *
 * @property int $id ID
 * @property string|null $color Цвет
 * @property string $appear_date Дата появления
 * @property string|null $fall_date Дата падения
 * @property int $status Статус
 * @property float $size Целостность
 */
class Apple extends \yii\db\ActiveRecord
{
    const STATUS_HANGING = 10; //Висит
    const STATUS_FALLED = 20; //Упало
    const STATUS_BAD = 30; //Сгнило

    const STATUSES = [
        self::STATUS_HANGING => 'Висит на дереве',
        self::STATUS_FALLED => 'Упало',
        self::STATUS_BAD => 'Сгнило'
    ];

    const FALLED_HOURS = 5;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'apple';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['color', 'string', 'max' => 255],
            [['color', 'appear_date', 'status', 'size'], 'required'],
            [['appear_date', 'fall_date'], 'safe'],
            ['status', 'integer'],
            ['status', 'in', 'range' => [self::STATUS_HANGING, self::STATUS_FALLED, self::STATUS_BAD]],
            ['status', 'default', 'value' => self::STATUS_HANGING],
            ['size', 'number'],
            ['size', 'compare', 'compareValue' => 0, 'operator' => '>'],
            ['size', 'compare', 'compareValue' => 1, 'operator' => '<='],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'color' => 'Цвет',
            'appear_date' => 'Дата появления',
            'fall_date' => 'Дата падения',
            'status' => 'Статус',
            'size' => 'Целостность',
        ];
    }

    public function afterFind()
    {
        parent::afterFind();

        if ($this->status == static::STATUS_FALLED) {
            $fallHours = (time() - strtotime($this->fall_date)) / 3600;

            if ($fallHours > static::FALLED_HOURS) {
                $this->status = static::STATUS_BAD;
                $this->save();
            }
        };
    }
}
