<?php

use yii\helpers\Html;
use yii\helpers\Url;

?>


<?= Html::beginForm(['download'], 'post') ?>
<div class="col-md-10"></div>
<div class="col-md-2 ml-4">
    <button type="submit" class="btn btn-primary">Save result</button>
</div>
<?= Html::endForm() ?>
