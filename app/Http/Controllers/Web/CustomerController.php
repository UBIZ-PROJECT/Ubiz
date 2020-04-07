<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Model\Customer;
use App\Model\CustomerType;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
		try {
		    checkUserRight(5,1);
			$customer = new Customer();
            $customerType = new CustomerType();

            $customerList = $customer->search();

            $customerTypeList = $customerType->getAllTypes();

            $addLocations = $customer->getAddressLocation();

            $usersModel = new User();
			$usersData = $usersModel->getAllUsers();
			$paging = $customer->getPagingInfo();
			$paging['page'] = 0;
			foreach($customerList as $key => $item){
                $customerList[$key]->address = $customer->getCustomerAddress($item->cus_id);
			}
			return view('customer', [
			    'customers' => $customerList,
                'customerTypeList' => $customerTypeList,
                'addLocations' => $addLocations,
                'users' => $usersData,
                'paging' => $paging
            ]);
		} catch (\Throwable $e) {
            throw $e;
        }
    }

}
