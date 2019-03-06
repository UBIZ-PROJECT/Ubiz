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
?>
<nav role="navigation">
    <div class="kL"></div>
    <div class="sP">
        <div class="aW {{$company}}" id="li">
            <div class="mR">
                <div class="eT">
                    <div class="Vf"></div>
                    <div class="Vg"></div>
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
                        </div>
                    </div>
                    <span class="dG">{{ __("Company info") }}</span>
                </div>
            </div>
        </div>
        <div class="aW {{$permission}}" id="li">
            <div class="mR">
                <div class="eT">
                    <div class="Vf"></div>
                    <div class="Vg"></div>
                </div>
            </div>
            <div class="iU">
                <div class="wQ">
                    <div class="tA">
                        <div class="vD">
                            <div class="xT">
                                <div class="oQ">
                                    <i class="material-icons">
                                        security
                                    </i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <span class="dG">{{ __("Permission") }}</span>
                </div>
            </div>
        </div>
        <div class="aW {{$currency}}" id="li">
            <div class="mR">
                <div class="eT">
                    <div class="Vf"></div>
                    <div class="Vg"></div>
                </div>
            </div>
            <div class="iU">
                <div class="wQ">
                    <div class="tA">
                        <div class="vD">
                            <div class="xT">
                                <div class="oQ">
                                    <i class="material-icons">
                                        money
                                    </i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <span class="dG">{{ __("Currency") }}</span>
                </div>
            </div>
        </div>
    </div>
</nav>