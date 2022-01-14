<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Services\PageContentService;
use Illuminate\Support\Facades\Validator;
use InvalidArgumentException;
use App\Traits\ApiResponser;
use Illuminate\Support\Facades\Config;
use Exception;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class PageContentController extends Controller
{
    use ApiResponser;
    protected $pagecontentService;
    public function __construct(PageContentService $pagecontentService)
    {
        $this->pagecontentService = $pagecontentService;
    }
    /**
     * @OA\Post(
     *     path="/api/GetPageData",
     *     tags={"Get Page contents"},
     *     description="Get Page contents",
     *     summary="Get Page contents",
     *     @OA\Parameter(
     *          name="user_id",
     *          description="user Id",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="integer",
     *              default=152,
     *          )
     *      ),
     *     @OA\Parameter(
     *          name="page_url",
     *          description="page url",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string",
     *              default="about-us",
     *          )
     *      ),
     *  @OA\Response(response="200", description="Get all Page contents"),
     *  @OA\Response(response=401, description="Unauthorized"),
     *     security={
     *       {"apiAuth": {}}
     *     }
     * )
     * 
     */
    public function getAllpagecontent(Request $request)
    {
        $pagecontent = $this->pagecontentService->getAll($request);
        return $this->successResponse($pagecontent,Config::get('constants.RECORD_FETCHED'),Response::HTTP_OK);
    }
}