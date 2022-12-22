<?php

namespace App\Models\Insurance;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class insuranceCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'code',
        'status',
    ];


    protected static function boot(){
        parent::boot();

        static::creating(function ($category) {
            $category->code = $category->createSlug($category->name);          
        });
        
    }

    public function createCode($name){
        if (static::whereCode($code = Str::slug($name))->exists()) {
            $max = static::whereName($name)->latest('id')->value('code');
            if (isset($max[-1]) && is_numeric($max[-1])) {
                return preg_replace_callback('/(\d+)$/', function($mathces) {
                    return $mathces[1] + 1;
                }, $max);
            }
            return "{$code}-2";
        }
        return $code;
    }

}
