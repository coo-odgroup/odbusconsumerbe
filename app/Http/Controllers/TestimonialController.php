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
    public function getAlltestimonial(Request $request)
    {
        $testimonial = $this->testimonialService->getAll($request);
        return $this->successResponse($testimonial,Config::get('constants.RECORD_FETCHED'),Response::HTTP_OK);
    }
}