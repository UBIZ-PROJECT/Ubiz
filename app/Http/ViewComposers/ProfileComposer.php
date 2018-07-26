<?php
/**
 * Created by PhpStorm.
 * User: Thuan Evi
 * Date: 7/21/2018
 * Time: 11:30 PM
 */

namespace App\Http\ViewComposers;

use App\User;
use Illuminate\View\View;

class ProfileComposer
{
    protected $user;

    public function __construct()
    {
        $user = new User();
        $this->user = $user->getAuthUser();
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('auth_user', $this->user);
    }
}