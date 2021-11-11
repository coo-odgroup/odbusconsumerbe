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
    public function getAll($operator_id)
    {
      return $this->testimonial->where('bus_operator_id', $operator_id)
                                ->where('status','1')
                                ->orderBy('id','DESC')->get();
    }
}