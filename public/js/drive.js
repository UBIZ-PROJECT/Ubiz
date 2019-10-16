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

jQuery(document).ready(function () {
    $('#dri-breadcrumb-drd').on('show.bs.dropdown', function () {
        var breadcrumb_func = generate_breadcrumb_func();
        $('#dri-breadcrumb-drd').find('.dropdown-menu').empty();
        $('#dri-breadcrumb-drd').find('.dropdown-menu').html(breadcrumb_func);
    })
    fnc_set_scrollbars("nicescroll-oput");
});