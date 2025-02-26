<?php

use Botble\Widget\AbstractWidget;

class CopyrightFooterMenuWidget extends AbstractWidget
{
    public function __construct()
    {
        parent::__construct([
            'name' => __('Copyright footer Menu'),
            'description' => __('Add a custom menu to your widget area.'),
            'menu_id' => null,
        ]);
    }
}
