<?php

namespace Botble\PostCollection;

use Botble\PluginManagement\Abstracts\PluginOperationAbstract;
use Illuminate\Support\Facades\Schema;

class Plugin extends PluginOperationAbstract
{
    public static function remove()
    {
        Schema::dropIfExists('post_collections');
        Schema::dropIfExists('post_collections_posts');
    }
}
