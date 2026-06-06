<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Validator;
use App\Traits\ApiResponser;
use Illuminate\Support\Facades\Config;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\Response;
use App\AppValidator\SeoValidator;
use App\Models\Blog;
use App\Models\Location;
use App\Models\OdbusCharges;
use App\Models\Seo;
use App\Models\PageContent;
use App\Services\SeoService;
use Illuminate\Support\Facades\DB;

class SeoController extends Controller
{
    use ApiResponser;
    protected $seoValidator;
    protected $seoService;

    public function __construct(SeoValidator $seoValidator, SeoService $seoService)
    {
        $this->seoValidator = $seoValidator;
        $this->seoService = $seoService;
    }

    public function seoContent(Request $request)
    {
        // return $request->all();
        try {
            $route = DB::table('mst_routes_details')
                ->where('source_id', $request->sourceId)
                ->where('destination_id', $request->destinationId)
                ->first();

            // return $route->id;

            if (!$route) {
                return $this->successResponse(null, 'Route not found', Response::HTTP_OK);
            }

            $seoData = DB::table('mst_seo_content')
                ->where('route_id', $route->id)
                ->first();

            // return $seo;

            $seo = [
                'id' => $seoData->id ?? null,
                'route_id' => $seoData->route_id ?? $route->id,
                'meta_title' => $seoData->meta_title ?? '',
                'meta_description' => $seoData->meta_description ?? '',
                'content' => $seoData->content ?? '',
                'faq_schema' => json_decode($route->faq_schema ?? '[]'),
                'breadcrumb_schema' => json_decode($route->breadcrumb_schema ?? '[]'),
            ];

            if (!$seo) {
                return $this->successResponse(null, 'SEO content not found', Response::HTTP_OK);
            }

            return $this->successResponse($seo, Config::get('constants.RECORD_FETCHED'), Response::HTTP_OK);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function seolist(Request $request)
    {

        $data = $request->all();
        $seoValidation = $this->seoValidator->validate($data);

        if ($seoValidation->fails()) {
            $error = $seoValidation->errors();
            return $this->errorResponse($error->toJson(), Response::HTTP_PARTIAL_CONTENT);
        } else {
            try {
                $response = $this->seoService->getAll($request);
                return $this->successResponse($response, Config::get('constants.RECORD_FETCHED'), Response::HTTP_OK);
            } catch (Exception $e) {
                return $this->errorResponse($e->getMessage(), Response::HTTP_NOT_FOUND);
            }
        }
    }

    public function getSeolist(Request $request)
    {
        $current_url = $request->current_url;

        $path = trim(parse_url($current_url, PHP_URL_PATH), '/');

        if ($path == '') {

            $odbusCharge = OdbusCharges::first();

            if (!$odbusCharge) {
                return response()->json([
                    'message' => 'Home page SEO not found'
                ], Response::HTTP_NOT_FOUND);
            }

            $seo = [
                'meta_title' => $odbusCharge->meta_title,
                'meta_description' => $odbusCharge->meta_description,
                'meta_keyword' => $odbusCharge->meta_keyword,
                'canonical_url' => $current_url,
                'organization_schema' => $odbusCharge->organization_schema,
            ];

            return $this->successResponse(
                $seo,
                Config::get('constants.RECORD_FETCHED'),
                Response::HTTP_OK
            );
        }

        // ROUTE SEO
        elseif (strpos($current_url, 'routes/') !== false) {

            $current_url = parse_url($request->current_url, PHP_URL_PATH);

            $url = str_replace('routes/', '', $current_url);
            $url = str_replace('-bus-services', '', $url);
            $url = trim($url, '/');

            $parts = explode('-', $url);

            $source = $parts[0] ?? '';
            $destination = $parts[1] ?? '';

            $sourceId = Location::where('url', $source)->value('id');

            $destinationId = Location::where('url', $destination)->value('id');

            return $this->seoContent(
                $request->merge([
                    'sourceId' => $sourceId,
                    'destinationId' => $destinationId
                ])
            );
        }

        // BLOG SEO
        elseif (strpos($current_url, 'blog/') !== false) {

            $path = trim(parse_url($current_url, PHP_URL_PATH), '/');

            // blog/travel/blog-slug
            $segments = explode('/', $path);

            $category_slug = $segments[1] ?? '';
            $slug = $segments[2] ?? '';

            $blog = Blog::where('slug', $slug)->first();

            if (!$blog) {

                return response()->json([
                    'message' => 'Blog not found'
                ], Response::HTTP_NOT_FOUND);
            }

            // Decode JSON Schemas
            $faq_schema = $blog->faq_schema
                ? json_decode($blog->faq_schema, true)
                : [];

            $service_schema = $blog->service_schema
                ? json_decode($blog->service_schema, true)
                : [];

            $breadcrumb_schema = $blog->breadcrumb_schema
                ? json_decode($blog->breadcrumb_schema, true)
                : [];

            $seo = [
                'meta_title' => $blog->meta_title,
                'meta_description' => $blog->meta_description,
                'meta_keywords' => $blog->meta_keywords,
                'canonical_url' => $blog->canonical_url,
                'og_image' => $blog->og_image,
                'faq_schema' => $faq_schema,
                'service_schema' => $service_schema,
                'breadcrumb_schema' => $breadcrumb_schema,
            ];

            return $this->successResponse(
                $seo,
                Config::get('constants.RECORD_FETCHED'),
                Response::HTTP_OK
            );
        }

        // ADVANTAGE SEO
        elseif (strpos($current_url, 'advantage/') !== false) {

            $path = trim(parse_url($current_url, PHP_URL_PATH), '/');

            // advantage/travel/advantage-slug
            $segments = explode('/', $path);

            $category_slug = $segments[1] ?? '';
            $slug = $segments[2] ?? '';

            $advantage = PageContent::where('page_url', $slug)->first();

            if (!$advantage) {
                return response()->json([
                    'message' => 'Advantage not found'
                ], Response::HTTP_NOT_FOUND);
            }

            // Decode JSON Schemas
            $faq_schema = $advantage->faq_schema
                ? $advantage->faq_schema
                : [];

            $breadcrumb_schema = $advantage->breadcrumb_schema
                ? $advantage->breadcrumb_schema
                : [];

            $seo = [
                'meta_title' => $advantage->meta_title,
                'meta_description' => $advantage->meta_description,
                'extra_meta' => $advantage->extra_meta,
                'canonical_url' => $advantage->canonical_url,
                'faq_schema' => $faq_schema,
                'breadcrumb_schema' => $breadcrumb_schema,
            ];

            return $this->successResponse(
                $seo,
                Config::get('constants.RECORD_FETCHED'),
                Response::HTTP_OK
            );
        } else {

            $seodata = Seo::where('page_url', $current_url)->first();

            if (!$seodata) {
                return response()->json([
                    'message' => 'SEO data not found'
                ]);
            }

            $seo = [
                'meta_title' => $seodata->meta_title,
                'meta_description' => $seodata->meta_description,
                'meta_keywords' => $seodata->meta_keyword,
                'canonical_url' => $seodata->canonical_url,
            ];

            return $this->successResponse(
                $seo,
                Config::get('constants.RECORD_FETCHED'),
                Response::HTTP_OK
            );
        }
    }



    public function count(Request $request)
    {
        // $bus = DB::table('mst_routes_bus_ids as mrbi')
        //     ->join('bus as b', 'b.id', '=', 'mrbi.bus_id')
        //     ->where('mrbi.route_id', $request->route_id)
        //     ->where('mrbi.active_status', 1)
        //     ->where('b.status', 1)
        //     ->distinct()
        //     // ->count();
        //     ->pluck('mrbi.bus_id');



        // $bus_seats = DB::table('bus_seats')
        //     ->whereIn('bus_id', $bus)
        //     ->where('status', 1)
        //     ->whereNull('type')
        //     ->whereNull('operation_date')
        //     ->distinct('seats_id')
        //     ->count('ticket_price_id');

        // return $bus_seats;

        $routes = DB::table('mst_routes_details as rd')

            ->join('mst_routes_bus_ids as mrbi', 'mrbi.route_id', '=', 'rd.id')

            ->join('bus as b', 'b.id', '=', 'mrbi.bus_id')

            ->join('bus_seats as bs', 'bs.bus_id', '=', 'mrbi.bus_id')

            ->where('mrbi.active_status', 1)
            ->where('b.status', 1)
            ->where('bs.status', 1)

            ->whereNull('bs.type')
            ->whereNull('bs.operation_date')

            ->select(
                'rd.id as route_id',
                'rd.source',
                'rd.destination',
                DB::raw('COUNT(DISTINCT bs.seats_id) as total_seats')
            )

            ->groupBy(
                'rd.id',
                'rd.source',
                'rd.destination'
            )

            ->get();

        return $routes;
    }
}


//-----------------------------------------------------------------------------------------------

//rw query total seats for a route

// SELECT
//     rd.id AS route_id,
//     rd.source,
//     rd.destination,
//     COUNT(DISTINCT bs.seats_id) AS total_seats

// FROM mst_routes_details rd

// JOIN mst_routes_bus_ids mrbi
//     ON mrbi.route_id = rd.id

// JOIN bus b
//     ON b.id = mrbi.bus_id

// JOIN bus_seats bs
//     ON bs.bus_id = mrbi.bus_id

// WHERE mrbi.active_status = 1
// AND b.status = 1
// AND bs.status = 1
// AND bs.type IS NULL
// AND bs.operation_date IS NULL

// GROUP BY
//     rd.id,
//     rd.source,
//     rd.destination;


//-----------------------------------------------------------------------------------------------------------------

// raw sql for status update in mst_routes_operations table

// UPDATE mst_routes_operators mro

// JOIN bus_operator bo
//     ON bo.id = mro.operator_id

// SET mro.status =
//     CASE
//         WHEN bo.status = 1 THEN 1
//         ELSE 0
//     END;