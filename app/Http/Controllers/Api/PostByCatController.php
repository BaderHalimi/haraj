<?php

namespace App\Http\Controllers\Api;

use App\Models\Post;
use App\Http\Resources\PostByCatResource;
use App\Scopes\VerifiedScope;
use App\Scopes\ReviewedScope;

class PostByCatController extends BaseController
{
    /**
     * Get posts by category_id
     *
     * @urlParam id int required The category ID. Example: 1
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $isDetailed = (request()->filled('detailed') && (int)request()->get('detailed') == 1);

        if ($isDetailed) {
            
            $defaultEmbed = ['user', 'category', 'parent', 'postType', 'city', 'savedByLoggedUser', 'pictures', 'latestPayment', 'package'];
            if (request()->has('embed')) {
                $embed = explode(',', request()->get('embed', ''));
                $embed = array_merge($defaultEmbed, $embed);
                request()->query->set('embed', implode(',', $embed));
            } else {
                request()->query->add(['embed' => implode(',', $defaultEmbed)]);
            }

            return $this->showPost($id);

        } else {
            $isUnactivatedIncluded = (request()->filled('unactivated') && (int)request()->get('unactivated') == 1);

            $cacheDriver = config('cache.default');
            $cacheExpiration = $this->cacheExpiration;

            $cacheId = 'posts.category.' . $id . '.' . config('app.locale');
            $posts = cache()->remember($cacheId, $cacheExpiration, function () use ($isUnactivatedIncluded, $id) {
                $posts = Post::query();

                if ($isUnactivatedIncluded) {
                    $posts->withoutGlobalScopes([VerifiedScope::class, ReviewedScope::class]);
                }

                $embed = explode(',', request()->get('embed'));

                if (in_array('country', $embed)) {
                    $posts->with('country');
                }
                if (in_array('user', $embed)) {
                    $posts->with('user');
                }
                if (in_array('postType', $embed)) {
                    $posts->with('postType');
                }
                if (in_array('city', $embed)) {
                    $posts->with('city');
                }
                if (in_array('latestPayment', $embed)) {
                    $posts->with('latestPayment');
                }
                if (in_array('savedByLoggedUser', $embed)) {
                    $posts->with('savedByLoggedUser');
                }
                if (in_array('pictures', $embed)) {
                    $posts->with('pictures');
                }

                // Adjust the condition to filter by category_id
                $posts->where('category_id', $id);

                return $posts->get(); // Use get() to get a collection
            });

            // Reset caching parameters
            config()->set('cache.default', $cacheDriver);

            abort_if($posts->isEmpty(), 404, t('posts_not_found'));

            // Return the resource as a collection
            $resource = PostByCatResource::collection($posts);

            return $this->respondWithResource($resource);
        }
    }
}
