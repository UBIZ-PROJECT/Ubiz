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
                            <a role="button" tabindex="0">
                                <svg class="utooltip" title="Ứng dụng của Ubiz" focusable="false" viewBox="0 0 24 24">
                                    <path d="M4 8h4V4H4v4zm6 12h4v-4h-4v4zm-6 0h4v-4H4v4zm0-6h4v-4H4v4zm6 0h4v-4h-4v4zm6-10v4h4V4h-4zm-6 4h4V4h-4v4zm6 6h4v-4h-4v4zm0 6h4v-4h-4v4z"></path>
                                </svg>
                            </a>
                        </div>
                        <div class="nyo">
                            <a role="button" tabindex="0">
                                <div class="qyo">0</div>
                                <svg class="utooltip" title="Thông báo" focusable="false" viewBox="0 0 24 24">
                                    <path d="M12,2C6.5,2,2,6.5,2,12c0,5.5,4.5,10,10,10s10-4.5,10-10C22,6.5,17.5,2,12,2z M12,18c-0.6,0-1-0.5-1-1h2 C13,17.5,12.5,18,12,18z M17,16H7v-0.6l1.2-1.2v-3c0-1.9,1-3.4,2.8-3.8V6.9C11.1,6.4,11.5,6,12,6s0.9,0.4,0.9,0.9v0.4 c1.8,0.4,2.8,2,2.8,3.8v3l1.2,1.2V16z"></path>
                                </svg>
                            </a>
                        </div>
                        <div id="apps-form" class="mvo">
                            <div class="xvo">
                                <div class="bvo"></div>
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
                                            <img class="pno" src="{{ asset('images/avatar.jpg') }}">
                                            <span class="wno">Thay đổi</span>
                                        </a>
                                        <div class="rho">
                                            <div class="iho">ubiz</div>
                                            <div class="mno">ubiz@gmail.com</div>
                                            <div class="jno">
                                                <a href="#">Bảo mật</a>
                                            </div>
                                            <button type="button" class="btn btn-primary btn-sm ">Tài khoản</button>
                                        </div>
                                    </div>
                                    <div class="tno">
                                        <button type="button" class="btn btn-outline-secondary btn-sm ">Đăng xuất</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="wyo">
                        <div class="zyo">
                            <img src="{{ asset('images/logo.png') }}">
                        </div>
                        <div class="vyo">
                            <a><span><img src="{{ asset('images/avatar.jpg') }}"></span></a>
                        </div>
                    </div>
                </div>
            </div>
        </header>
    </div>
</div>