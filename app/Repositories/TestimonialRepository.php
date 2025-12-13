<?php
namespace App\Repositories;
use App\Models\Testimonial;
use App\Models\Faq;
use App\Models\FaqCategory;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config;
class TestimonialRepository
{
    protected $testimonial;
    public function __construct(Testimonial $testimonial )
    {
       $this->testimonial = $testimonial ;
    }    
    public function getAll($user_id)
    {
      return $this->testimonial->where('user_id', $user_id)
                                ->where('status','1')
                                ->orderBy('id','DESC')->get();
    }

    public function getFAQ()
    {
      return FaqCategory::where('status', 1)
      ->select('id', 'category_name')
      ->with(['faqs' => function ($q) {
          $q->select(
              'faq_category_id',
              'title as question',
              'content as answer'
          );
      }])
      ->get();
    }
}