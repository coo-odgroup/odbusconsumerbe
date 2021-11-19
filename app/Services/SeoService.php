<?php

namespace App\Services;


use App\Repositories\SeoRepository;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use InvalidArgumentException;
use Illuminate\Support\Facades\Config;
class SeoService
{
    protected $seoRepository;
    public function __construct(SeoRepository $seoRepository)
    {
        $this->seoRepository = $seoRepository;
    }
    public function getAll($request)
    {      
        return $this->seoRepository->getAll($request['bus_operator_id']);
    }
}