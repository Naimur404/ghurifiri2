<?php

use Botble\Widget\AbstractWidget;

class SocialsWidget extends AbstractWidget
{
    public function __construct()
    {
        parent::__construct([
            'name' => __('Socials'),
            'description' => __('Widget to display socials'),
            'title' => 'Follow us',
        ]);
    }
}
