<?php 
use yii\bootstrap\ActiveForm;
use app\models\Users;
use yii\helpers\Html;

$this->title = Yii::t('app', 'Settings');
$this->params['breadcrumbs'][] = $this->title;

    $form = ActiveForm::begin([
        'layout' => 'horizontal',
        'id' => 'settings-form',
        'options' => ['class' => 'form-horizontal'],
        'method' => 'post'
    ]) ?>
<div class="row" style="margin-top: 20px;">
    <div class="col-sm-8 col-sm-offset-2">
        
        <ul class="list-group">
            <label><?= Yii::t('app', 'Notification settings') ?></label>
            <li class="list-group-item">
                <label class="switch">
                    <?= Html::activeCheckbox($user, 'is_notify_fb',['label'=>false]) ?>
                    <span class="slider round"></span>
                </label>
                <div>
                    <p><b><?= Yii::t('app', 'Notify via message') ?></b></p>
                    <p><?= Yii::t('app', 'Receive notifications via Facebook Messenger, require login with Facebook') . "." ?></p>
                </div>
            </li>
            <li class="list-group-item">
                <label class="switch">
                    <?= Html::activeCheckbox($user, 'is_notify_email',['label'=>false]) ?>
                    <span class="slider round"></span>
                </label>
                <div>
                    <p><b><?= Yii::t('app', 'Notify via email') ?></b></p>
                    <p><?= Yii::t('app', 'Receive notifications via your login email') ."." ?></p>
                </div>
            </li>
            <li class="list-group-item">
                <?= Html::activeDropDownList($user, 'notify_type', Users::aNotifyType(),['class'=>'form-control']) ?>
                <div>
                    <p><b><?= Yii::t('app', 'When notify') . "?" ?></b></p>
                    <p><?= Yii::t('app', 'When do you want to receive notifications, prices increase, prices decrease or both') . "?" ?></p>
                </div>
            </li>
        </ul>
        
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>
</div>
<?php ActiveForm::end() ?>