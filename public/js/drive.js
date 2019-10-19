function generate_breadcrumb_func() {
    var html = "";
    html += '<a class="dropdown-item" href="#"><i class="fas fa-folder-plus"></i>Thư mục mới</a>';
    html += '<div class="dropdown-divider"></div>';
    html += '<a class="dropdown-item" href="#"><i class="fas fa-file-export"></i>Di chuyển tới</a>';
    html += '<a class="dropdown-item" href="#"><i class="fas fa-pencil-alt"></i>Đổi tên</a>';
    html += '<a class="dropdown-item" href="#"><i class="fas fa-palette"></i>Thay đổi màu</a>';
    html += '<div class="dropdown-divider"></div>';
    html += '<a class="dropdown-item" href="#"><i class="fas fa-info-circle"></i>Chi tiết</a>';
    html += '<a class="dropdown-item" href="#"><i class="fas fa-download"></i>Tải xuống</a>';
    html += '<div class="dropdown-divider"></div>';
    html += '<a class="dropdown-item" href="#"><i class="fas fa-trash-alt"></i>Xóa</a>';
    return html;
}

function o_context_menu(self, event) {
    event.preventDefault();
    var drd_id = 'output-context-menu';
    if ($(self).find('div.dropdown').length == 0) {
        add_dropdown_menu(self, drd_id);
    }
    $("#" + drd_id).trigger('click');
}

function context_menu(self, event) {
    event.preventDefault();
    var drd_id = 'folder-context-menu';
    if ($(self).find('div.dropdown').length == 0) {
        add_dropdown_menu(self, drd_id);
    }
    $("#" + drd_id).trigger('click');
}

function add_dropdown_menu(self, drd_id) {
    var html = "";
    html += '<div class="dropdown"';
    html += 'id="' + drd_id + '"';
    html += 'role="button" data-toggle="dropdown"';
    html += 'aria-haspopup="true" aria-expanded="false">';
    html += '<div class="dropdown-menu" aria-labelledby="' + drd_id + '">a,b,c</div>';
    html += '</div>';
    $(self).append(html);
}

function fnc_init_upload_dialog() {
    var modal_html = "";
    modal_html += '<div class="modal fade" id="upload-modal" tabIndex="-1" role="dialog" aria-hidden="true">';
    modal_html += '<div class="modal-dialog" role="document" style="max-width: unset; padding: 20px; margin: 0px; width: 100%; height: 100%">';
    modal_html += '<div class="modal-content" style="width: 100%; height: 100%; padding: 10px">';
    modal_html += '<div class="file-loading">';
    modal_html += '<input id="drive-files" name="drive-files[]" type="file" multiple webkitdirectory>';
    modal_html += '</div>';
    modal_html += '<div id="errorBlock" class="help-block"></div>';
    modal_html += '</div>';
    modal_html += '</div>';
    modal_html += '</div>';
    $("body").append(modal_html);
    $("#drive-files").fileinput({
        theme: 'fas',
        language: 'vi',
        uploadUrl: 'abc',
        hideThumbnailContent: true
    });
}

function fnc_open_upload_dialog() {
    var upload_modal = $("body").find('#upload-modal');
    if (upload_modal.length == 0) {
        fnc_init_upload_dialog();
        upload_modal = $("body").find('#upload-modal');
    }
    upload_modal.modal('toggle');
}

jQuery(document).ready(function () {
    $('#dri-breadcrumb-drd').on('show.bs.dropdown', function () {
        var breadcrumb_func = generate_breadcrumb_func();
        $('#dri-breadcrumb-drd').find('.dropdown-menu').empty();
        $('#dri-breadcrumb-drd').find('.dropdown-menu').html(breadcrumb_func);
    })
    fnc_set_scrollbars("nicescroll-oput");
});