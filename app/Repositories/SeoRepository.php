<?php
namespace App\Repositories;
use App\Models\Seo;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config;
class SeoRepository
{
    protected $seo;
    public function __construct(Seo $seo )
    {
       $this->seo = $seo ;
    }    
    public function getAll($operator_id)
    {
      return $this->seo->where('bus_operator_id', $operator_id)
                       ->where('status','1')->get();
    }
}