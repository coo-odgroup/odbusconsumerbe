<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FaqController extends Controller
{
    public function getFaqs()
    {
        try {
            $faqs = DB::table('faq_category as fc')
                ->leftJoin('faq as f', 'fc.id', '=', 'f.faq_category_id')
                ->select(
                    'fc.id as category_id',
                    'fc.category_name',
                    'f.id as faq_id',
                    'f.title',
                    'f.content'
                )
                ->where('f.page_id', null)
                ->where('f.status', 1)
                ->orderBy('fc.id')
                ->get()
                ->groupBy('category_id')
                ->map(function ($items) {
                    return [
                        'category_id' => $items->first()->category_id,
                        'category_name' => $items->first()->category_name,
                        'faqs' => $items->map(function ($item) {
                            return [
                                'faq_id' => $item->faq_id,
                                'title' => $item->title,
                                'content' => $item->content,
                            ];
                        })->values()
                    ];
                })
                ->values();

            return response()->json([
                'status' => true,
                'message' => 'FAQ fetched successfully',
                'data' => $faqs
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
