<?php
namespace App\Filters;

use App\User;
use Illuminate\Http\Request;

class TagFilters extends QueryFilters
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
        parent::__construct($request);
    }
  
    public function tag($term='') {
        return (empty($term)) ? $this->builder : $this->builder->where('tags.tag', 'LIKE', "%$term%");
    }
}