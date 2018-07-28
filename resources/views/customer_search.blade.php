<div class="search">
    <div class="tyo" role="search">
        <div class="cyo">
            <input id="fuzzy" spellcheck="false" autocomplete="off" placeholder="Tìm kiếm khách hàng" value="" type="text" onkeypress="jQuery.UbizOIWidget.w_fuzzy_search_handle_enter(event)">
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
                        <label for="code">Mã khách hàng</label>
                    </span>
                    <span class="avo">
                        <input type="text" spellcheck="false" id="cus_code" value="" autocomplete="off">
                    </span>
                </div>
                <div class="rvo">
                    <span class="yvo">
                        <label for="name">Tên khách hàng<label>
                    </span>
                    <span class="avo">
                        <input type="text" spellcheck="false" id="cus_name" value="" autocomplete="off">
                    </span>
                </div>
				<div class="rvo">
                    <span class="yvo">
                        <label for="name">Loại khách hàng<label>
                    </span>
                    <span class="avo">
                        <input type="text" spellcheck="false" id="cus_type" value="" autocomplete="off">
                    </span>
                </div>
				<div class="rvo">
                    <span class="yvo">
                        <label for="phone">Điện thoại</label>
                    </span>
                    <span class="avo">
                        <input type="text" spellcheck="false" id="cus_phone" value="" autocomplete="off">
                    </span>
                </div>
				<div class="rvo">
                    <span class="yvo">
                        <label for="dep_name">Fax</label>
                    </span>
                    <span class="avo">
                        <input type="text" spellcheck="false" id="cus_fax" value="" autocomplete="off">
                    </span>
                </div>
                <div class="rvo">
                    <span class="yvo">
                        <label for="email">E-mail</label>
                    </span>
                    <span class="avo">
                        <input type="text" id="cus_mail" value="" autocomplete="off">
                    </span>
                </div>
                <div class="rvo">
                    <span class="yvo">
                        <label for="address">Địa chỉ</label>
                    </span>
                    <span class="avo">
                        <input type="text" spellcheck="false" id="cus_address" value="" autocomplete="off">
                    </span>
                </div>
                <div class="rvo">
                    <span class="yvo">
                        <label for="contain">Chứa các từ</label>
                    </span>
                    <span class="avo">
                        <input type="text" spellcheck="false" spellcheck="false" id="contain" value="" autocomplete="off">
                    </span>
                </div>
                <div class="rvo">
                    <span class="yvo">
                        <label for="notcontain">Không có</label>
                    </span>
                    <span class="avo">
                        <input type="text" spellcheck="false" id="notcontain" value="" autocomplete="off">
                    </span>
                </div>
                <div class="rvo fvo">
                    <button type="button" class="btn btn-primary btn-sm" onclick="jQuery.UbizOIWidget.w_search()">Tìm kiếm</button>
                    <button type="button" class="btn btn-link btn-sm text-secondary" onclick="jQuery.UbizOIWidget.w_clear_search_form()">Xóa bộ lọc</button>
                </div>
            </div>
        </div>
    </div>
</div>