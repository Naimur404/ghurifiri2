<?php

use Botble\Widget\AbstractWidget;

class LastestPostsWidget extends AbstractWidget
{
    public function __construct()
    {
        parent::__construct([
            'name' => 'Lastest Posts',
            'description' => __('Widget to display lastest posts'),
            'number_display' => 5,
            'name_custom_class' => '',
        ]);
    }
}
