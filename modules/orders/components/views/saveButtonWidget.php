<?php
use yii\helpers\Url;

?>

    <form action="<?= Url::toRoute('download') ?>" method="post">
        <div class="col-md-10"></div>
        <div class="col-md-2 ml-4">
            <button type="submit" class="btn btn-primary" >Save result</button>
        </div>

    </form>
