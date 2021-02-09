<?php

use yii\helpers\Url;

?>


<form class="form-inline"
      action="<?= Url::toRoute('index') ?>"
      method="get">
    <div class="input-group">
        <input type="text" name="search" class="form-control"
               value=""
               placeholder="Search orders">
        <span class="input-group-btn search-select-wrap">

            <select class="form-control search-select" name="search-type">
              <option value="id">Order ID</option>
              <option value="link">Link</option>
              <option value="username">Username</option>
            </select>
            <button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-search"
                                                                aria-hidden="true"></span></button>
            </span>
    </div>
</form>
