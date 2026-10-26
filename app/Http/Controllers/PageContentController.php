<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PageContentService;
use Illuminate\Support\Facades\Validator;
use InvalidArgumentException;
use App\Traits\ApiResponser;
use Illuminate\Support\Facades\Config;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use Symfony\Component\HttpFoundation\Response;

class PageContentController extends Controller
{
    use ApiResponser;
    protected $pagecontentService;
    public function __construct(PageContentService $pagecontentService)
    {
        $this->pagecontentService = $pagecontentService;
    }

    public function getAllpagecontent(Request $request)
    {
        $pagecontent = $this->pagecontentService->getAll($request);
        return $this->successResponse($pagecontent, Config::get('constants.RECORD_FETCHED'), Response::HTTP_OK);
    }

    public function getAdvantageDetails(Request $request)
    {
        $pageUrl = $request->page_url;

        if (empty($pageUrl)) {
            return response()->json([
                'status' => false,
                'message' => 'page_url is required'
            ], 400);
        }

        $cacheKey = 'advantage_details:' . $pageUrl;

        $cachedData = Redis::get($cacheKey);

        if ($cachedData !== null) {
            return response()->json(json_decode($cachedData, true));
        }

        $page = DB::table('page_content')
            ->where('page_url', $pageUrl)
            ->where('status', 1)
            ->first();

        if (!$page) {
            return response()->json([
                'status' => false,
                'message' => 'Page not found'
            ], 404);
        }

        $faqs = DB::table('faq')
            ->where('page_id', $page->id)
            ->where('status', 1)
            ->get();

        $responseData = [
            'status' => true,
            'page' => $page,
            'faqs' => $faqs
        ];

        Redis::setex($cacheKey, 86400, json_encode($responseData));

        return response()->json($responseData);
    }
}
