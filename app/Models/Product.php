<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'ref',
        'name',
        'description',
        'price',
        'qty',
        'created_by',
        'updated_by',
    ];
    protected $primaryKey = 'id';
    protected $dates = ['deleted_at'];

    public static function generateRef(){
        $ref = Carbon::now()->timestamp.'_'.rand(1000, 9999);
        return $ref;
    }

    public static function getAllProducts($filter = [], $sort = [])
    {
        return Product::where($filter)->orderBy($sort)->get();
    }

    public static function loadProductById($id)
    {
        return Product::find($id);
    }

    public function markAsDelete()
    {
        $this->deleted_by = Auth::user()->id;
        $this->deleted_at = now();
        $this->save();
    }

}
