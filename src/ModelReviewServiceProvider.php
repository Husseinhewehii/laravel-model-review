<?php
namespace Hewehi\ModelReview;

use Illuminate\Support\ServiceProvider;

class ModelReviewServiceProvider extends ServiceProvider
{
    public function register()
    {
        
    }

    public function boot()
    {
        $this->publishes([
            __DIR__ .'/migrations/create_review_table.php.stub' => database_path('migrations/' . date('Y_m_d_His', time()) . '_create_review_table.php'),
        ], 'migrations');

        $this->publishes([
            __DIR__ . '/config/model-review.php' => config_path('model-review.php')
        ], 'config');
    }
}