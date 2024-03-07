<?php

namespace App\JsonApi\V1;

use App\JsonApi\V1\Categories\CategorySchema;
use App\JsonApi\V1\Comments\CommentSchema;
use App\JsonApi\V1\Posts\PostSchema;
use App\JsonApi\V1\Tags\TagSchema;
use App\JsonApi\V1\Users\UserSchema;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use LaravelJsonApi\Core\Server\Server as BaseServer;

class Server extends BaseServer
{

    /**
     * The base URI namespace for this server.
     *
     * @var string
     */
    protected string $baseUri = '/api/v1';

    /**
     * Bootstrap the server when it is handling an HTTP request.
     *
     * @return void
     */
    public function serving(): void
    {
        Auth::shouldUse('sanctum');

        Post::creating(static function (Post $post): void {
            $post->author()->associate(Auth::user());
        });
    }

    /**
     * Get the server's list of schemas.
     *
     * @return array
     */
    protected function allSchemas(): array
    {
        return [
            CommentSchema::class,
            PostSchema::class,
            TagSchema::class,
            UserSchema::class,
            CategorySchema::class,
        ];
    }
}
