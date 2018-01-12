<?php
// Item.php
namespace App\Model\Invoices;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'parent_id','description'];
    public $timestamps=true;
}