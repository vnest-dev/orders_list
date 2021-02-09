<?php

use yii\helpers\Url;

/**
 * @var $services array
 */
?>
<div class="dropdown">
    <button class="btn btn-th btn-default dropdown-toggle" type="button" id="dropdownMenu1"
            data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
        Service
        <span class="caret"></span>
    </button>
    <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
        <?php foreach ($services as $service): ?>
            <li>
                <a href="<?= Url::toRoute($service['link']) ?>">

                    <?php  if ($service['name'] === 'All'): ?>
                        <?= $service['name'] . ' (' . $service['count'] . ')' ?>
                    <?php else: ?>
                        <span class="label-id"><?= $service['count'] ?></span> <?= $service['name'] ?>
                    <?php endif; ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
</div>