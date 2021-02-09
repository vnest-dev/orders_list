<?php
/**
 * @var $services array
 */

use yii\helpers\Url;
use yii\helpers\Html;


?>
<div class="dropdown">
    <?= Html::button(
        Yii::t('messages', 'Service') . " <span class='caret'></span>",
        [
            'class' => 'btn btn-th btn-default dropdown-toggle',
            'type' => 'button',
            'id' => 'dropdownMenu1',
            'data-toggle' => 'dropdown',
            'aria-haspopup' => 'true',
            'aria-expanded' => 'true'
        ]
    ) ?>
    <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
        <?php
        foreach ($services as $service): ?>
            <li class="<?= $service['isActive'] ? 'active' : '' ?>">
                <?= Html::a($service['name'], [Url::toRoute($service['link'])]) ?>
            </li>
        <?php
        endforeach; ?>
    </ul>
</div>