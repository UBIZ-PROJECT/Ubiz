<?php
/**
 * Created by PhpStorm.
 * User: Thuan Evi
 * Date: 7/21/2018
 * Time: 11:30 PM
 */

namespace App\Http\ViewComposers;

use App\User;
use App\Model\Company;
use Illuminate\View\View;

class ProfileComposer
{
    protected $user;
    protected $company;

    public function __construct()
    {
        $user = new User();
        $this->user = $user->getAuthUser();

        $company = new Company();
        $this->company = $company->getCompanyById($this->user->com_id);
    }

    /**
     * Bind data to the view.
     *
     * @param  View $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('cps_user', $this->user)
            ->with('cps_company', $this->company);
    }
}