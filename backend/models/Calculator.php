<?php
namespace backend\models;

use Yii;
use DateTime;
use DatePeriod;
use DateInterval;
use yii\base\Model;
use common\models\Post;
use kartik\daterange\DateRangeBehavior;

/**
 * Calculator
 */
class Calculator extends Model
{
    public $timeRange;
    public $timeStart;
    public $timeEnd;

    public function behaviors()
    {
        return [
            [
                'class' => DateRangeBehavior::className(),
                'attribute' => 'timeRange',
                'dateStartAttribute' => 'timeStart',
                'dateEndAttribute' => 'timeEnd',
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['timeRange'], 'match', 'pattern' => '/^.*\s\-\s.*$/'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Generates dates between given start time and end time
     *
     * @return array
     */
    public static function generateDates($timeStart, $timeEnd)
    {
        $dates = [];
        if ($timeStart >= $timeEnd) {
            return $dates;
        }

        $oneDay = new DateInterval('P1D');
        $dateTimeStart = (new DateTime())->setTimestamp($timeStart);
        $dateTimeEnd = (new DateTime())->setTimestamp($timeEnd);

        $dateRange = new DatePeriod($dateTimeStart, $oneDay ,$dateTimeEnd);

        foreach ($dateRange as $dateTime) {
            $dates[] = $dateTime->format("Y-m-d");
        }

        return $dates;
    }

    /**
     * Gets the start Unix timestamp
     *
     * @return integer a Unix timestamp
     */
    protected function getTimeStart()
    {
        if ($this->timeStart) {
            return $this->timeStart;
        } else {
            $dateTime = new DateTime();
            $dateTime->setTimestamp($this->getTimeEnd());
            $dateTime->sub(new DateInterval('P1M'));
            $dateTime->setTime(0, 0);

            return $dateTime->getTimestamp();
        }
    }

    /**
     * Gets the end Unix timestamp
     *
     * @return integer a Unix timestamp
     */
    protected function getTimeEnd()
    {
        return $this->timeEnd ?: time();
    }

    /**
     * Daily posts
     *
     * @param array $params
     * @return array
     */
    public function dailyPosts($params)
    {
        $this->load($params);

        if (!$this->validate()) {
            return [];
        }

        $timeStart = $this->getTimeStart();
        $timeEnd = $this->getTimeEnd();

        // calculation
        $results = Post::find()
            ->select([
                'date' => 'date(from_unixtime(createdAt))',
                'count' => 'count(id)'
            ])
            ->andFilterWhere(['>=', 'createdAt', $timeStart])
            ->andFilterWhere(['<', 'createdAt', $timeEnd])
            ->groupBy('date')
            ->orderBy('date')
            ->createCommand()
            ->queryAll(\PDO::FETCH_KEY_PAIR);

        array_walk($results, function(&$value) {
            $value = (int) $value;
        });

        $dates = static::generateDates($timeStart, $timeEnd);
        $results = array_merge(array_fill_keys($dates, 0), $results);

        return $results;
    }
}
