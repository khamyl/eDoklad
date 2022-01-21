<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use App\Filters\Filterable;

class Tag extends Model
{
    use HasFactory, Sortable, Filterable;

    public $timestamps = false;
    protected $fillable = ['tag', 'color', 'description'];
    public $sortable = ['tag'];

    public function getFgColorAttribute() {
        $isColorDarkAdv = \isColorDarkAdv($this->color);
        return ($isColorDarkAdv) ? '#ffffff':'#000000';
    }    
}
