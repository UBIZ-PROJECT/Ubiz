<?php

namespace App\Http\Controllers\Web;

use App\User;
use App\Model\Customer;
use App\Model\QuotepriceHistory;
use App\Model\QuotepriceDetailHistory;
use App\Model\ProductStatus;
use App\Model\CustomerAddress;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class QuotepriceHistoryController extends Controller
{

    public function index(Request $request, $qp_id)
    {
        try {
            $qpModel = new QuotepriceHistory();
            $qpData = $qpModel->getQuoteprices($qp_id);
            $pagingData = $qpModel->getPagingInfo($qp_id);
            $pagingData['page'] = 0;
            return view('his_quoteprice', ['qp_id' => $qp_id, 'quoteprices' => $qpData, 'paging' => $pagingData]);
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function detail(Request $request, $qp_id, $his_qp_id)
    {
        $qpModel = new QuotepriceHistory();
        $qpData = $qpModel->getQuoteprice($qp_id, $his_qp_id);

        if ($qpData == null) {
            return response()->view('errors.404', [], 404);
        }
        $qpDetail = new QuotepriceDetailHistory();
        $qpDetailData = $qpDetail->getQuotepriceDetailsByQpId($qp_id, $his_qp_id);

        $prdStatus = new ProductStatus();
        $prdStatusData = $prdStatus->getAllStatus();

        $cusAddress = new CustomerAddress();
        $cusAddressData = $cusAddress->getAddressByCusId($qpData->cus_id);
        return view('his_quoteprice_detail', [
            'quoteprice' => $qpData,
            'quotepriceDetail' => $qpDetailData,
            'prdStatus' => convertDataToDropdownOptions($prdStatusData, 'id', 'title'),
            'cusAddress' => convertDataToDropdownOptions($cusAddressData, 'cad_id', 'cad_address'),
        ]);
    }
}
