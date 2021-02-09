<?php
/**
 * @var $statuses array
 */

use yii\helpers\Url;
use yii\helpers\Html;

?>

<?php foreach ($statuses as $key => $status): ?>
    <li class="<?= $status['isActive'] ? 'active' : '' ?>">
        <?= Html::a(Yii::t('app', $status['name']), [Url::toRoute($status['link'])])?>
    </li>
<?php endforeach; ?>