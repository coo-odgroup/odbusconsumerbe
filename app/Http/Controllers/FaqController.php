<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FaqController extends Controller
{
    public function index(Request $request)
    {
        return "he";
        $faqs = DB::table('odbus.faq_category as fc')
            ->leftJoin('odbus.faq as f', 'fc.id', '=', 'f.faq_category_id')
            ->select(
                'fc.id as category_id',
                'fc.name as category_name',
                'f.id as faq_id',
                'f.question',
                'f.answer'
            )
            ->orderBy('fc.id')
            ->get()
            ->groupBy('category_id');

        return  $faqs;
    }
}
