<div class="headbar">
    <div class="banner" role="banner">
        <header class="header">
            <div class="hyo">
                <div class="lyo">
                    <a class="ayo" role="button" tabindex="0">
                        @yield('headbar-icon')
                        <span class="title">@yield('headbar-title')</span>
                    </a>
                </div>
                <div class="myo">
                    @yield('search')
                </div>
                <div class="ryo">
                    <div class="pyo">
                        <div class="nyo">
                            <a role="button" tabindex="0" onclick="show_apps_form()">
								<svg class="utooltip" title="{{ __("Ubiz apps") }}" focusable="false" viewBox="0 0 512 512" style="width:20px">
									<path fill="currentColor" d="M149.333 56v80c0 13.255-10.745 24-24 24H24c-13.255 0-24-10.745-24-24V56c0-13.255 10.745-24 24-24h101.333c13.255 0 24 10.745 24 24zm181.334 240v-80c0-13.255-10.745-24-24-24H205.333c-13.255 0-24 10.745-24 24v80c0 13.255 10.745 24 24 24h101.333c13.256 0 24.001-10.745 24.001-24zm32-240v80c0 13.255 10.745 24 24 24H488c13.255 0 24-10.745 24-24V56c0-13.255-10.745-24-24-24H386.667c-13.255 0-24 10.745-24 24zm-32 80V56c0-13.255-10.745-24-24-24H205.333c-13.255 0-24 10.745-24 24v80c0 13.255 10.745 24 24 24h101.333c13.256 0 24.001-10.745 24.001-24zm-205.334 56H24c-13.255 0-24 10.745-24 24v80c0 13.255 10.745 24 24 24h101.333c13.255 0 24-10.745 24-24v-80c0-13.255-10.745-24-24-24zM0 376v80c0 13.255 10.745 24 24 24h101.333c13.255 0 24-10.745 24-24v-80c0-13.255-10.745-24-24-24H24c-13.255 0-24 10.745-24 24zm386.667-56H488c13.255 0 24-10.745 24-24v-80c0-13.255-10.745-24-24-24H386.667c-13.255 0-24 10.745-24 24v80c0 13.255 10.745 24 24 24zm0 160H488c13.255 0 24-10.745 24-24v-80c0-13.255-10.745-24-24-24H386.667c-13.255 0-24 10.745-24 24v80c0 13.255 10.745 24 24 24zM181.333 376v80c0 13.255 10.745 24 24 24h101.333c13.255 0 24-10.745 24-24v-80c0-13.255-10.745-24-24-24H205.333c-13.255 0-24 10.745-24 24z"></path>
								</svg>
                            </a>
                        </div>
                        <div class="nyo">
                            <a role="button" tabindex="0" onclick="show_notify_form()">
                                <div class="qyo">0</div>
								<svg class="utooltip" title="{{ __("Notifications") }}" focusable="false"  viewBox="0 0 448 512" style="width:18px">
									<path fill="currentColor" d="M439.39 362.29c-19.32-20.76-55.47-51.99-55.47-154.29 0-77.7-54.48-139.9-127.94-155.16V32c0-17.67-14.32-32-31.98-32s-31.98 14.33-31.98 32v20.84C118.56 68.1 64.08 130.3 64.08 208c0 102.3-36.15 133.53-55.47 154.29-6 6.45-8.66 14.16-8.61 21.71.11 16.4 12.98 32 32.1 32h383.8c19.12 0 32-15.6 32.1-32 .05-7.55-2.61-15.27-8.61-21.71zM67.53 368c21.22-27.97 44.42-74.33 44.53-159.42 0-.2-.06-.38-.06-.58 0-61.86 50.14-112 112-112s112 50.14 112 112c0 .2-.06.38-.06.58.11 85.1 23.31 131.46 44.53 159.42H67.53zM224 512c35.32 0 63.97-28.65 63.97-64H160.03c0 35.35 28.65 64 63.97 64z"></path>
								</svg>
                            </a>
                        </div>
                        <div id="apps-form" class="mvo">
                            <div class="xvo">
                                <div class="bvo">
                                    <ul class="cto">
                                        <li class="who">
                                            <a class="ruo" role="button" href="/setting/company">
                                                <div class="pto">
                                                    <img src="{{asset('images/app_bg.png')}}">
                                                    <div class="zro">
                                                        <div class="rco">
                                                            <div class="kko">{{ __("Company") }}</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                        <li class="who">
                                            <a class="ruo" role="button" href="/setting/departments">
                                                <div class="pto">
                                                    <img src="{{asset('images/app_bg.png')}}">
                                                    <div class="zro">
                                                        <div class="rco">
                                                            <div class="kko">{{ __("Department") }}</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                        <li class="who">
                                            <a class="ruo" role="button" href="/setting/users">
                                                <div class="pto">
                                                    <img src="{{asset('images/app_bg.png')}}">
                                                    <div class="zro">
                                                        <div class="rco">
                                                            <div class="kko">{{ __("Employee") }}</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                        <li class="who">
                                            <a class="ruo" role="button" href="/setting/currency">
                                                <div class="pto">
                                                    <img src="{{asset('images/app_bg.png')}}">
                                                    <div class="zro">
                                                        <div class="rco">
                                                            <div class="kko">{{ __("Currency") }}</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                        <li class="who">
                                            <a class="ruo" role="button" href="/customers">
                                                <div class="pto">
                                                    <img src="{{asset('images/app_bg.png')}}">
                                                    <div class="zro">
                                                        <div class="rco">
                                                            <div class="kko">{{ __("Customer") }}</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                        <li class="who">
                                            <a class="ruo" role="button" href="/suppliers">
                                                <div class="pto">
                                                    <img src="{{asset('images/app_bg.png')}}">
                                                    <div class="zro">
                                                        <div class="rco">
                                                            <div class="kko">{{ __("Supplier") }}</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                        <li class="who">
                                            <a class="ruo" role="button" href="/brands">
                                                <div class="pto">
                                                    <img src="{{asset('images/app_bg.png')}}">
                                                    <div class="zro">
                                                        <div class="rco">
                                                            <div class="kko">{{ __("Product") }}</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                        <li class="who">
                                            <a class="ruo" role="button" href="/events">
                                                <div class="pto">
                                                    <img src="{{asset('images/app_bg.png')}}">
                                                    <div class="zro">
                                                        <div class="rco">
                                                            <div class="kko">{{ __("Events Calendar") }}</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                        <li class="who">
                                            <a class="ruo" role="button" href="/quoteprices">
                                                <div class="pto">
                                                    <img src="{{asset('images/app_bg.png')}}">
                                                    <div class="zro">
                                                        <div class="rco">
                                                            <div class="kko">{{ __("QP") }}</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                        <li class="who">
                                            <a class="ruo" role="button" href="/orders">
                                                <div class="pto">
                                                    <img src="{{asset('images/app_bg.png')}}">
                                                    <div class="zro">
                                                        <div class="rco">
                                                            <div class="kko">{{ __("Order") }}</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                        <li class="who">
                                            <a class="ruo" role="button" href="/report">
                                                <div class="pto">
                                                    <img src="{{asset('images/app_bg.png')}}">
                                                    <div class="zro">
                                                        <div class="rco">
                                                            <div class="kko">Báo cáo</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                        <li class="who">
                                            <a class="ruo" role="button" href="/drive">
                                                <div class="pto">
                                                    <img src="{{asset('images/app_bg.png')}}">
                                                    <div class="zro">
                                                        <div class="rco">
                                                            <div class="kko">{{ __("Drive") }}</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div id="notify-form" class="mvo">
                            <div class="qvo">
                                <div class="lvo"></div>
                            </div>
                        </div>
                        <div id="account-form" class="mvo">
                            <div class="uvo">
                                <div class="zho">
                                    <div class="ano">
                                        <a class="yno">
                                            <img class="pno" src="{!! $cps_user->avatar !!}">
                                            <span class="wno">{{ __("Change") }}</span>
                                        </a>
                                        <div class="rho">
                                            <div class="iho" id="user_name">{{ $cps_user->name }}</div>
                                            <div class="mno" id="user_email">{{ $cps_user->email }}</div>
                                            <div class="jno">
                                                <a href="#">{{ __("Privacy") }}</a>
                                            </div>
                                            <button type="button" class="btn btn-primary btn-sm ">{{ __("Account") }}</button>
                                        </div>
                                    </div>
                                    <div class="tno">
                                        <button type="button" class="btn btn-outline-secondary btn-sm" onclick="logout()">{{ __("Logout") }}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="wyo" role="button" onclick="show_account_form()">
                        <div class="zyo">
                            <img src="{{$cps_company->com_logo}}">
                        </div>
                        <div class="vyo">
                            <a>
                                <span>
                                    <img src="{!! $cps_user->avatar !!}">
                                </span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </header>
    </div>
</div>