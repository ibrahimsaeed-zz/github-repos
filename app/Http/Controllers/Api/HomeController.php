<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\Http\Requests\API\SearchRequest;


class HomeController extends Controller
{

    /**
     * @OA\Post(
     *     tags={"Search"},
     *     path="/api/search",
     *     summary="Find repositories via various criteria.",
     *     @OA\Parameter(
     *     name="per_page",
     *     in="query",
     *     description="Results per page (max 100)",
     *     required=false,
     *     @OA\Schema(
     *         type="integer",
     *         format="int64",
     *         default="10"
     *     )
     *   ),
     *     @OA\Parameter(
     *     name="created_at",
     *     in="query",
     *     description="created from this date",
     *     required=false,
     *     @OA\Schema(
     *         type="string",
     *         format="date",
     *         default="2020-01-01"
     *     )
     *   ),
     *     @OA\Parameter(
     *     name="langauge",
     *     in="query",
     *     description="for example : Python , Go , PHP",
     *     required=false,
     *     @OA\Schema(
     *         type="string",
     *         default="PHP"
     *     )
     *   ),
     *     @OA\Response(response="200", description="object"),
     *     @OA\Response(response=503, description="ServiceUnavailableException"),
     * )
     */

    public function index(SearchRequest $request)
    {
        $client = new Client();

        $perPage = $request->per_page ?? '10';

        $createdAt = $request->created_at ?? '2020-01-01';

        $langauge = $request->langauge ?? 'PHP';

        try {

            $response = $client->request("GET", "https://api.github.com/search/repositories?q=created:>$createdAt+language:$langauge&sort=stars&order=desc&per_page=$perPage");

            $results = json_decode($response->getBody(), true);

            foreach ($results['items'] as $item){
                $data[] = [
                    'id'            => $item['id'],
                    'name'          => $item['name'],
                    'description'   => $item['description'],
                    'html_url'      => $item['html_url'],
                    'language'      => $item['language'],
                    'created_at'    => $item['created_at'],
                ];
            }

            return response()->json(['data' => $data],200);

        }
        catch (\Exception $e){

            return $this->serviceUnavailable();
        }
    }

    /**
     * Return error message
     *
     * @return JsonResponse
     */
    public function serviceUnavailable(){

        return response()->json(['data' => NULL,'message'=>'Something wrong .'],503);
    }

}
