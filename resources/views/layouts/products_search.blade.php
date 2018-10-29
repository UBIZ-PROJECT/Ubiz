<div class="search">
    <div class="tyo" role="search">
        <div class="cyo">
            <input id="fuzzy" spellcheck="false" autocomplete="off" placeholder="{{__("Search")}} {{__("Product")}}" value="" type="text" onkeypress="jQuery.UbizOIWidget.w_fuzzy_search_handle_enter(event)">
        </div>
        <button class="dyo" onclick="show_searh_form()">
            <svg focusable="false" height="24px" viewBox="0 0 24 24" width="24px" xmlns="http://www.w3.org/2000/svg">
                <path d="M7 10l5 5 5-5z"></path>
                <path d="M0 0h24v24H0z" fill="none"></path>
            </svg>
        </button>
        <button class="jyo">
            <svg focusable="false" height="24px" viewBox="0 0 24 24" width="24px" xmlns="http://www.w3.org/2000/svg">
                <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"></path>
                <path d="M0 0h24v24H0z" fill="none"></path>
            </svg>
        </button>
        <button class="xyo" onclick="jQuery.UbizOIWidget.w_fuzzy_search()">
            <svg focusable="false" height="24px" viewBox="0 0 24 24" width="24px" xmlns="http://www.w3.org/2000/svg">
                <path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"></path>
                <path d="M0 0h24v24H0z" fill="none"></path>
            </svg>
        </button>
    </div>
    <div id="search-form" class="eyo">
        <div class="hvo">
            <div class="gvo">
                <div class="rvo">
                    <span class="yvo">
                        <label for="name">{{__("Name")}}</label>
                    </span>
                    <span class="avo">
                        <input type="text" spellcheck="false" id="name" value="" autocomplete="off">
                    </span>
                </div>
                <div class="rvo">
                    <span class="yvo">
                        <label for="model">{{__("Model")}}</label>
                    </span>
                    <span class="avo">
                        <input type="text" spellcheck="false" id="model" value="" autocomplete="off">
                    </span>
                </div>
                <div class="rvo">
                    <span class="yvo">
                        <label for="detail">{{__("Detail")}}</label>
                    </span>
                    <span class="avo">
                        <input type="text" spellcheck="false" id="detail" value="" autocomplete="off">
                    </span>
                </div>
                <div class="rvo">
                    <span class="yvo">
                        <label for="type_id">{{__("Type")}}</label>
                    </span>
                    <span class="avo">
                         @include('components.dropdown',['width'=>'480','control_id'=>'type_id', 'data'=> Helper::convertDataToDropdownOptions($product_type, 'id', 'name_type')])
                        <input type="text" spellcheck="false" id="type_id" value="" autocomplete="off">
                    </span>
                </div>
                <div class="rvo">
                    <span class="yvo">
                        <label for="contain">{{ __('Includes the words') }}</label>
                    </span>
                    <span class="avo">
                        <input type="text" spellcheck="false" spellcheck="false" id="contain" value="" autocomplete="off">
                    </span>
                </div>
                <div class="rvo">
                    <span class="yvo">
                        <label for="notcontain">{{ __("Doesn't have") }}</label>
                    </span>
                    <span class="avo">
                        <input type="text" spellcheck="false" id="notcontain" value="" autocomplete="off">
                    </span>
                </div>
                <div class="rvo fvo">
                    <button type="button" class="btn btn-primary btn-sm" onclick="jQuery.UbizOIWidget.w_search()">{{ __("Search") }}</button>
                    <button type="button" class="btn btn-link btn-sm text-secondary" onclick="jQuery.UbizOIWidget.w_clear_search_form()">{{ __("Clear filter") }}</button>
                </div>
            </div>
        </div>
    </div>
</div>