<?php

use Botble\Widget\AbstractWidget;

class AuthorWidget extends AbstractWidget
{
    public function __construct()
    {
        parent::__construct([
            'name' => __('Author'),
            'description' => __('Introduction about the author of this article'),
            'image' => null,
        ]);
    }
}
