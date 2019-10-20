function fnc_drive_container_click(self) {
    fnc_un_selected_folder_list();
    fnc_un_selected_file_list();
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
    return folder_list_html;
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
    html += '<button class="ellipsis" onclick="fnc_open_folder_drd_menu(this)">';
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
    return file_list_html;
}

function fnc_render_file(file) {
    var html = "";
    html += '<div class="col-auto">';
    html += '<div id="' + file.dri_uniq + '" class="file" onclick="fnc_file_click(this)">';
    html += '<div class="w-100 file-thumbnail"></div>';
    html += '<div class="w-100 file-detail">';
    html += '<i class="fa-icon fas fa-folder"></i>';
    html += '<span>';
    html += file.dri_name;
    html += '</span>';
    html += '</div>';
    html += '</div>';
    html += '<button class="ellipsis" onclick="fnc_open_file_drd_menu(this)">';
    html += '<i class="fas fa-ellipsis-v"></i>';
    html += '</button>';
    html += '</div>';
    return html;
}

function fnc_render_drive(data) {
    var folder_list = data['folder-list'];
    var file_list = data['folder-list'];
    if (folder_list.length > 0) {
        fnc_render_folder_list(folder_list);
    }
    if (file_list.length > 0) {
        fnc_render_file_list(file_list);
    }
}

function fnc_render_breadcrumb(breadcrumb) {
    var breadcrumb_html = '';
    _.forEach(breadcrumb, function (item) {
        breadcrumb_html += fnc_render_breadcrumb_item(item);
    });
    return breadcrumb_html;
}

function fnc_render_breadcrumb_item(item, is_root_item, is_last_item) {
    var html = "";
    if (is_last_item == true) {
        html += '<div class="col-auto dri-breadcrumb-item">';
        if (is_root_item == true) {
            html += '<a role="button" href="' + item.dri_uniq + '" onclick="fnc_open_root_breadcrumb_drd_menu(this)">'
        } else {
            html += '<a role="button" href="' + item.dri_uniq + '" onclick="fnc_open_breadcrumb_drd_menu(this)">';
        }
        html += item.dri_name;
        html += '<i class="fas fa-caret-down"></i>';
        html += '</a>';
        html += '</div>';
    } else {
        html += '<div class="col-auto dri-breadcrumb-item">';
        html += '<a role="button" href="' + item.dri_uniq + '">' + item.dri_name + '</a>';
        html += '</div>';
        html += '< div class="col-auto dri-breadcrumb-item" >';
        html += '< i class="fas fa-angle-right" > < /i>';
        html += '</div>';
    }
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
}

function fnc_file_click(self) {
    var is_selected = $(self).hasClass('selected');
    if (is_selected == true) {
        $(self).removeClass('selected');
    } else {
        $(self).addClass('selected');
    }
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

function fnc_open_file_drd_menu(self) {
    var drd_id = 'file-drd-menu';
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

function fnc_open_folder_drd_menu(self) {
    var drd_id = 'folder-drd-menu';
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
    modal_html += '<input id="drive-files" name="drive-files[]" type="file" multiple webkitdirectory>';
    modal_html += '</div>';
    modal_html += '<div id="errorBlock" class="help-block"></div>';
    modal_html += '</div>';
    modal_html += '</div>';
    modal_html += '</div>';
    $("body").append(modal_html);
}

function fnc_init_upload_plugin(uploadUrl) {
    $('#drive-files').fileinput('destroy');
    $("#drive-files").fileinput({
        theme: 'fas',
        language: 'vi',
        uploadUrl: uploadUrl,
        hideThumbnailContent: true,
        minFileCount: 1,
        maxFileCount: 50,
        uploadExtraData: {
            img_key: "1000",
            img_keywords: "happy, places",
        }
    });
}

function fnc_open_upload_dialog() {
    var upload_modal = $("body").find('#upload-modal');
    if (upload_modal.length == 0) {
        fnc_init_upload_dialog();
        upload_modal = $("body").find('#upload-modal');
    }
    var uniqid = window.location.hash.slice(1);
    if (uniqid == "") {
        uniqid = "#";
    }
    var uploadUrl = "drive/" + uniqid + "/upload";
    fnc_init_upload_plugin(uploadUrl);
    upload_modal.modal('toggle');
}

jQuery(document).ready(function () {
    fnc_set_scrollbars("nicescroll-oput");
});