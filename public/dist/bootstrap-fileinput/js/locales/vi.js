/*!
 * FileInput Vietnamese Translations
 *
 * This file must be loaded after 'fileinput.js'. Patterns in braces '{}', or
 * any HTML markup tags in the messages must not be converted or translated.
 *
 * @see http://github.com/kartik-v/bootstrap-fileinput
 *
 * NOTE: this file must be saved in UTF-8 encoding.
 */
 
(function ($) {
    "use strict";

    $.fn.fileinputLocales['vi'] = {
        fileSingle: 'tập tin',
        filePlural: 'các tập tin',
        browseLabel: 'Duyệt &hellip;',
        removeLabel: 'Gỡ bỏ',
        removeTitle: 'Bỏ tập tin đã chọn',
        cancelLabel: 'Hủy',
        cancelTitle: 'Hủy tải lên',
        pauseLabel: 'Tạm dừng',
        pauseTitle: 'Tạm dừng tải lên',
        uploadLabel: 'Tải lên',
        uploadTitle: 'Tải lên tập tin đã chọn',
        msgNo: 'Không',
        msgNoFilesSelected: 'Không tập tin nào được chọn',
        msgPaused: 'Dừng',
        msgCancelled: 'Đã hủy',
        msgPlaceholder: 'Chọn {tập tin}...',
        msgZoomModalHeading: 'Chi tiết xem trước',
        msgFileRequired: 'Bạn phải chọn tối thiểu một tập tin để tải lên.',
        msgSizeTooSmall: 'Tập tin "{name}" có kích thước (<b>{size} KB</b>) là quá nhỏ, phải lớn hơn <b>{minSize} KB</b>.',
        msgSizeTooLarge: 'Tập tin "{name}" (<b>{size} KB</b>) vượt quá kích thước giới hạn cho phép <b>{maxSize} KB</b>.',
        msgFilesTooLess: 'Bạn phải chọn ít nhất <b>{n}</b> {files} để tải lên.',
        msgFilesTooMany: 'Số lượng tập tin tải lên <b>({n})</b> vượt quá giới hạn cho phép là <b>{m}</b>.',
        msgFileNotFound: 'Không tìm thấy tập tin "{name}"!',
        msgFileSecured: 'Các hạn chế về bảo mật không cho phép đọc tập tin "{name}".',
        msgFileNotReadable: 'Không đọc được tập tin "{name}".',
        msgFilePreviewAborted: 'Đã dừng xem trước tập tin "{name}".',
        msgFilePreviewError: 'Đã xảy ra lỗi khi đọc tập tin "{name}".',
        msgInvalidFileName: 'Ký tự không hợp lệ hoặc không được hỗ trợ trong tập tệp "{name}".',
        msgInvalidFileType: 'Tập tin "{name}" không hợp lệ. Chỉ hỗ trợ loại tập tin "{types}".',
        msgInvalidFileExtension: 'Phần mở rộng của tập tin "{name}" không hợp lệ. Chỉ hỗ trợ phần mở rộng "{extensions}".',
        msgFileTypes: {
            'image': 'image',
            'html': 'HTML',
            'text': 'text',
            'video': 'video',
            'audio': 'audio',
            'flash': 'flash',
            'pdf': 'PDF',
            'object': 'object'
        },
        msgUploadAborted: 'Đã dừng tải lên',
        msgUploadThreshold: 'Đang xử lý...',
        msgUploadBegin: 'Đang khởi tạo...',
        msgUploadEnd: 'Hoàn thành',
        msgUploadResume: 'Tiếp tục tải lên...',
        msgUploadEmpty: 'Không có dữ liệu hợp lệ để tải lên.',
        msgUploadError: 'Lỗi tải lên',
        msgDeleteError: 'Lỗi xóa',
        msgProgressError: 'Lỗi',
        msgValidationError: 'Lỗi xác nhận',
        msgLoading: 'Đang nạp {index} tập tin trong số {files} &hellip;',
        msgProgress: 'Đang nạp {index} tập tin trong số {files} - {name} - {percent}% hoàn thành.',
        msgSelected: '{n} {files} được chọn',
        msgFoldersNotAllowed: 'Chỉ kéo thả tập tin! Đã bỏ qua {n} thư mục.',
        msgImageWidthSmall: 'Chiều rộng của hình ảnh "{name}" phải tối thiểu là {size} px.',
        msgImageHeightSmall: 'Chiều cao của hình ảnh "{name}" phải tối thiểu là {size} px.',
        msgImageWidthLarge: 'Chiều rộng của hình ảnh "{name}" không được quá {size} px.',
        msgImageHeightLarge: 'Chiều cao của hình ảnh "{name}" không được quá {size} px.',
        msgImageResizeError: 'Không lấy được kích thước của hình ảnh để resize.',
        msgImageResizeException: 'Resize hình ảnh bị lỗi.<pre>{errors}</pre>',
        msgAjaxError: 'Đã xảy ra lỗi với thao tác {operation}. Vui lòng thử lại sau!',
        msgAjaxProgressError: '{operation} thất bại',
        msgDuplicateFile: 'Tập tin "{name}" có kích thước "{size} KB" đã được chọn. Bỏ qua tập tin trùng lặp.',
        msgResumableUploadRetriesExceeded:  'Tải lên bị hủy bỏ ngoài <b> {max} </ b> thử lại cho tệp <b> {file} </ b>! Chi tiết lỗi: <pre> {error} </ pre>',
        msgPendingTime: '{time} còn lại',
        msgCalculatingTime: 'đang tính toán thời gian còn lại',
        ajaxOperations: {
            deleteThumb: 'file delete',
            uploadThumb: 'file upload',
            uploadBatch: 'batch file upload',
            uploadExtra: 'form data upload'
        },
        dropZoneTitle: 'Kéo thả tập tin vào đây &hellip;',
        dropZoneClickTitle: '<br>(hoặc click để chọn {files})',
        fileActionSettings: {
            removeTitle: 'Gỡ bỏ',
            uploadTitle: 'Tải lên tập tin',
            uploadRetryTitle: 'Thử lại tải lên',
            downloadTitle: 'Tải xuống tập tin',
            zoomTitle: 'Phóng lớn',
            dragTitle: 'Di chuyển / Sắp xếp lại',
            indicatorNewTitle: 'Chưa được upload',
            indicatorSuccessTitle: 'Đã tải lên',
            indicatorErrorTitle: 'Tải lên bị lỗi',
            indicatorPausedTitle: 'Đã dừng tải lên',
            indicatorLoadingTitle:  'Đang tải lên ...'
        },
        previewZoomButtonTitles: {
            prev: 'Xem tập tin phía trước',
            next: 'Xem tập tin tiếp theo',
            toggleheader: 'Ẩn/hiện tiêu đề',
            fullscreen: 'Bật/tắt toàn màn hình',
            borderless: 'Bật/tắt chế độ không viền',
            close: 'Đóng'
        }
    };
})(window.jQuery);
