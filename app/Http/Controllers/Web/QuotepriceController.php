<?php

namespace App\Http\Controllers\Web;

use App\Helper;
use App\Model\Quoteprice;
use App\Model\QuotepriceDetail;
use App\Model\ProductStatus;
use App\Model\CustomerAddress;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class QuotepriceController extends Controller
{

    public function index(Request $request)
    {
        try {
            $qp = new Quoteprice();
            $qpData = $qp->getQuoteprices();
            $pagingData = $qp->getPagingInfo();
            $pagingData['page'] = 0;
            return view('quoteprice', ['quoteprices' => $qpData, 'paging' => $pagingData]);
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function detail(Request $request, $qp_id)
    {
        $qp = new Quoteprice();
        $qpData = $qp->getQuoteprice($qp_id);

        if ($qpData == null) {
            return response()->view('errors.404', [], 404);
        }
        $qpDetail = new QuotepriceDetail();
        $qpDetailData = $qpDetail->getQuotepriceDetailsByQpId($qp_id);

        $prdStatus = new ProductStatus();
        $prdStatusData = $prdStatus->getAllStatus();

        $cusAddress = new CustomerAddress();
        $cusAddressData = $cusAddress->getAddressByCusId($qpData->cus_id);
        return view('quoteprice_input', [
            'quoteprice' => $qpData,
            'quotepriceDetail' => $qpDetailData,
            'prdStatus' => Helper::convertDataToDropdownOptions($prdStatusData, 'id', 'title'),
            'cusAddress' => Helper::convertDataToDropdownOptions($cusAddressData, 'cad_id', 'cad_address'),
        ]);
    }

    public function create(Request $request, $cus_id)
    {
        $qp = new Quoteprice();
        $qpData = $qp->getQuoteprice($qp_id);

        if ($qpData == null) {
            return response()->view('errors.404', [], 404);
        }
        $qpDetail = new QuotepriceDetail();
        $qpDetailData = $qpDetail->getQuotepriceDetailsByQpId($qp_id);

        $productStatus = new ProductStatus();
        $statusList = $productStatus->getAllStatus();
        return view('quoteprice_input', [
            'quoteprice' => $qpData,
            'auotepriceDetail' => $qpDetailData,
            'statusList' => Helper::convertDataToDropdownOptions($statusList, 'id', 'title')
        ]);
    }
}
