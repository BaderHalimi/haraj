<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Arr;
use App\Http\Resources\EntityCollection;
use App\Http\Resources\PostByCityResource;
use App\Models\Post;
use Illuminate\Support\Facades\Event;

/**
 * @group Listings
 */
class PostByCityController extends BaseController
{
    /**
     * Get listing type
     *
     * @urlParam id int required The listing type's ID. Example: 1
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

            // Cache ID part related to unactivated listings
            $withoutGlobalScopes = '';
            if ($isUnactivatedIncluded) {
                $withoutGlobalScopes = '.withoutGlobalScopes';
            }

            // Cache ID part related to embed relationships/tables
            $embedKey = '';
            if (request()->filled('embed')) {
                $embedKey = str_replace([' ', ','], ['', '.'], request()->get('embed'));
                $embedKey = '.with.' . $embedKey;
            }

            // Cache control
            $noCache = (request()->filled('noCache') && (int)request()->get('noCache') == 1);
            $cacheDriver = config('cache.default');
            $cacheExpiration = $this->cacheExpiration;
            if ($noCache) {
                config()->set('cache.default', 'array');
                $cacheExpiration = '-1';
            }

            $cacheId = 'post' . $withoutGlobalScopes . $embedKey . '.' . $id . '.' . config('app.locale');
            $post = cache()->remember($cacheId, $cacheExpiration, function () use ($isUnactivatedIncluded, $id) {
                $post = Post::query();

                if ($isUnactivatedIncluded) {
                    $post->withoutGlobalScopes([VerifiedScope::class, ReviewedScope::class]);
                }

                $embed = explode(',', request()->get('embed'));

                if (in_array('country', $embed)) {
                    $post->with('country');
                }
                if (in_array('user', $embed)) {
                    $post->with('user');
                }
                if (in_array('category', $embed)) {
                    $post->with('category');
                }
                if (in_array('postType', $embed)) {
                    $post->with('postType');
                }
                if (in_array('city', $embed)) {
                    $post->with('city');
                }
                if (in_array('latestPayment', $embed)) {
                    $post->with('latestPayment');
                }
                if (in_array('savedByLoggedUser', $embed)) {
                    $post->with('savedByLoggedUser');
                }
                if (in_array('pictures', $embed)) {
                    $post->with('pictures');
                }

                // Adjust the condition to filter by city_id
                $post->where('city_id', $id);

                return $post->get();
            });

            // Reset caching parameters
            config()->set('cache.default', $cacheDriver);

            abort_if($post->isEmpty(), 404, t('post_not_found'));

            $resource = PostByCityResource::collection($post);

            return $this->respondWithResource($resource);
        }
    }
}
