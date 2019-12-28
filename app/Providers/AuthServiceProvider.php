<?php

namespace App\Providers;

use App\Models\Campaign;
use App\Models\Comment;
use App\Models\Quest;
use App\Models\Resource;
use App\Models\Step;
use App\Policies\CampaignPolicy;
use App\Policies\CommentPolicy;
use App\Policies\QuestPolicy;
use App\Policies\ResourcePolicy;
use App\Policies\StepPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
		Campaign::class => CampaignPolicy::class,
		Quest::class => QuestPolicy::class,
		Step::class => StepPolicy::class,
		Comment::class => CommentPolicy::class,
		Resource::class => ResourcePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
