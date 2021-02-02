<?php use yii\widgets\LinkPager;

foreach($dataProvider->getModels() as $model): ?>
    <p><?= $model->users->first_name ?></p>
<?php endforeach; ?>

<?= LinkPager::widget([
    'pagination' => $dataProvider->pagination,
]) ?>