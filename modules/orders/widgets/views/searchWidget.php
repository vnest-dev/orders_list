<?php

use yii\helpers\Url;
use yii\helpers\Html;

/**

 * @var $filters array
 */

?>

<?= Html::beginForm([Url::to('orders/index')], 'get', ['class' => 'form-inline']) ?>

<div class="input-group">
    <?= Html::input('text', 'search', $filters['search'], ['class' => 'form-control', 'placeholder' =>  Yii::t('messages', "orders.search.search")]) ?>
    <?= Html::hiddenInput('status', $filters['status']) ?>


    <span class="input-group-btn search-select-wrap">

        <?= Html::dropDownList(
            'search-type',
            $filters['search-type'],
            [
                'id' => Yii::t('messages','orders.search.order_id'),
                'link' => Yii::t('messages','orders.search.link'),
                'username' => Yii::t('messages','orders.search.username')
            ],
            ['class' => 'form-control search-select']
        ) ?>



        <?= Html::submitButton(
            '<span class="glyphicon glyphicon-search" aria-hidden="true"></span>',
            ['class' => 'btn btn-default']
        ) ?>

    </span>

</div>

<?= Html::endForm() ?>
