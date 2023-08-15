<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $searchQuery = $request->query('q');
        $results = DB::select("SELECT  h.id ,   h.user_id , 	h.id_number 	,h.state 	,h.state_ar, h.grade_drop , h.grade_drop 	,h.title1 	,h.title1_ar 	,h.title2 	,h.title2_ar 	,h.title3 	,h.title3_ar 	,h.year 	,h.year_ar 	,h.school 	,h.school_ar 	,h.name 	,h.name_ar 	,h.class 	,h.nationality 	,h.nationality_ar 	,h.birth_day 	,h.birth_day_ar	,h.sort_by_grade 	,h.sort_by_class 	,h.absence 	,h.latency , t.id as 'std_id' , t.class , t.class_number , h.message , h.status , t.name as 'name_clean' , u.name as 'teacher' FROM  sheets h INNER JOIN students t ON h.id_number = t.id_number inner join users u on u.id = t.user_id   where h.id_number = ?", [$searchQuery]);
        return view('search_results', ['results' => $results]);
    }
    
}
