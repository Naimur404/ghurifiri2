<?php

use Botble\Widget\AbstractWidget;

class AdsWidget extends AbstractWidget
{
    public function __construct()
    {
        parent::__construct([
            'name' => __('Ads'),
            'description' => __('Widget to display ads'),
            'ads_location' => null,
        ]);
    }
}
