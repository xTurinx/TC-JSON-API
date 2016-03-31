<?php

namespace App\Http\Controllers\World;

use App\Exceptions\UnsupportedVersion;
use App\Helpers\TCAPI;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

use DB;

class ItemController extends Controller
{
    public function __construct()
    { }

    public function oldSearchFunction()
    {
        if ( !isset($_GET['id']) && !isset($_GET['name']) )
            return response()->json(array("error" => "please insert at least one parameter"));

        if (TCAPI::is("wod"))
        {
            $query = DB::connection('hotfixes')->table('item_sparse')->select('ID', 'Name');

            if (isset($_GET['id']) && $_GET['id'] != "")
                $query->where('ID', 'LIKE', '%'. $_GET['id'] .'%');

            if (isset($_GET['name']) && $_GET['name'] != "")
                $query->where('Name', 'LIKE', '%'. $_GET['name'] .'%');

            $results = $query->orderBy('ID')->get();
        }
        else
        {
            $query = DB::connection('world')->table('item_template')->select('entry', 'name');

            if (isset($_GET['id']) && $_GET['id'] != "")
                $query->where('entry', 'LIKE', '%'. $_GET['id'] .'%');

            if (isset($_GET['name']) && $_GET['name'] != "")
                $query->where('name', 'LIKE', '%'. $_GET['name'] .'%');

            $results = $query->orderBy('entry')->get();
        }

        return response()->json($results);
    }

    public function get($id)
    {
        if ($id == 0)
            return response()->json(array("error" => "id can not be '0'"));

        $results = DB::connection('world')->select("SELECT * FROM item_template WHERE entry = ?", [$id]);

        if (count($results) === 0)
            return response()->json(array("error" => "item not found"));

        return response()->json($results);
    }

    public function find($searchPattern)
    {
        if (empty($searchPattern))
            return response()->json(array("error" => "invalid search parameter"));

        if (TCAPI::is("wod"))
        {
            $query = DB::connection('hotfixes')->table('item_sparse')->select('ID', 'Name')->where('Name', 'LIKE', '%' . $searchPattern . '%');
            $results = $query->orderBy('ID')->get();
        }
        else
        {
            $query = DB::connection('world')->table('item_template')->select('entry', 'name')->where('name', 'LIKE', '%' . $searchPattern . '%');
            $results = $query->orderBy('entry')->get();
        }

        return response()->json($results);
    }
}
