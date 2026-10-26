<?php

namespace App\Repositories;

use App\Models\PageContent;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Redis;

class PageContentRepository
{
   protected $pagecontent;
   public function __construct(PageContent $pagecontent)
   {
      $this->pagecontent = $pagecontent;
   }
   // public function getAll($user_id,$page_url)
   // {      
   //    return $this->pagecontent->where('user_id',$user_id)
   //                             ->where('page_url',$page_url)
   //                             ->where('status', 1)->get();
   // }


   public function getAll($user_id, $page_url)
   {
      $cacheKey = 'page_content:' . $page_url;

      $cachedData = Redis::get($cacheKey);

      if ($cachedData !== null) {
         return json_decode($cachedData, true);
      }

      // 2. REDIS DATA NOT FOUND
      $data = $this->pagecontent
         ->where('user_id', $user_id)
         ->where('page_url', $page_url)
         ->where('status', 1)
         ->get();

      // 3. SAVE DATABASE RESULT INTO REDIS
      Redis::setex(
         $cacheKey,
         86400, // 24 hours
         json_encode($data)
      );

      // 4. RETURN DATABASE DATA
      return $data;
   }
}
