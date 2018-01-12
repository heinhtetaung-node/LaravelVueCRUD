<?php
// Item.php
namespace App;
use Illuminate\Database\Eloquent\Model;
class SubCategory extends Model
{
    protected $fillable = ['name', 'description','parent_id','sub_parent_id'];
}