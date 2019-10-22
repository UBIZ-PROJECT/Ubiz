function fnc_show_selected_function() {
    $(".selected-function").show();
}

function fnc_hide_selected_function() {
    $(".selected-function").hide();
}

function fnc_get_selected_folders() {
    var data = new Array();
    var selected_folders = $("#folder-container").find(".folder.selected");
    selected_folders.each(function () {
        var uniq = $(this).attr('id');
        data.push(uniq);
    });
    return data;
}

function fnc_get_selected_files() {
    var data = new Array();
    var selected_files = $("#file-container").find(".file.selected");
    selected_files.each(function () {
        var uniq = $(this).attr('id');
        data.push(uniq);
    });
    return data;
}

function fnc_drive_container_click(self) {
    fnc_un_selected_folder_list();
    fnc_un_selected_file_list();
    fnc_hide_selected_function();
}

function fnc_un_selected_folder_list() {
    var folder_list = $(".folder-list");
    if (folder_list.length > 0) {
        var selected_folders = folder_list.find('.folder.selected');
        if (selected_folders.length > 0) {
            selected_folders.removeClass('selected');
        }
    }
}

function fnc_un_selected_file_list() {
    var folder_list = $(".file-list");
    if (folder_list.length > 0) {
        var selected_files = folder_list.find('.file.selected');
        if (selected_files.length > 0) {
            selected_files.removeClass('selected');
        }
    }
}

function fnc_render_folder_list(folder_list) {
    var folder_list_html = "";
    _.forEach(folder_list, function (folder) {
        folder_list_html += fnc_render_folder(folder);
    });
    $("#folder-container").find(".folder-list").append(folder_list_html);
    $("#folder-container").css('visibility', 'visible');
}

function fnc_render_folder(folder) {
    var html = "";
    html += '<div class="col-auto">';
    html += '<div id="' + folder.dri_uniq + '" class="folder" onclick="fnc_folder_click(this)">';
    html += '<i class="fa-icon fas fa-folder"></i>';
    html += '<span>';
    html += folder.dri_name;
    html += '</span>';
    html += '</div>';
    html += '<button class="ellipsis" onclick="fnc_open_folder_drd_menu(this,\'' + folder.dri_uniq + '\')">';
    html += '<i class="fas fa-ellipsis-v"></i>';
    html += '</button>';
    html += '</div>';
    return html;
}

function fnc_render_file_list(file_list) {
    var file_list_html = "";
    _.forEach(file_list, function (file) {
        file_list_html += fnc_render_file(file);
    });
    $("#file-container").find(".file-list").append(file_list_html);
    $("#file-container").css('visibility', 'visible');
}

function fnc_render_file(file) {
    var html = "";
    html += '<div class="col-auto">';
    html += '<div id="' + file.dri_uniq + '" class="file" onclick="fnc_file_click(this)">';
    html += '<div class="w-100 file-thumbnail"></div>';
    html += '<div class="w-100 file-detail">';
    html += fnc_get_filetype_font_icon(file.dri_ext);
    html += '<span>';
    html += file.dri_name;
    html += '</span>';
    html += '</div>';
    html += '</div>';
    html += '<button class="ellipsis" onclick="fnc_open_file_drd_menu(this,\'' + file.dri_uniq + '\')">';
    html += '<i class="fas fa-ellipsis-v"></i>';
    html += '</button>';
    html += '</div>';
    return html;
}

function fnc_get_filetype_font_icon(file_type) {
    switch (file_type) {
        case 'xls':
        case 'xlsx':
            return '<i class="fa-icon far fa-file-excel"></i>';
            break;
        case 'doc':
        case 'docx':
            return '<i class="fa-icon far fa-file-word"></i>';
            break;
        case 'ppt':
        case 'pptx':
            return '<i class="fa-icon far fa-file-powerpoint"></i>';
            break;
        case 'htm':
        case 'html':
            return '<i class="fa-icon fas fa-file-code"></i>';
            break;
        case 'pdf':
            return '<i class="fa-icon far fa-file-pdf"></i>';
            break;
        case 'csv':
            return '<i class="fa-icon fas fa-file-csv"></i>';
            break;
        case 'rar':
        case 'zip':
            return '<i class="fa-icon far fa-file-archive"></i>';
            break;
        case '3gp':
        case 'aa':
        case 'aac':
        case 'aax':
        case 'act':
        case 'aiff':
        case 'alac':
        case 'amr':
        case 'ape':
        case 'au':
        case 'awb':
        case 'dct':
        case 'dss':
        case 'dvf':
        case 'flac':
        case 'gsm':
        case 'iklax':
        case 'ivs':
        case 'm4a':
        case 'm4b':
        case 'm4p':
        case 'mmf':
        case 'mp3':
        case 'mpc':
        case 'msv':
        case 'nmf':
        case 'nsf':
        case 'ogg':
        case 'oga':
        case 'mogg':
        case 'opus':
        case 'ra':
        case 'rm':
        case 'raw':
        case 'sln':
        case 'tta':
        case 'voc':
        case 'vox':
        case 'wav':
        case 'wma':
        case 'wv':
        case 'webm':
        case '8svx':
            return '<i class="fa-icon fas fa-file-audio"></i>';
            break;
        case 'flv':
        case 'vob':
        case 'ogv':
        case 'ogg':
        case 'drc':
        case 'gif':
        case 'gifv':
        case 'mng':
        case 'avi':
        case 'mts':
        case 'm2ts':
        case 'ts':
        case 'mov':
        case 'qt':
        case 'wmv':
        case 'yuv':
        case 'rm':
        case 'rmvb':
        case 'asf':
        case 'amv':
        case 'mp4':
        case 'm4p':
        case 'm4v':
        case 'mpg':
        case 'mp2':
        case 'mpeg':
        case 'mpe':
        case 'mpv':
        case 'mpg':
        case 'm2v':
        case 'm4v':
        case 'svi':
        case '3gp':
        case '3g2':
        case 'mxf':
        case 'roq':
        case 'nsv':
        case 'f4v':
        case 'f4p':
        case 'f4a':
        case 'f4b':
            return '<i class="fa-icon far fa-file-video"></i>';
            break;
        case 'jpg':
        case 'png':
        case 'gif':
        case 'webp':
        case 'tiff':
        case 'psd':
        case 'raw':
        case 'bmp':
        case 'heif':
        case 'indd':
        case 'jpeg':
        case 'svg':
        case 'ai':
        case 'eps':
            return '<i class="fa-icon far fa-file-image"></i>';
            break;
        default:
            return '<i class="fa-icon fa fa-file-alt"></i>';
    }
}

function fnc_render_drive(data) {

    fnc_render_breadcrumb(data['breadcrum']);

    var folder_list = data['folders'];
    var file_list = data['files'];
    if (folder_list.length > 0) {
        fnc_render_folder_list(folder_list);
    }
    if (file_list.length > 0) {
        fnc_render_file_list(file_list);
    }
}

function fnc_render_breadcrumb(breadcrumb) {

    var breadcrumb_html = '';
    _.forEachRight(breadcrumb, function (item) {
        var item_html = fnc_render_breadcrumb_item(item);
        breadcrumb_html = item_html + breadcrumb_html;
    });
    $("#dri-breadcrumb").append(breadcrumb_html);
}

function fnc_render_breadcrumb_item(item) {

    var html = "";
    if (item['is_root'] == false) {
        html += '<div class="col-auto dri-breadcrumb-item">';
        html += '<i class="fas fa-angle-right"></i>';
        html += '</div>';
    }

    html += '<div class="col-auto dri-breadcrumb-item">';
    if (item['is_last'] == true) {
        if (item['is_root'] == false) {
            html += '<a role="button" href="#' + item['dri_uniq'] + '" onclick="fnc_open_breadcrumb_drd_menu(this)">';
        } else {
            html += '<a role="button" href="#' + item['dri_uniq'] + '" onclick="fnc_open_root_breadcrumb_drd_menu(this)">';
        }
    } else {
        html += '<a role="button" href="#' + item['dri_uniq'] + '" onclick="fnc_select_breadcrumb_item(this)">';
    }
    html += item['dri_name'];
    if (item['is_last'] == true) {
        html += '<i class="fas fa-caret-down"></i>';
    }
    html += '</a>';
    html += '</div>';

    return html;
}

function fnc_render_nav_child(nav_items) {
    var nav_html = "";
    _.forEach(nav_items, function (item) {
        nav_html += fnc_render_nav_child_item(item);
    });
    return nav_html;
}

function fnc_render_nav_child_item(item) {
    var html = "";
    html += '<div id="' + item.dri_uniq + '" class="nav-li pdr-30">';
    html += '<div class="row justify-content-start z-mgr z-mgl nav-item">';
    html += '<div class="col-auto z-pdr">';
    html += '<div class="nav-level"></div>';
    html += '<i class="nav-right nav-caret fas fa-caret-right"></i>';
    html += '<i class="nav-down nav-caret fas fa-caret-down hidden-content"></i>';
    html += '<img class="nav-caret nav-loading hidden-content" src="/images/ajax-loader.gif">';
    html += '</div>';
    html += '<div class="col-auto z-pdl z-pdr"><i class="far fa-hdd"></i></div>';
    html += '<div class="col-auto pdl-5 nav-label"><span>' + item.dri_name + '</span></div>';
    html += '</div>';
    html += '<div class="nav-li"></div>';
    html += '</div>';
    return html;
}

function fnc_folder_click(self) {
    var is_selected = $(self).hasClass('selected');
    if (is_selected == true) {
        $(self).removeClass('selected');
    } else {
        $(self).addClass('selected');
    }

    setTimeout(function () {
        var selected_folders = fnc_get_selected_folders();
        var selected_files = fnc_get_selected_files();
        if (selected_folders.length == 0 && selected_files.length == 0)
            fnc_hide_selected_function();
        else
            fnc_show_selected_function();
    }, 5);
}

function fnc_file_click(self) {
    var is_selected = $(self).hasClass('selected');
    if (is_selected == true) {
        $(self).removeClass('selected');
    } else {
        $(self).addClass('selected');
    }

    setTimeout(function () {
        var selected_folders = fnc_get_selected_folders();
        var selected_files = fnc_get_selected_files();
        if (selected_folders.length == 0 && selected_files.length == 0)
            fnc_hide_selected_function();
        else
            fnc_show_selected_function();
    }, 5);
}

function fnc_open_create_drd_menu(self) {
    var drd_id = 'create-drd-menu';
    var el = $(self).closest('div.add-new');
    if (el.find('div.dropdown').length == 0) {
        fnc_add_root_breadcrumb_drd_menu(el, drd_id);
    }
    setTimeout(function () {
        $("#" + drd_id).dropdown('toggle');
    }, 10);
}

function fnc_add_create_drd_menu(self, drd_id) {
    var html = "";
    html += '<div class="dropdown"';
    html += 'id="' + drd_id + '"';
    html += 'role="button" data-toggle="dropdown"';
    html += 'aria-haspopup="true" aria-expanded="false">';
    html += '<div class="dropdown-menu cst-dropdown-menu" aria-labelledby="' + drd_id + '">';
    html += '<a class="dropdown-item" href="#"><i class="fas fa-folder-plus"></i>Thư mục mới</a>';
    html += '<div class="dropdown-divider"></div>';
    html += '<a class="dropdown-item" href="#" onclick="fnc_open_upload_dialog()"><i class="fas fa-upload"></i>Tải lên</a>';
    html += '</div>';
    html += '</div>';
    $(self).append(html);
}

function fnc_open_root_breadcrumb_drd_menu(self) {
    var drd_id = 'root-breadcrumb-drd-menu';
    var el = $(self).closest('div.col-auto');
    if (el.find('div.dropdown').length == 0) {
        fnc_add_root_breadcrumb_drd_menu(el, drd_id);
    }
    setTimeout(function () {
        $("#" + drd_id).dropdown('toggle');
    }, 10);
}

function fnc_add_root_breadcrumb_drd_menu(self, drd_id) {
    var html = "";
    html += '<div class="dropdown"';
    html += 'id="' + drd_id + '"';
    html += 'role="button" data-toggle="dropdown"';
    html += 'aria-haspopup="true" aria-expanded="false">';
    html += '<div class="dropdown-menu cst-dropdown-menu" aria-labelledby="' + drd_id + '">';
    html += '<a class="dropdown-item" href="#"><i class="fas fa-folder-plus"></i>Thư mục mới</a>';
    html += '<div class="dropdown-divider"></div>';
    html += '<a class="dropdown-item" href="#" onclick="fnc_open_upload_dialog()"><i class="fas fa-upload"></i>Tải lên</a>';
    html += '</div>';
    html += '</div>';
    $(self).append(html);
}

function fnc_open_breadcrumb_drd_menu(self) {
    var drd_id = 'breadcrumb-drd-menu';
    var el = $(self).closest('div.col-auto');
    if (el.find('div.dropdown').length == 0) {
        fnc_add_breadcrumb_drd_menu(el, drd_id);
    }
    setTimeout(function () {
        $("#" + drd_id).dropdown('toggle');
    }, 10);
}

function fnc_add_breadcrumb_drd_menu(self, drd_id) {
    var html = "";
    html += '<div class="dropdown"';
    html += 'id="' + drd_id + '"';
    html += 'role="button" data-toggle="dropdown"';
    html += 'aria-haspopup="true" aria-expanded="false">';
    html += '<div class="dropdown-menu cst-dropdown-menu" aria-labelledby="' + drd_id + '">';
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
    html += '</div>';
    html += '</div>';
    $(self).append(html);
}

function fnc_open_file_drd_menu(self, dri_uniq) {
    var drd_id = 'file-drd-menu-' + dri_uniq;
    var el = $(self).closest('div.col-auto');
    if (el.find('div.dropdown').length == 0) {
        fnc_add_file_drd_menu(el, drd_id);
    }
    setTimeout(function () {
        $("#" + drd_id).dropdown('toggle');
    }, 10);
}

function fnc_add_file_drd_menu(self, drd_id) {
    var html = "";
    html += '<div class="dropdown"';
    html += 'id="' + drd_id + '"';
    html += 'role="button" data-toggle="dropdown"';
    html += 'aria-haspopup="true" aria-expanded="false">';
    html += '<div class="dropdown-menu cst-dropdown-menu" aria-labelledby="' + drd_id + '">';
    html += '<a class="dropdown-item" href="#"><i class="fas fa-file-export"></i>Di chuyển tới</a>';
    html += '<a class="dropdown-item" href="#"><i class="fas fa-pencil-alt"></i>Đổi tên</a>';
    html += '<a class="dropdown-item" href="#"><i class="fas fa-palette"></i>Thay đổi màu</a>';
    html += '<div class="dropdown-divider"></div>';
    html += '<a class="dropdown-item" href="#"><i class="fas fa-info-circle"></i>Chi tiết</a>';
    html += '<a class="dropdown-item" href="#"><i class="fas fa-copy"></i>Tạo bản sao</a>';
    html += '<a class="dropdown-item" href="#"><i class="fas fa-download"></i>Tải xuống</a>';
    html += '<div class="dropdown-divider"></div>';
    html += '<a class="dropdown-item" href="#"><i class="fas fa-trash-alt"></i>Xóa</a>';
    html += '</div>';
    html += '</div>';
    $(self).append(html);
}

function fnc_open_folder_drd_menu(self, dri_uniq) {
    var drd_id = 'folder-drd-menu-' + dri_uniq;
    var el = $(self).closest('div.col-auto');
    if (el.find('div.dropdown').length == 0) {
        fnc_add_folder_drd_menu(el, drd_id);
    }
    setTimeout(function () {
        $("#" + drd_id).dropdown('toggle');
    }, 10);
}

function fnc_add_folder_drd_menu(self, drd_id) {
    var html = "";
    html += '<div class="dropdown"';
    html += 'id="' + drd_id + '"';
    html += 'role="button" data-toggle="dropdown"';
    html += 'aria-haspopup="true" aria-expanded="false">';
    html += '<div class="dropdown-menu cst-dropdown-menu" aria-labelledby="' + drd_id + '">';
    html += '<a class="dropdown-item" href="#"><i class="fas fa-file-export"></i>Di chuyển tới</a>';
    html += '<a class="dropdown-item" href="#"><i class="fas fa-pencil-alt"></i>Đổi tên</a>';
    html += '<a class="dropdown-item" href="#"><i class="fas fa-palette"></i>Thay đổi màu</a>';
    html += '<div class="dropdown-divider"></div>';
    html += '<a class="dropdown-item" href="#"><i class="fas fa-info-circle"></i>Chi tiết</a>';
    html += '<a class="dropdown-item" href="#"><i class="fas fa-download"></i>Tải xuống</a>';
    html += '<div class="dropdown-divider"></div>';
    html += '<a class="dropdown-item" href="#"><i class="fas fa-trash-alt"></i>Xóa</a>';
    html += '</div>';
    html += '</div>';
    $(self).append(html);
}

function fnc_init_upload_dialog() {
    var modal_html = "";
    modal_html += '<div class="modal fade" id="upload-modal" tabIndex="-1" role="dialog" aria-hidden="true">';
    modal_html += '<div class="modal-dialog" role="document" style="max-width: unset; padding: 20px; margin: 0px; width: 100%; height: 100%">';
    modal_html += '<div class="modal-content" style="width: 100%; height: 100%; padding: 10px">';
    modal_html += '<div class="file-loading">';
    modal_html += '<input id="upload-files" name="upload-files[]" type="file" multiple webkitdirectory>';
    modal_html += '</div>';
    modal_html += '<div id="errorBlock" class="help-block"></div>';
    modal_html += '</div>';
    modal_html += '</div>';
    modal_html += '</div>';
    $("body").append(modal_html);
}

function fnc_init_upload_plugin(uploadUrl) {
    $('#upload-files').fileinput('destroy');
    $("#upload-files").fileinput({
        theme: 'fas',
        language: 'vi',
        uploadAsync: false,
        uploadUrl: uploadUrl,
        hideThumbnailContent: true,
        minFileCount: 1,
        maxFileCount: 20
    });
}

function md5_hash_generator(str) {
    if (str == "" || str == null) {
        return '';
    }
    return CryptoJS.MD5(str).toString().toUpperCase();
}

function fnc_open_upload_dialog() {
    var upload_modal = $("body").find('#upload-modal');
    if (upload_modal.length == 0) {
        fnc_init_upload_dialog();
        upload_modal = $("body").find('#upload-modal');
    }
    var uniqid = window.location.hash.slice(1);
    if (uniqid == "") {
        uniqid = md5_hash_generator('root');
    }
    var uploadUrl = "api/v1/drive/" + uniqid + "/upload";
    fnc_init_upload_plugin(uploadUrl);
    upload_modal.modal('toggle');
}

function fnc_get_drive(dri_uniq) {
    ubizapis('v1', '/drive/' + dri_uniq, 'get', null, null, fnc_get_drive_callback);
}

function fnc_get_drive_callback(res) {
    if (res.data.success == true) {
        fnc_render_drive(res.data.data);
    } else {
        swal.fire({
            type: 'error',
            title: res.data.message
        });
    }
}

jQuery(document).ready(function () {
    fnc_set_scrollbars("nicescroll-oput");
    var dri_uniq = md5_hash_generator('root');
    fnc_get_drive(dri_uniq);
});