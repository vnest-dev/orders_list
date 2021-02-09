<?php
/**
 * @var $statuses array
 */

use yii\helpers\Url;

?>

<div class="dropdown">
    <button class="btn btn-th btn-default dropdown-toggle" type="button" id="dropdownMenu1"
            data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
        Mode
        <span class="caret"></span>
    </button>
    <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
        <?php  foreach ($modes as $key => $mode): ?>
            <li class="<?= $mode['isActive'] ? 'active' : '' ?>"><a href="<?= Url::toRoute($mode['link']) ?>"><?= Yii::t('app', $mode['name']) ?></a>
            </li>
        <?php endforeach; ?>
    </ul>
</div>
