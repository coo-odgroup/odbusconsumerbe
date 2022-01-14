<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TestimonialService;
use Illuminate\Support\Facades\Validator;
use InvalidArgumentException;
use App\Traits\ApiResponser;
use Illuminate\Support\Facades\Config;
use Exception;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
class TestimonialController extends Controller
{
    use ApiResponser;
    protected $testimonialService;
    public function __construct(TestimonialService $testimonialService)
    {
        $this->testimonialService = $testimonialService;
    }
    /**
     * @OA\Post(
     *     path="/api/GetTestimonial",
     *     tags={"Get all Testimonials"},
     *     description="Get all Testimonials",
     *     summary="Get all Testimonials",
     *     @OA\Parameter(
     *          name="user_id",
     *          description="User Id",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="integer",
     *              default=152,
     *          )
     *      ),
     *  @OA\Response(response="200", description="Get all Testimonials"),
     *  @OA\Response(response=401, description="Unauthorized"),
     *     security={
     *       {"apiAuth": {}}
     *     }
     * )
     * 
     */
    public function getAlltestimonial(Request $request)
    {
        $testimonial = $this->testimonialService->getAll($request);
        return $this->successResponse($testimonial,Config::get('constants.RECORD_FETCHED'),Response::HTTP_OK);
    }
}