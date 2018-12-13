<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 12/3/2018
 * Time: 10:12 PM
 */

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Model\Product;
use App\Model\Series;
use Illuminate\Http\Request;

class SeriesController extends Controller
{
    public function getSeries(Request $req) {
        try {
            list($page, $sort,$search) = $this->getPageSortSearch($req);
            $prd_id = 0;
            if ($req->has("prd_id")) {
                $prd_id = $req->prd_id;
            }
            $series = new Series();
            $data = $series->getSeriesPaging($prd_id, $page, $sort,$search);
            foreach ($data as &$seri) {
                $seri->inp_date = $this->convertDbDateToWebDate($seri->inp_date);
            }
            $paging = $series->getPagingInfo($sort,$search);
            $paging['page'] = $page;
        } catch (\Throwable $e) {
            throw $e;
        }
        return response()->json(['series' => $data ,'paging' => $paging,'success' => true, 'message' => '', 'search'=>$search], 200);
    }

    private function getPageSortSearch($request) {
        $page = 0;
        if ($request->has('page')) {
            $page = $request->page;
        }

        $sort = '';
        if ($request->has('sort')) {
            $sort = $request->sort;
        }
        $search = [];
        if ($request->has('search')) {
            $search = json_decode($request->search, true);
        }
        return array($page, $sort, $search);
    }

    private function convertDbDateToWebDate($date) {
        if (!empty($date)) {
            $time = strtotime($date);
            $newFormat = date("d/m/Y", $time);
            return $newFormat;
        }
        return "";
    }

}