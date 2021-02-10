<?php

use yii\helpers\Html;
use yii\helpers\Url;

?>

<?= Html::beginForm(['download'], 'post') ?>
<div class="col-md-10"></div>
<div class="col-md-2 ml-4">
    <?= Html::submitButton(Yii::t('messages','orders.save.save'), ['class'=>'btn btn-primary']) ?>
</div>
<?= Html::endForm() ?>
