<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UniversityNews extends Model
{
    protected $table = 'university_news';

    public $timestamps = true;

    protected $fillable = [
    	'name',
        'description',
        'type',
        'view', 
        'price',
        'id_university' 
    ];
 
    public static function getProfileNews($universityId, $request = false)
    {
        $news = (new UniversityNews)->newQuery();   

        if (!empty($request['searchByName'])) 
        {
            $news->where('name', 'like', '%'.$request['searchByName'].'%');
        } 

        if (!empty($request['date'])) 
        { 
            $news->whereDate('created_at', '>=', date('Y-m-d H:i:s', strtotime($request['date'] . ' 00:00:00')));
            $news->whereDate('created_at', '<=', date('Y-m-d H:i:s', strtotime($request['date'] . ' 11:59:59')));
        }

        $query = $news->where('id_university', $universityId)
                           ->orderBy('created_at', 'desc')
                           ->get();
        return $query;
    }
}
