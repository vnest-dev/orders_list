<?php
/**
 * @var $modes array
 */

use yii\helpers\Url;
use yii\helpers\Html;

?>

<div class="dropdown">
    <?= Html::button(Yii::t('messages', 'orders.mode') . " <span class='caret'></span>", [
            'class'=>'btn btn-th btn-default dropdown-toggle',
            'type'=>'button',
            'id'=>'dropdownMenu1',
            'data-toggle'=>'dropdown',
            'aria-haspopup'=>'true',
            'aria-expanded'=>'true'
            ]
       ) ?>
    <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
        <?php  foreach ($modes as $key => $mode): ?>
            <li class="<?= $mode['isActive'] ? 'active' : '' ?>">
                <a href="<?= Url::toRoute($mode['link']) ?>"><?= Yii::t('messages', 'orders.mode.' . $mode['name']) ?></a>
            </li>
        <?php endforeach; ?>
    </ul>
</div>
