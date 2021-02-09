<?php
/**
 * @var $statuses array
 */

use yii\helpers\Url;

?>

<?php foreach ($statuses as $key => $status): ?>
    <li class="<?= $status['isActive'] ? 'active' : '' ?>">
        <a href="<?= Url::toRoute($status['link']) ?>"><?= Yii::t('app', $status['name']) ?></a>
    </li>
<?php endforeach; ?>