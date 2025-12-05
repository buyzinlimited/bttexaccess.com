<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class SubCategory extends Model
{
    use HasFactory, HasSlug;

    protected $fillable = ['slug', 'metatitle', 'metakeyword', 'metadescription', 'description', 'name', 'image', 'category_id','canonicalurl'];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug')            
            ->doNotGenerateSlugsOnUpdate();
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
