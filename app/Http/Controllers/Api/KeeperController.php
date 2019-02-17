<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 12/31/2018
 * Time: 9:21 PM
 */

namespace App\Http\Controllers\Api;


use App\Model\Keeper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
class KeeperController extends Controller
{
    public function getKeeper(Request $req) {
        try {
            $acs_id = 0;
            if ($req->has("acs_id")) {
                $acs_id = $req->acs_id;
            }
            $keeper = new Keeper();
            $data = $keeper->getKeeperPaging($acs_id);
            $paging = $keeper->getPagingInfo($acs_id);
        } catch (\Throwable $e) {
            throw $e;
        }
            return response()->json(['acs_keeper' => $data, 'paging' => $paging,'success' => true, 'message' => ''], 200);

    }

    public function insertKeeper(Request $req) {
        $message = __("Successfully processed.");
        if ($req->has("keeper")) {
            $params = json_decode($req->input('keeper'), true);
            $keeper = new Keeper();
            $id = $keeper->insertKeeper($params);
        }
        return response()->json(['acs_keeper_id'=>$id, 'message' => $message, 'method'=>'insert'], 200);
    }

    public function updateKeeper(Request $req) {
        $message = __("Successfully processed.");
        if ($req->has("keeper")) {
            $params = json_decode($req->input('keeper'), true);
            $keeper = new Keeper();
            $keeper->updateKeeper($params);
        }
        return response()->json(['message' => $message, 'method'=>'insert'], 200);
    }

    public function deleteKeeper($id) {
        $message = __("Successfully processed.");
        if (!empty($id)) {
            $keeper = new Keeper();
            $keeper->deleteKeeper($id);
        }
        return response()->json(['message' => $message, 'method'=>'insert'], 200);
    }
}