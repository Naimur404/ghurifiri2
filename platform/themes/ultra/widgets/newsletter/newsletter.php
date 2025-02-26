<?php

use Botble\Widget\AbstractWidget;

class NewsletterWidget extends AbstractWidget
{
    public function __construct()
    {
        parent::__construct([
            'name' => 'Newsletter',
            'description' => __('Subscribe to Our Newsletter'),
        ]);
    }
}
