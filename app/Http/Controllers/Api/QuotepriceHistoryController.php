<?php

namespace App\Http\Controllers\Api;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Model\Customer;
use App\Model\QuotepriceHistory;

class QuotepriceHistoryController extends Controller
{
    public function search(Request $request, $qp_id)
    {
        try {
            $qpModel = new QuotepriceHistory();
            list($page, $sort, $search) = $this->getRequestData($request);
            $qpData = $qpModel->search($qp_id, $page, $sort, $search);
            $pagingData = $qpModel->getPagingInfo($qp_id, $search);
            $pagingData['page'] = $page;
            return response()->json([
                'quoteprices' => $qpData,
                'paging' => $pagingData,
                'success' => true,
                'message' => __('Successfully processed.')
            ], 200);
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function getRequestData(Request $request)
    {
        $page = 0;
        if ($request->has('page')) {
            $page = $request->page;
        }

        $sort = '';
        if ($request->has('sort')) {
            $sort = $request->sort;
        }

        $search = $request->get('search', '');

        return [$page, $sort, $search];
    }
}
