<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Validator;
use App\Traits\ApiResponser;
use Illuminate\Support\Facades\Config;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\Response;
use App\AppValidator\CommonValidator;
use App\Services\CommonService;
use Illuminate\Support\Facades\DB;
use App\Repositories\CommonRepository;

class CommonController extends Controller
{
    use ApiResponser;
    /**
     * @var cancelTicketService
     */
    protected $commonService;
    protected $commonValidator;
    protected $commonRepository;
    /**
     * cancelTicketController Constructor
     *
     * @param commonService $commonService
     *
     */
    public function __construct(CommonService $commonService, CommonValidator $commonValidator, CommonRepository $commonRepository)
    {
        $this->commonService = $commonService;
        $this->commonValidator = $commonValidator;
        $this->commonRepository = $commonRepository;
    }
    /**
     * @OA\Post(
     *     path="/api/CommonService",
     *     tags={"Common Service"},
     *     description="Get all SEO related things",
     *     summary="Get all SEO related things",
     *     @OA\Parameter(
     *          name="user_id",
     *          description="user Id",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="integer",
     *              default=1,
     *          )
     *      ),
     *  @OA\Response(response="200", description="Get all Social media links"),
     *  @OA\Response(response=206, description="validation error"),
     *  @OA\Response(response=400, description="Bad request"),
     *  @OA\Response(response=401, description="Unauthorized access"),
     *  @OA\Response(response=404, description="No record found"),
     *  @OA\Response(response=500, description="Internal server error"),
     *  @OA\Response(response=502, description="Bad gateway"),
     *  @OA\Response(response=503, description="Service unavailable"),
     *  @OA\Response(response=504, description="Gateway timeout"),
     *     security={
     *       {"apiAuth": {}}
     *     }
     * )
     *
     */
    public function getAll(Request $request)
    {

        $data = $request->all();
        $commonValidation = $this->commonValidator->validate($data);

        if ($commonValidation->fails()) {
            $errors = $commonValidation->errors();
            return $this->errorResponse($errors->toJson(), Response::HTTP_PARTIAL_CONTENT);
        }

        try {
            $response =  $this->commonService->getAll($request);
            return $this->successResponse($response, Config::get('constants.RECORD_FETCHED'), Response::HTTP_OK);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), Response::HTTP_NOT_FOUND);
        }
    }
    /**
     * @OA\Get(
     *     path="/api/Appversion",
     *     tags={"App Version"},
     *     description="Get App Version",
     *     summary="Get App Version",
     *  @OA\Response(response="200", description="Get app version details"),
     *  @OA\Response(response=206, description="validation error"),
     *  @OA\Response(response=400, description="Bad request"),
     *  @OA\Response(response=401, description="Unauthorized access"),
     *  @OA\Response(response=404, description="No record found"),
     *  @OA\Response(response=500, description="Internal server error"),
     *  @OA\Response(response=502, description="Bad gateway"),
     *  @OA\Response(response=503, description="Service unavailable"),
     *  @OA\Response(response=504, description="Gateway timeout"),
     *     security={
     *       {"apiAuth": {}}
     *     }
     * )
     *
     */
    public function Appversion()
    {
        $version = DB::table('app_version')->where("id", 1)->get();

        return $this->successResponse($version, Config::get('constants.RECORD_FETCHED'), Response::HTTP_OK);
    }

    public function getSchemaUrls()
    {
        $routes = DB::table('mst_routes_details as r')
            ->leftJoin('location as s', 's.id', '=', 'r.source_id')
            ->leftJoin('location as d', 'd.id', '=', 'r.destination_id')
            ->select(
                'r.source_id',
                'r.destination_id',
                's.name as source_name',
                's.url as source_slug',
                'd.name as destination_name',
                'd.url as destination_slug'
            )
            ->where('r.active_status', 1)
            // ->where('r.is_main_route', 1)
            ->orderBy('r.source_id')
            ->orderBy('r.destination_id')
            ->get();

        $operators = DB::table('bus_operator')
            ->select('id', 'operator_name', 'operator_url', 'organisation_name')
            ->where('status', 1)
            ->get();

        $data['routes'] = $routes;
        $data['operators'] = $operators;
        return response()->json([
            'status' => true,
            'message' => 'Success',
            'data' => $data
        ], 200);
    }

    public function homeData(Request $request)
    {
        $is_top_routes = $request->is_top_routes ?? null;
        $is_popular_routes = $request->is_popular_routes ?? null;
        $data = [];

        // Banner
        $path = $this->commonRepository->getPathurls();
        $path = $path[0];
        $today = date('Y-m-d');
        $banner_image = '';
        $banner = $this->commonRepository->getBanners($request['user_id'], $today);
        if ($banner && isset($banner[0]) && $banner[0]->banner_image) {
            $banner = $banner[0];
            $banner_image = $path->banner_url . $banner->banner_image;
        }
        // Banner End

        $popular_routes = DB::table('mst_routes_details as rd')
            ->join('location as s', 'rd.source_id', '=', 's.id')
            ->join('location as d', 'rd.destination_id', '=', 'd.id')
            ->select(
                'rd.source',
                'rd.destination',
                's.url as source_url',
                'd.url as destination_url'
            )
            ->when($is_popular_routes !== null, function ($query) use ($is_popular_routes) {
                $query->where('rd.is_popular_routes', $is_popular_routes);
            })
            ->where('rd.active_status', 1)
            ->orderBy('rd.sequence', 'ASC')
            ->get();

        $top_routes = DB::table('mst_routes_details as rd')
            ->join('location as s', 'rd.source_id', '=', 's.id')
            ->join('location as d', 'rd.destination_id', '=', 'd.id')
            ->select(
                'rd.source',
                'rd.destination',
                's.url as source_url',
                'd.url as destination_url'
            )
            ->when($is_top_routes !== null, function ($query) use ($is_top_routes) {
                $query->where('rd.is_top_routes', $is_top_routes);
            })
            ->where('rd.active_status', 1)
            ->orderBy('rd.sequence', 'ASC')
            ->get();

        $mPopup = DB::table('odbus_charges')
            ->select('maintenance_popup', 'maintenance_start', 'maintenance_end')
            ->where('id', 1)
            ->first();

        if ($mPopup) {
            $mPopup->maintenance_popup = (bool) $mPopup->maintenance_popup;
        }

        $websitePopup = DB::table('odbus_charges')
            ->select('popup_status', 'popup_heading', 'popup_description', 'popup_start_date', 'popup_start_time', 'popup_end_date', 'popup_end_time', 'popup_url', 'popup_image','advance_days_show')
            ->where('id', 1)
            ->first();

        if ($websitePopup) {
            $websitePopup->popup_status = (bool) $websitePopup->popup_status;
            $websitePopup->popup_image = $path->og_image_url . $websitePopup->popup_image;
            $websitePopup->advance_days_show = (int) $websitePopup->advance_days_show;
        }

        $data['banner_image'] = $banner_image;
        $data['popular_routes'] = $popular_routes;
        $data['top_routes'] = $top_routes;
        $data['maintenance'] = $mPopup;

        if ($websitePopup->popup_status) {
            $data['website_popup'] = $websitePopup;
        }

        return response()->json([
            'status' => true,
            'message' => 'Success',
            'data' => $data
        ], 200);
    }
}
