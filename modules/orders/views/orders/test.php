<?php

echo \orders\components\StatusWidget::widget(['statuses' => $statuses]);
echo \orders\components\ModeWidget::widget(['modes' => $modes]);
echo \orders\components\ServiceWidget::widget(['services' => $services]);
echo \orders\components\SearchWidget::widget();
