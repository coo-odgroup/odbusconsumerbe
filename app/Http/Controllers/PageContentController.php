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
    public function getAllpagecontent(Request $request)
    {
        $pagecontent = $this->pagecontentService->getAll($request);
        return $this->successResponse($pagecontent,Config::get('constants.RECORD_FETCHED'),Response::HTTP_OK);
    }
}