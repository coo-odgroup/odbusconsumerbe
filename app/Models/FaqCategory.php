<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Faq;

class FaqCategory extends Model
{
    use HasFactory;
    protected $table = 'faq_category';
    protected $fillable = ['faq_category', 'faq_categorycol', 'status'];

    public function faqs()
    {
        return $this->hasMany(Faq::class, 'faq_category_id');
    }
}
