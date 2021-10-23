<?php
namespace App\Repositories;
use App\Models\Testimonial;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config;
class TestimonialRepository
{
    protected $testimonial;
    public function __construct(Testimonial $testimonial )
    {
       $this->testimonial = $testimonial ;
    }    
    public function getAll($request)
    {
      $operator_id = $request['bus_operator_id'] ;
      $data = $this->testimonial->where('bus_operator_id', $operator_id)
                                ->where('status','1')
                                ->orderBy('id','DESC')->get();
      return $data;
    }
}