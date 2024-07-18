<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "mo_message_log".
 *
 * @property int $messageId ID
 * @property int|null $memberId
 * @property int $type 类型:1系统2用户3邮件4短信
 * @property string|null $account 发送账号
 * @property string|null $title 标题
 * @property string|null $content 内容
 * @property int|null $state 状态:0:未查看(失败)1:已查看(成功)2:删除
 * @property int|null $inputtime 创建时间
 */
class MessageLog extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mo_message_log';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['memberId', 'type', 'state', 'inputtime'], 'integer'],
            [['content'], 'string'],
            [['account', 'title'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'messageId' => 'Message ID',
            'memberId' => 'Member ID',
            'type' => 'Type',
            'account' => 'Account',
            'title' => 'Title',
            'content' => 'Content',
            'state' => 'State',
            'inputtime' => 'Inputtime',
        ];
    }
}
