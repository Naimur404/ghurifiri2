<?php

use Botble\Widget\AbstractWidget;

class CategoriesMenuWidget extends AbstractWidget
{
    public function __construct()
    {
        parent::__construct([
            'name' => __('Categories menu'),
            'description' => __('Show categories menu and number posts'),
            'number_display' => 5,
            'name_custom_class' => '',
        ]);
    }
}
