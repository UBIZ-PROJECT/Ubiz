<?php
if (!isset($company)) {
    $company = "";
}
if (!isset($permission)) {
    $permission = "";
}
if (!isset($currency)) {
    $currency = "";
}
if (!isset($department)) {
    $department = "";
}
if (!isset($employee)) {
    $employee = "";
}
?>
<nav role="navigation">
    <div class="kL"></div>
    <div class="sP">
        <div class="aW {{$company}}">
            <a class="btn z-pdr z-pdl" href="/setting/company">
                <div class="mR">
                    <div class="eT">
                        <div class="Vf"></div>
                        <div class="Vg">
                            <svg x="0px" y="0px" width="20px" height="20px"
                                 viewBox="0 0 20 20" focusable="false">
                                <polygon points="5,8 10,13 15,8"></polygon>
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="iU">
                    <div class="wQ">
                        <div class="tA">
                            <div class="vD">
                                <div class="xT">
                                    <div class="oQ">
                                        <i class="material-icons">
                                            home
                                        </i>
                                    </div>
                                </div>
                                <div class="xV">
                                    <div class="oQ">
                                        <svg width="24px" height="24px" viewBox="0 0 24 24">
                                            <path fill="none" d="M0 0h24v24H0V0zm0 0h24v24H0z"></path>
                                            <path d="M3 20.01c0 1.1.89 1.99 2 1.99h14c1.1 0 2-.9 2-1.99V18H3v2.01zM18 19c.55 0 1 .45 1 1s-.45 1-1 1-1-.45-1-1 .45-1 1-1zm1-17H5c-1.1 0-2 .9-2 1.99V17h18V3.99C21 2.89 20.11 2 19 2zm-8.62 3h3.24l3.25 5.68h-3.24L10.38 5zm-3.52 6.16l3.11-5.44s1.62 2.85 1.62 2.84L8.49 14l-1.63-2.84zM15.51 14H9.3l1.62-2.84h6.21L15.51 14z"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <span class="dG">{{ __("Company info") }}</span>
                    </div>
                </div>
            </a>
        </div>
        <div class="aW {{$department}}">
            <a class="btn z-pdr z-pdl" href="/setting/departments">
                <div class="mR">
                    <div class="eT">
                        <div class="Vf"></div>
                        <div class="Vg">
                            <svg x="0px" y="0px" width="20px" height="20px"
                                 viewBox="0 0 20 20" focusable="false">
                                <polygon points="5,8 10,13 15,8"></polygon>
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="iU">
                    <div class="wQ">
                        <div class="tA">
                            <div class="vD">
                                <div class="xT">
                                    <div class="oQ">
                                        <i class="material-icons">
                                            border_all
                                        </i>
                                    </div>
                                </div>
                                <div class="xV">
                                    <div class="oQ">
                                        <svg width="24px" height="24px" viewBox="0 0 24 24">
                                            <path fill="none" d="M0 0h24v24H0V0zm0 0h24v24H0z"></path>
                                            <path d="M3 20.01c0 1.1.89 1.99 2 1.99h14c1.1 0 2-.9 2-1.99V18H3v2.01zM18 19c.55 0 1 .45 1 1s-.45 1-1 1-1-.45-1-1 .45-1 1-1zm1-17H5c-1.1 0-2 .9-2 1.99V17h18V3.99C21 2.89 20.11 2 19 2zm-8.62 3h3.24l3.25 5.68h-3.24L10.38 5zm-3.52 6.16l3.11-5.44s1.62 2.85 1.62 2.84L8.49 14l-1.63-2.84zM15.51 14H9.3l1.62-2.84h6.21L15.51 14z"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <span class="dG">{{ __("Department Setting") }}</span>
                    </div>
                </div>
            </a>
        </div>
        <div class="aW {{$employee}}">
            <a class="btn z-pdr z-pdl" href="/setting/users">
                <div class="mR">
                    <div class="eT">
                        <div class="Vf"></div>
                        <div class="Vg">
                            <svg x="0px" y="0px" width="20px" height="20px"
                                 viewBox="0 0 20 20" focusable="false">
                                <polygon points="5,8 10,13 15,8"></polygon>
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="iU">
                    <div class="wQ">
                        <div class="tA">
                            <div class="vD">
                                <div class="xT">
                                    <div class="oQ">
                                        <i class="material-icons">
                                            person
                                        </i>
                                    </div>
                                </div>
                                <div class="xV">
                                    <div class="oQ">
                                        <svg width="24px" height="24px" viewBox="0 0 24 24">
                                            <path fill="none" d="M0 0h24v24H0V0zm0 0h24v24H0z"></path>
                                            <path d="M3 20.01c0 1.1.89 1.99 2 1.99h14c1.1 0 2-.9 2-1.99V18H3v2.01zM18 19c.55 0 1 .45 1 1s-.45 1-1 1-1-.45-1-1 .45-1 1-1zm1-17H5c-1.1 0-2 .9-2 1.99V17h18V3.99C21 2.89 20.11 2 19 2zm-8.62 3h3.24l3.25 5.68h-3.24L10.38 5zm-3.52 6.16l3.11-5.44s1.62 2.85 1.62 2.84L8.49 14l-1.63-2.84zM15.51 14H9.3l1.62-2.84h6.21L15.51 14z"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <span class="dG">{{ __("Employee Setting") }}</span>
                    </div>
                </div>
            </a>
        </div>
        <div class="aW {{$permission}}" style="display: none;">
            <a class="btn z-pdr z-pdl" href="/setting/permission">
                <div class="mR">
                    <div class="eT">
                        <div class="Vf"></div>
                        <div class="Vg">
                            <svg x="0px" y="0px" width="20px" height="20px"
                                 viewBox="0 0 20 20" focusable="false">
                                <polygon points="5,8 10,13 15,8"></polygon>
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="iU">
                    <div class="wQ">
                        <div class="tA">
                            <div class="vD">
                                <div class="xT">
                                    <div class="oQ">
                                        <i class="material-icons">
                                            perm_identity
                                        </i>
                                    </div>
                                </div>
                                <div class="xV">
                                    <div class="oQ">
                                        <svg width="24px" height="24px" viewBox="0 0 24 24">
                                            <path fill="none" d="M0 0h24v24H0V0zm0 0h24v24H0z"></path>
                                            <path d="M3 20.01c0 1.1.89 1.99 2 1.99h14c1.1 0 2-.9 2-1.99V18H3v2.01zM18 19c.55 0 1 .45 1 1s-.45 1-1 1-1-.45-1-1 .45-1 1-1zm1-17H5c-1.1 0-2 .9-2 1.99V17h18V3.99C21 2.89 20.11 2 19 2zm-8.62 3h3.24l3.25 5.68h-3.24L10.38 5zm-3.52 6.16l3.11-5.44s1.62 2.85 1.62 2.84L8.49 14l-1.63-2.84zM15.51 14H9.3l1.62-2.84h6.21L15.51 14z"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <span class="dG">{{ __("Permission Setting") }}</span>
                    </div>
                </div>
            </a>
        </div>
        <div class="aW {{$currency}}">
            <a class="btn z-pdr z-pdl" href="/setting/currency">
                <div class="mR">
                    <div class="eT">
                        <div class="Vf"></div>
                        <div class="Vg">
                            <svg x="0px" y="0px" width="20px" height="20px"
                                 viewBox="0 0 20 20" focusable="false">
                                <polygon points="5,8 10,13 15,8"></polygon>
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="iU">
                    <div class="wQ">
                        <div class="tA">
                            <div class="vD">
                                <div class="xT">
                                    <div class="oQ">
                                        <i class="material-icons cl-header">
                                            attach_money
                                        </i>
                                    </div>
                                </div>
                                <div class="xV">
                                    <div class="oQ">
                                        <svg width="24px" height="24px" viewBox="0 0 24 24">
                                            <path fill="none" d="M0 0h24v24H0V0zm0 0h24v24H0z"></path>
                                            <path d="M3 20.01c0 1.1.89 1.99 2 1.99h14c1.1 0 2-.9 2-1.99V18H3v2.01zM18 19c.55 0 1 .45 1 1s-.45 1-1 1-1-.45-1-1 .45-1 1-1zm1-17H5c-1.1 0-2 .9-2 1.99V17h18V3.99C21 2.89 20.11 2 19 2zm-8.62 3h3.24l3.25 5.68h-3.24L10.38 5zm-3.52 6.16l3.11-5.44s1.62 2.85 1.62 2.84L8.49 14l-1.63-2.84zM15.51 14H9.3l1.62-2.84h6.21L15.51 14z"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <span class="dG">{{ __("Currency Setting") }}</span>
                    </div>
                </div>
            </a>
        </div>
    </div>
</nav>