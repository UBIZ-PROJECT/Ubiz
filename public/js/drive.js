function fnc_add_new_click(self) {
    var uniqid = window.location.hash.slice(1);
    fnc_show_drd_menu(self, uniqid, 4);
}

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
        var uniqid = $(this).attr('uniqid');
        data.push(uniqid);
    });
    return data;
}

function fnc_get_selected_files() {
    var data = new Array();
    var selected_files = $("#file-container").find(".file.selected");
    selected_files.each(function () {
        var uniqid = $(this).attr('uniqid');
        data.push(uniqid);
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
    $("#folder-container").find(".folder-list").empty();
    if (folder_list_html == "") {
        $("#folder-container").css('visibility', 'hidden');
    } else {
        $("#folder-container").find(".folder-list").append(folder_list_html);
        $("#folder-container").css('visibility', 'visible');
    }
}

function fnc_render_folder(folder) {
    var html = "";
    html += '<div class="col-auto">';
    html += '<div uniqid="' + folder.dri_uniq + '" class="folder" ondblclick="fnc_folder_double_click(this, event)" onclick="fnc_folder_click(this, event)">';
    html += '<i class="fa-icon fas fa-folder" style="color: ' + folder.dri_color + '"></i>';
    html += '<input type="hidden" id="dri-color-' + folder.dri_uniq + '" value="' + folder.dri_color + '">';
    html += '<span>';
    html += folder.dri_name;
    html += '</span>';
    html += '</div>';
    html += '<button class="ellipsis" onclick="fnc_show_drd_menu(this,\'' + folder.dri_uniq + '\', 0)">';
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
    $("#file-container").find(".file-list").empty();
    if (file_list_html == "") {
        $("#file-container").css('visibility', 'hidden');
    } else {

        $("#file-container").find(".file-list").append(file_list_html);
        $("#file-container").css('visibility', 'visible');
    }

}

function fnc_render_file(file) {
    var html = "";
    html += '<div class="col-auto">';
    html += '<div uniqid="' + file.dri_uniq + '" class="file" onclick="fnc_file_click(this)">';
    html += '<input type="hidden" id="dri-color-' + file.dri_uniq + '" value="' + file.dri_color + '">';
    html += '<div class="w-100 file-thumbnail"></div>';
    html += '<div class="w-100 file-detail">';
    html += fnc_get_filetype_font_icon(file.dri_ext, file.dri_color);
    html += '<span>';
    html += file.dri_name;
    html += '</span>';
    html += '</div>';
    html += '</div>';
    html += '<button class="ellipsis" onclick="fnc_show_drd_menu(this,\'' + file.dri_uniq + '\', 1)">';
    html += '<i class="fas fa-ellipsis-v"></i>';
    html += '</button>';
    html += '</div>';
    return html;
}

function fnc_get_filetype_font_icon(file_type, color, class_name) {
    if (!class_name)
        class_name = '';
    switch (file_type) {
        case 'xls':
        case 'xlsx':
            return '<i class="fa-icon far fa-file-excel ' + class_name + '" style="color: ' + color + '"></i>';
            break;
        case 'doc':
        case 'docx':
            return '<i class="fa-icon far fa-file-word ' + class_name + '" style="color: ' + color + '"></i>';
            break;
        case 'ppt':
        case 'pptx':
            return '<i class="fa-icon far fa-file-powerpoint ' + class_name + '" style="color: ' + color + '"></i>';
            break;
        case 'htm':
        case 'html':
            return '<i class="fa-icon fas fa-file-code ' + class_name + '" style="color: ' + color + '"></i>';
            break;
        case 'pdf':
            return '<i class="fa-icon far fa-file-pdf ' + class_name + '" style="color: ' + color + '"></i>';
            break;
        case 'csv':
            return '<i class="fa-icon fas fa-file-csv ' + class_name + '" style="color: ' + color + '"></i>';
            break;
        case 'rar':
        case 'zip':
            return '<i class="fa-icon far fa-file-archive ' + class_name + '" style="color: ' + color + '"></i>';
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
            return '<i class="fa-icon fas fa-file-audio ' + class_name + '" style="color: ' + color + '"></i>';
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
            return '<i class="fa-icon far fa-file-video ' + class_name + '" style="color: ' + color + '"></i>';
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
            return '<i class="fa-icon far fa-file-image ' + class_name + '" style="color: ' + color + '"></i>';
            break;
        default:
            return '<i class="fa-icon fa fa-file-alt ' + class_name + '" style="color: ' + color + '"></i>';
    }
}

function fnc_render_drive(data) {

    var folder_list = data['folders'];
    var file_list = data['files'];
    fnc_render_folder_list(folder_list);
    fnc_render_file_list(file_list);
    fnc_render_breadcrumb(data['breadcrum']);
    fnc_hide_selected_function();
}

function fnc_render_breadcrumb(breadcrumb) {

    var breadcrumb_html = '';
    _.forEachRight(breadcrumb, function (item) {
        var item_html = fnc_render_breadcrumb_item(item);
        breadcrumb_html = item_html + breadcrumb_html;
    });
    $("#dri-breadcrumb").empty();
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
            html += '<button class="text-primary" onclick="fnc_show_drd_menu(this, \'' + item['dri_uniq'] + '\', 2)">';
        } else {
            html += '<button class="text-primary" onclick="fnc_show_drd_menu(this, \'' + item['dri_uniq'] + '\', 3)">';
        }
    } else {
        html += '<button class="text-primary" onclick="fnc_select_breadcrumb_item(this, \'' + item['dri_uniq'] + '\' )">';
    }
    html += item['dri_name'];
    if (item['is_last'] == true) {
        html += '<i class="fas fa-caret-down"></i>';
    }
    html += '</button>';
    html += '</div>';

    return html;
}

function fnc_select_breadcrumb_item(self, uniqid) {
    history.replaceState(null, null, window.location.origin + "/drive#" + uniqid);
    setTimeout(function () {
        fnc_reload_drive();
    }, 5);
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
    html += '<div uniqid="' + item.dri_uniq + '" class="nav-li pdr-30">';
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

function fnc_folder_click(self, e) {
    e.preventDefault();
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

function fnc_folder_double_click(self, e) {

    var uniqid = $(self).attr('uniqid');
    history.replaceState(null, null, window.location.origin + "/drive#" + uniqid);

    setTimeout(function () {
        fnc_reload_drive();
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

function fnc_show_drd_menu(self, uniqid, drd_type) {

    var drd_id = 'drd-menu-' + uniqid + drd_type;
    if (drd_type == 3 || drd_type == 4) {
        drd_id = 'drd-menu-fixed-' + drd_type;
    }

    fnc_init_drd_menu(self, drd_id, drd_type, uniqid);
    setTimeout(function () {
        $("#" + drd_id).dropdown('toggle');
    }, 10);
}

function fnc_init_drd_menu(self, drd_id, drd_type, uniqid) {

    var el = $(self).closest('div.col-auto');
    if (el.find('div.dropdown').length == 0) {

        var html = "";
        html += '<div class="dropdown"';
        html += 'id="' + drd_id + '"';
        html += 'role="button" data-toggle="dropdown"';
        html += 'aria-haspopup="true" aria-expanded="false">';
        html += '<div class="dropdown-menu cst-dropdown-menu" aria-labelledby="' + drd_id + '">';

        if (drd_type == 0 || drd_type == 1 || drd_type == 2) {

            // breadcrum drd
            if (drd_type == 2) {
                html += '<button class="dropdown-item" uniqid="' + uniqid + '" onclick="fnc_add_new_folder(this)"><i class="fas fa-folder-plus"></i>Thư mục mới</button>';
                html += '<div class="dropdown-divider"></div>';
            }

            html += '<button class="dropdown-item" uniqid="' + uniqid + '" onclick="fnc_move_to(this)"><i class="fas fa-file-export"></i>Di chuyển tới</button>';
            html += '<button class="dropdown-item" uniqid="' + uniqid + '" onclick="fnc_change_name(this)"><i class="fas fa-pencil-alt"></i>Đổi tên</button>';
            html += '<button class="dropdown-item" uniqid="' + uniqid + '" onclick="fnc_change_color(this, event)"><i class="fas fa-palette"></i>Thay đổi màu</button>';
            html += '<div class="dropdown-divider"></div>';
            html += '<div class="dropdown-item collapse multi-collapse" id="change-color-' + uniqid + '">';
            html += '<div class="dropdown-divider"></div>';
            html += '<div class="card card-body z-pdr pdl-5 pdt-5 pdb-5" style="border: none;"></div>';
            html += '<div class="dropdown-divider"></div>';
            html += '</div>';
            html += '<button class="dropdown-item" uniqid="' + uniqid + '" onclick="fnc_detail(this)"><i class="fas fa-info-circle"></i>Chi tiết</button>';
            // file drd
            if (drd_type == 1) {
                html += '<button class="dropdown-item" uniqid="' + uniqid + '" onclick="fnc_copy(this)"><i class="fas fa-copy"></i>Tạo bản sao</button>';
            }
            html += '<button class="dropdown-item" uniqid="' + uniqid + '" onclick="fnc_download(this)"><i class="fas fa-download"></i>Tải xuống</button>';
            html += '<div class="dropdown-divider"></div>';
            html += '<button class="dropdown-item" uniqid="' + uniqid + '" onclick="fnc_delete(this)"><i class="fas fa-trash-alt"></i>Xóa</button>';
        } else if (drd_type == 3 || drd_type == 4) {
            html += '<button class="dropdown-item" uniqid="' + uniqid + '" onclick="fnc_add_new_folder(this)"><i class="fas fa-folder-plus"></i>Thư mục mới</button>';
            html += '<div class="dropdown-divider"></div>';
            html += '<button class="dropdown-item" uniqid="' + uniqid + '" onclick="fnc_upload(this)"><i class="fas fa-upload"></i>Tải lên</button>';
        }
        html += '</div>';
        html += '</div>';
        $(el).append(html);
    } else {
        if (drd_type == 4) {
            $("#" + drd_id).find(".dropdown-item").attr('uniqid', uniqid);
        }
    }

}

function fnc_init_upload_modal() {
    var modal_html = "";
    modal_html += '<div class="modal fade" id="upload-modal" data-backdrop="static" data-keyboard="false" tabIndex="-1" role="dialog" aria-hidden="true">';
    modal_html += '<div class="modal-dialog" role="document" style="max-width: unset; padding: 20px; margin: 0px; width: 100%; height: 100%">';
    modal_html += '<div class="modal-content" style="width: 100%; height: 100%; padding: 10px">';
    modal_html += '<div class="modal-header" style="padding: 5px">';
    modal_html += '<h5 class="modal-title">Tải lên</h5>';
    modal_html += '<button type="button" class="close" data-dismiss="modal" aria-label="Close">';
    modal_html += '<span aria-hidden="true">&times;</span>';
    modal_html += '</button>';
    modal_html += '</div>';
    modal_html += '<div class="file-loading">';
    modal_html += '<input id="upload-files" name="upload-files[]" type="file" multiple webkitdirectory>';
    modal_html += '</div>';
    modal_html += '<div id="errorBlock" class="help-block"></div>';
    modal_html += '</div>';
    modal_html += '</div>';
    modal_html += '</div>';
    $("body").append(modal_html);
    $('#upload-modal').on('hide.bs.modal', function (e) {
        var upload_container = $('#upload-files').fileinput('getContainer');
        if (upload_container.hasClass('is-locked'))
            return false;
        fnc_reload_drive();
    });
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
        maxFileCount: 50
    });
}

function md5_hash_generator(str) {
    if (str == "" || str == null) {
        return '';
    }
    return CryptoJS.MD5(str).toString().toUpperCase();
}

function fnc_upload(self) {
    var upload_modal = $("body").find('#upload-modal');
    if (upload_modal.length == 0) {
        fnc_init_upload_modal();
        upload_modal = $("body").find('#upload-modal');
    }
    var uniqid = $(self).attr('uniqid');
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

function fnc_reload_drive() {
    var uniqid = window.location.hash.slice(1);
    fnc_get_drive(uniqid);
}

function fnc_add_new_folder(self) {
    var uniqid = $(self).attr('uniqid');
    var modal_id = 'add-new-folder-modal';
    var add_new_folder_modal = $("body").find('#' + modal_id);
    if (add_new_folder_modal.length == 0) {
        fnc_init_add_new_folder_modal(modal_id);
        add_new_folder_modal = $("body").find('#' + modal_id);
    }
    add_new_folder_modal.attr('uniqid', uniqid);
    add_new_folder_modal.modal('toggle');
}

function fnc_init_add_new_folder_modal(modal_id) {
    var modal_html = "";
    modal_html += '<div class="modal fade" uniqid="" id="' + modal_id + '" tabIndex="-1" role="dialog" aria-hidden="true">';
    modal_html += '<div class="modal-dialog" role="document">';
    modal_html += '<div class="modal-content">';
    modal_html += '<div class="modal-header">';
    modal_html += '<h5 class="modal-title">Thêm thư mục</h5>';
    modal_html += '<button type="button" class="close" data-dismiss="modal" aria-label="Close">';
    modal_html += '<span aria-hidden="true">&times;</span>';
    modal_html += '</button>';
    modal_html += '</div>';
    modal_html += '<div class="modal-body">';
    modal_html += '<div class="form-group">';
    modal_html += '<label htmlFor="folder-name" class="col-form-label">Tên thư mục</label>';
    modal_html += '<input type="text" class="form-control" id="folder-name">';
    modal_html += '</div>';
    modal_html += '</div>';
    modal_html += '<div class="modal-footer">';
    modal_html += '<button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>';
    modal_html += '<button type="button" class="btn btn-primary" onclick="fnc_execute_add_new_folder(\'' + modal_id + '\')">Tạo</button>';
    modal_html += '</div>';
    modal_html += '</div>';
    modal_html += '</div>';
    modal_html += '</div>';
    $("body").append(modal_html);
}

function fnc_execute_add_new_folder(modal_id) {
    var folder_name = $("#" + modal_id).find("#folder-name").val();
    if (folder_name.replace(/ /g, "") == '') {
        swal.fire({
            type: 'error',
            title: 'Xin vui lòng nhập tên thư mục.'
        });
    } else {
        var uniqid = $("#" + modal_id).attr('uniqid');
        ubizapis('v1', '/drive/' + uniqid + '/add-new-folder', 'post', {'folder-name': folder_name}, null, fnc_add_new_folder_callback);
    }
}

function fnc_add_new_folder_callback(res) {
    if (res.data.success == true) {
        $('#add-new-folder-modal').modal('hide');
        swal.fire({
            type: 'success',
            title: res.data.message,
            onClose: () => {
                fnc_reload_drive();
            }
        });
    } else {
        swal.fire({
            type: 'error',
            title: res.data.message
        });
    }
}

function fnc_change_name(self) {
    var uniqid = $(self).attr('uniqid');
    ubizapis('v1', '/drive/' + uniqid + '/detail', 'get', null, null, function (res) {

        if (res.data.success == true) {
            var data = res.data.data;
            var modal_id = 'change-name-modal';
            var add_change_name_modal = $("body").find('#' + modal_id);
            if (add_change_name_modal.length == 0) {
                fnc_init_change_name_modal(modal_id);
                add_change_name_modal = $("body").find('#' + modal_id);
            }
            add_change_name_modal.attr('uniqid', uniqid);
            add_change_name_modal.find('#new-name').val(escape(res.data.data.dri_name));
            add_change_name_modal.modal('toggle');

        } else {
            swal.fire({
                type: 'error',
                title: res.data.message
            });
        }

    });

}

function fnc_init_change_name_modal(modal_id) {
    var modal_html = "";
    modal_html += '<div class="modal fade" uniqid="" id="' + modal_id + '" tabIndex="-1" role="dialog" aria-hidden="true">';
    modal_html += '<div class="modal-dialog" role="document">';
    modal_html += '<div class="modal-content">';
    modal_html += '<div class="modal-header">';
    modal_html += '<h5 class="modal-title">Đổi tên</h5>';
    modal_html += '<button type="button" class="close" data-dismiss="modal" aria-label="Close">';
    modal_html += '<span aria-hidden="true">&times;</span>';
    modal_html += '</button>';
    modal_html += '</div>';
    modal_html += '<div class="modal-body">';
    modal_html += '<div class="form-group">';
    modal_html += '<label htmlFor="new-name" class="col-form-label">Tên mới</label>';
    modal_html += '<input type="text" class="form-control" id="new-name">';
    modal_html += '</div>';
    modal_html += '</div>';
    modal_html += '<div class="modal-footer">';
    modal_html += '<button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>';
    modal_html += '<button type="button" class="btn btn-primary" onclick="fnc_execute_change_name(\'' + modal_id + '\')">Thay đổi</button>';
    modal_html += '</div>';
    modal_html += '</div>';
    modal_html += '</div>';
    modal_html += '</div>';
    $("body").append(modal_html);
}

function fnc_execute_change_name(modal_id) {
    var new_name = $("#" + modal_id).find("#new-name").val();
    if (new_name.replace(/ /g, "") == '') {
        swal.fire({
            type: 'error',
            title: 'Xin vui lòng nhập tên.'
        });
    }
    var uniqid = $("#" + modal_id).attr('uniqid');
    ubizapis('v1', '/drive/' + uniqid + '/change-name', 'post', {'new-name': new_name}, null, fnc_execute_change_name_callback);
}

function fnc_execute_change_name_callback(res) {
    if (res.data.success == true) {
        $('#change-name-modal').modal('hide');
        swal.fire({
            type: 'success',
            title: res.data.message,
            onClose: () => {
                fnc_reload_drive();
            }
        });
    } else {
        swal.fire({
            type: 'error',
            title: res.data.message
        });
    }
}

function fnc_delete(self) {
    swal({
        title: i18next.t('Do you want to delete the data.?'),
        type: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: i18next.t('No'),
        confirmButtonText: i18next.t('Yes'),
        reverseButtons: true
    }).then((result) => {
        if (result.value) {
            var uniqid = $(self).attr('uniqid');
            ubizapis('v1', 'drive/' + uniqid + '/delete', 'delete', null, null, fnc_delete_callback);
        }
    });
}

function fnc_delete_callback(res) {
    if (res.data.success == true) {
        swal.fire({
            type: 'success',
            title: res.data.message,
            onClose: () => {
                fnc_get_drive(res.data.uniqid);
            }
        });
    } else {
        console.log(res);
        swal.fire({
            type: 'error',
            title: res.data.message
        });
    }
}

function fnc_change_color(self, event) {
    event.preventDefault();
    event.stopPropagation();

    var drd_colors = [];
    drd_colors.push('#ac725e');
    drd_colors.push('#d06b64');
    drd_colors.push('#f83a22');
    drd_colors.push('#fa573c');
    drd_colors.push('#ff7537');
    drd_colors.push('#ffad46');
    drd_colors.push('#42d692');
    drd_colors.push('#16a765');
    drd_colors.push('#7bd148');
    drd_colors.push('#b3dc6c');
    drd_colors.push('#fbe983');
    drd_colors.push('#fad165');
    drd_colors.push('#92e1c0');
    drd_colors.push('#9fe1e7');
    drd_colors.push('#9fc6e7');
    drd_colors.push('#4986e7');
    drd_colors.push('#9a9cff');
    drd_colors.push('#b99aff');
    drd_colors.push('#8f8f8f');
    drd_colors.push('#cabdbf');
    drd_colors.push('#cca6ac');
    drd_colors.push('#f691b2');
    drd_colors.push('#cd74e6');
    drd_colors.push('#a47ae2');

    var uniqid = $(self).attr('uniqid');
    if ($("#change-color-" + uniqid).find('card-body').find('div.drd-color').length == 0) {
        var dri_color = $("#dri-color-" + uniqid).val();
        var html = "";
        html += '<div class="drd-color row justify-content-start z-mgr z-mgl">';
        var fa_icon = "";
        $.each(drd_colors, function (idx, drd_color) {
            fa_icon = "fa-square";
            if (dri_color == drd_color) {
                fa_icon = "fa-check-square selected";
            }
            html += '<div class="col-auto z-mgr z-mgl z-mgb pdl-5 pdr-5 pdb-5"><i uniqid="' + uniqid + '" color="' + drd_color + '" onclick="fnc_color_selected(this, event)" class="fas ' + fa_icon + ' z-mgr z-mgl font-size-24" style="cursor: pointer; color: ' + drd_color + '"></i></div>';
        });
        html += '</div>';

        $("#change-color-" + uniqid).find('.card-body').empty();
        $("#change-color-" + uniqid).find('.card-body').html(html);
    }

    setTimeout(function () {
        $("#change-color-" + uniqid).collapse('toggle');
    }, 5);
}

function fnc_color_selected(self, event) {

    event.preventDefault();
    event.stopPropagation();
    if ($(self).hasClass('selected')) {
        return false;
    }

    swal({
        title: i18next.t('Do you want to change the color.?'),
        type: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: i18next.t('No'),
        confirmButtonText: i18next.t('Yes'),
        reverseButtons: true
    }).then((result) => {
        if (result.value) {
            var uniqid = $(self).attr('uniqid');
            var color = $(self).attr('color');
            ubizapis('v1', 'drive/' + uniqid + '/change-color', 'post', {'color': color}, null, function (res) {

                if (res.data.success == true) {
                    swal.fire({
                        type: 'success',
                        title: res.data.message,
                        onClose: () => {
                            var drd_selected_color = $("#change-color-" + uniqid).find('.card-body').find('i.selected');
                            drd_selected_color.removeClass('fa-check-square');
                            drd_selected_color.removeClass('selected');
                            drd_selected_color.addClass('fa-square');

                            $(self).removeClass('fa-square');
                            $(self).addClass('fa-check-square');
                            $(self).addClass('selected');
                            $("#folder-container").find('div[uniqid=' + uniqid + ']').find('i.fa-icon').css('color', color);
                            $("#folder-container").find('div[uniqid=' + uniqid + ']').find('input[id=dri-color-' + uniqid + ']').val(color);
                            $("#file-container").find('div[uniqid=' + uniqid + ']').find('i.fa-icon').css('color', color);
                            $("#file-container").find('div[uniqid=' + uniqid + ']').find('input[id=dri-color-' + uniqid + ']').val(color);
                        }
                    });
                } else {
                    console.log(res);
                    swal.fire({
                        type: 'error',
                        title: res.data.message
                    });
                }

            });
        }
    });

}

function fnc_copy(self) {
    swal({
        title: i18next.t('Do you want to make a copy.?'),
        type: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: i18next.t('No'),
        confirmButtonText: i18next.t('Yes'),
        reverseButtons: true
    }).then((result) => {
        if (result.value) {
            var uniqid = $(self).attr('uniqid');
            var uniqid = $(self).attr('uniqid');
            var color = $(self).attr('color');
            ubizapis('v1', 'drive/' + uniqid + '/do-copy', 'post', null, null, function (res) {

                if (res.data.success == true) {
                    swal.fire({
                        type: 'success',
                        title: res.data.message,
                        onClose: () => {
                            fnc_reload_drive();
                        }
                    });
                } else {
                    console.log(res);
                    swal.fire({
                        type: 'error',
                        title: res.data.message
                    });
                }

            });
        }
    });
}

function fnc_move_to(self) {

    var source_uniqid = $(self).attr('uniqid');
    ubizapis('v1', '/drive/' + source_uniqid + '/sibling', 'get', null, null, function (res) {

        if (res.data.success == true) {
            fnc_move_to_render_modal(res, source_uniqid);
        } else {
            swal.fire({
                type: 'error',
                title: res.data.message
            });
        }
    });
}

function fnc_move_to_render_modal(res, source_uniqid) {

    var detail_data = res.data.detail;
    var parent_data = res.data.parent;
    var sibling_data = res.data.sibling;

    var modal_id = 'move-to-modal';
    var move_to_modal = $("body").find('#' + modal_id);

    if (move_to_modal.length == 0) {
        fnc_init_move_to_modal(modal_id);
        move_to_modal = $("body").find('#' + modal_id);
    }

    if (source_uniqid) {
        move_to_modal.attr('uniqid', source_uniqid);
        move_to_modal.attr('funiqid', detail_data.dri_funiq);
    }
    source_uniqid = move_to_modal.attr('uniqid');
    source_funiqid = move_to_modal.attr('funiqid');

    move_to_modal.find('.modal-title').text(parent_data.dri_name);
    if (parent_data.dri_funiq == '' || parent_data.dri_funiq == null) {
        move_to_modal.find('.modal-header').find('.i-btn').addClass('hidden-content');
    } else {
        move_to_modal.find('.modal-header').find('.i-btn').removeClass('hidden-content');
    }
    move_to_modal.find('.modal-header').find('.btn-go-back').attr('uniqid', parent_data.dri_funiq);
    move_to_modal.find('.modal-footer').find('.btn-move-to').attr('uniqid', parent_data.dri_uniq);

    var html = "";
    if (sibling_data.length > 0) {
        html += '<ul class="list-group list-group-flush move-to">';
        $.each(sibling_data, function (idx, item) {

            var disabled = '';
            if (item.dri_type == '1' || source_uniqid == item.dri_uniq) {
                disabled = 'disabled';
            }

            html += '<li uniqid="' + item.dri_uniq + '" funiqid="' + item.dri_funiq + '" onclick="fnc_move_item_select(this, event)" ondblclick="fnc_move_to_go(this, event)" class="list-group-item list-group-item-action ' + disabled + ' d-flex justify-content-between align-items-center z-pdt z-pdb pdl-10 pdr-10">';
            html += '<div class="d-flex d-first">';
            if (item.dri_type == '0') {
                html += '<i class="fa-icon fas fa-folder font-size-20" style="color: ' + item.dri_color + '"></i>';
            } else {
                html += fnc_get_filetype_font_icon(item.dri_ext, item.dri_color, 'font-size-20');
            }
            html += '<span>' + item.dri_name + '</span>';
            html += '</div>';
            if (item.dri_type == '0' && source_uniqid != item.dri_uniq) {
                html += '<span class="badge">';
                html += '<button uniqid="' + item.dri_uniq + '" onclick="fnc_move_to_go(this, event)" type="button" class="m-btn z-pd" aria-label="Next">';
                html += '<i class="fas fa-chevron-circle-right text-primary font-size-20"></i>';
                html += '</button>';
                html += '</span>';
            }
            html += '</li>';
        });
        html += '</ul>';
    }

    move_to_modal.find('.modal-body').empty();
    move_to_modal.find('.modal-body').html(html);
    if (move_to_modal.hasClass('show') == false) {
        setTimeout(function () {
            move_to_modal.modal('toggle');
        }, 5);
    }

}

function fnc_init_move_to_modal(modal_id) {
    var modal_html = "";
    modal_html += '<div class="modal fade" uniqid="" funiqid="" id="' + modal_id + '" tabIndex="-1" role="dialog" aria-hidden="true">';
    modal_html += '<div class="modal-dialog modal-dialog-scrollable" role="document">';
    modal_html += '<div class="modal-content">';
    modal_html += '<div class="modal-header">';
    modal_html += '<button type="button" uniqid="" onclick="fnc_move_to_back(this, event)" class="i-btn btn-go-back" aria-label="Back">';
    modal_html += '<i class="fas fa-arrow-circle-left text-primary"></i>';
    modal_html += '</button>';
    modal_html += '<h5 class="modal-title"></h5>';
    modal_html += '<button type="button" class="close" data-dismiss="modal" aria-label="Close">';
    modal_html += '<span aria-hidden="true">&times;</span>';
    modal_html += '</button>';
    modal_html += '</div>';
    modal_html += '<div class="modal-body" style="max-height: 600px"></div>';
    modal_html += '<div class="modal-footer">';
    modal_html += '<button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>';
    modal_html += '<button type="button" uniqid="" class="btn btn-primary btn-move-to disabled" onclick="fnc_execute_move_to(\'' + modal_id + '\', event)">Di chuyển</button>';
    modal_html += '</div>';
    modal_html += '</div>';
    modal_html += '</div>';
    modal_html += '</div>';
    $("body").append(modal_html);
}

function fnc_execute_move_to(modal_id, event) {

    event.preventDefault();
    event.stopPropagation();

    swal({
        title: i18next.t('Are you sure want to move data.?'),
        type: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: i18next.t('No'),
        confirmButtonText: i18next.t('Yes'),
        reverseButtons: true
    }).then((result) => {
        if (result.value) {

            var uniqid = $("#" + modal_id).attr('uniqid');
            var target_uniqid = $("#" + modal_id).find('.modal-footer').find('.btn-move-to').attr('uniqid');
            if (uniqid == '' || target_uniqid == '')
                return fasle;

            ubizapis('v1', 'drive/' + uniqid + '/move-to', 'post', {'target-uniqid': target_uniqid}, null, fnc_execute_move_to_callback);
        }
    });
}

function fnc_execute_move_to_callback(res) {
    if (res.data.success == true) {
        swal.fire({
            type: 'success',
            title: res.data.message,
            onClose: () => {
                fnc_reload_drive();
            }
        });
    } else {
        console.log(res);
        swal.fire({
            type: 'error',
            title: res.data.message
        });
    }
}

function fnc_move_item_select(self, event) {

    event.preventDefault();
    event.stopPropagation();

    var modal = $("#move-to-modal");
    var self_uniqid = $(self).attr('uniqid');
    var self_funiqid = $(self).attr('funiqid');
    var parent_funiqid = modal.attr('funiqid');

    if ($(self).hasClass('active')) {
        $(self).removeClass('active');
        modal.find('.modal-footer').find('.btn-move-to').text('Di chuyển');
        modal.find('.modal-footer').find('.btn-move-to').attr('uniqid', '');
        if (self_funiqid == parent_funiqid) {
            modal.find('.modal-footer').find('.btn-move-to').addClass('disabled');
        } else {
            modal.find('.modal-footer').find('.btn-move-to').removeClass('disabled');
        }
    } else {
        modal.find('.modal-footer').find('.btn-move-to').removeClass('disabled');
        modal.find('.modal-footer').find('.btn-move-to').text('Di chuyển tới đây');
        modal.find('.modal-footer').find('.btn-move-to').attr('uniqid', self_uniqid);
        $(self).addClass('active');
    }
}

function fnc_move_to_go(self, event) {

    event.preventDefault();
    event.stopPropagation();

    var move_to_modal = $("#move-to-modal");
    move_to_modal.find('.list-group').find('li.active').removeClass('active');
    move_to_modal.find('.modal-footer').find('.btn-move-to').text('Di chuyển');
    $(self).addClass('active');

    var uniqid = $(self).attr('uniqid');
    ubizapis('v1', '/drive/' + uniqid + '/children', 'get', null, null, function (res) {

        if (res.data.success == true) {
            fnc_move_to_render_modal(res);
            if (res.data.parent.dri_uniq == move_to_modal.attr('funiqid')) {
                move_to_modal.find('.modal-footer').find('.btn-move-to').addClass('disabled');
            } else {
                move_to_modal.find('.modal-footer').find('.btn-move-to').removeClass('disabled');
            }
        } else {
            swal.fire({
                type: 'error',
                title: res.data.message
            });
        }
    });
}

function fnc_move_to_back(self, event) {

    event.preventDefault();
    event.stopPropagation();

    var self_uniqid = $(self).attr('uniqid');
    if (self_uniqid == "")
        return false;

    var move_to_modal = $("#move-to-modal");
    move_to_modal.find('.modal-footer').find('.btn-move-to').html('Di chuyển');

    ubizapis('v1', '/drive/' + self_uniqid + '/children', 'get', null, null, function (res) {

        if (res.data.success == true) {
            fnc_move_to_render_modal(res);
            if (res.data.parent.dri_uniq == move_to_modal.attr('funiqid')) {
                move_to_modal.find('.modal-footer').find('.btn-move-to').addClass('disabled');
            } else {
                move_to_modal.find('.modal-footer').find('.btn-move-to').removeClass('disabled');
            }
        } else {
            swal.fire({
                type: 'error',
                title: res.data.message
            });
        }
    });
}

function fnc_init_drive() {
    var uniqid = window.location.hash.slice(1);
    if (uniqid == "") {
        uniqid = md5_hash_generator('root');
    }
    history.replaceState(null, null, window.location.origin + "/drive#" + uniqid);
}

jQuery(document).ready(function () {
    fnc_set_scrollbars("nicescroll-oput");
    fnc_init_drive();
    fnc_reload_drive();
});