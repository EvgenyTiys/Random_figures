<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\Json;

/**
 * Experiment model
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $correct_sequence
 * @property string $user_sequence
 * @property integer $correct_count
 * @property integer $current_trial
 * @property boolean $is_completed
 * @property string $created_at
 * @property string $completed_at
 *
 * @property User $user
 */
class Experiment extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'experiments';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'correct_sequence'], 'required'],
            [['user_id', 'correct_count', 'current_trial'], 'integer'],
            [['is_completed'], 'boolean'],
            [['correct_sequence', 'user_sequence'], 'string'],
            [['created_at', 'completed_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'correct_sequence' => 'Correct Sequence',
            'user_sequence' => 'User Sequence',
            'correct_count' => 'Correct Count',
            'current_trial' => 'Current Trial',
            'is_completed' => 'Is Completed',
            'created_at' => 'Created At',
            'completed_at' => 'Completed At',
        ];
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * Generate random sequence of 20 shape IDs
     *
     * @return string JSON encoded array
     */
    public static function generateRandomSequence()
    {
        $sequence = [];
        for ($i = 0; $i < 20; $i++) {
            $sequence[] = rand(1, 3); // 1=circle, 2=triangle, 3=square
        }
        return Json::encode($sequence);
    }

    /**
     * Get correct sequence as array
     *
     * @return array
     */
    public function getCorrectSequenceArray()
    {
        return Json::decode($this->correct_sequence);
    }

    /**
     * Get user sequence as array
     *
     * @return array
     */
    public function getUserSequenceArray()
    {
        return $this->user_sequence ? Json::decode($this->user_sequence) : [];
    }

    /**
     * Add user guess to the sequence
     *
     * @param integer $shapeId
     */
    public function addUserGuess($shapeId)
    {
        $userSequence = $this->getUserSequenceArray();
        $userSequence[] = $shapeId;
        $this->user_sequence = Json::encode($userSequence);
        
        $correctSequence = $this->getCorrectSequenceArray();
        if ($correctSequence[$this->current_trial - 1] == $shapeId) {
            $this->correct_count++;
        }
        
        $this->current_trial++;
        
        if ($this->current_trial > 20) {
            $this->is_completed = true;
            $this->completed_at = date('Y-m-d H:i:s');
        }
    }

    /**
     * Get comparison results for display
     *
     * @return array
     */
    public function getComparisonResults()
    {
        $correctSequence = $this->getCorrectSequenceArray();
        $userSequence = $this->getUserSequenceArray();
        $results = [];
        
        for ($i = 0; $i < count($userSequence); $i++) {
            $results[] = [
                'trial' => $i + 1,
                'correct' => $correctSequence[$i],
                'user' => $userSequence[$i],
                'is_correct' => $correctSequence[$i] == $userSequence[$i]
            ];
        }
        
        return $results;
    }
}