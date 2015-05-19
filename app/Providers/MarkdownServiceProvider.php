<?php
/**
 * only uses the gfm whitespace extension for linebreaks, check out the ciconia repository for more options
 */

namespace App\Providers\ServiceProvider;

use Ciconia\Ciconia;
use Ciconia\Extension\Gfm;
use Illuminate\Support\ServiceProvider;

class MarkdownServiceProvider extends ServiceProvider {

    public function register()
    {
        $this->app->bind('markdown', function()
        {
            $ciconia = new Ciconia();
            $ciconia->addExtension(new Gfm\WhiteSpaceExtension());
            
            return $ciconia;
        });
    }
}