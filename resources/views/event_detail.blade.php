<div class="row">
    <div class="col-md-6 col-lg-6">
        <input type="text" style="width: 500px" class="form-control" id="event-title" placeholder="Thêm tiêu đề">
    </div>
    <div class="col-md-6 col-lg-6 text-right">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
</div>
<hr>
<div class="row margin-bottom-15">
    <div class="col-12">
        <input type="text" readonly style="width: 120px" class="form-control d-inline-flex text-center start-date" id="event-start-date">
        <select readonly class="form-control d-inline-flex justify-content-center w-auto" id="event-start-time">
            <option>12:00am</option>
            <option>12:30am</option>
            <option>1:00am</option>
            <option>1:30am</option>
            <option>2:00am</option>
            <option>2:30am</option>
            <option>3:00am</option>
            <option>3:30am</option>
            <option>4:00am</option>
            <option>4:30am</option>
            <option>5:00am</option>
            <option>5:30am</option>
            <option>6:00am</option>
            <option>6:30am</option>
            <option>7:00am</option>
            <option>7:30am</option>
            <option>8:00am</option>
            <option>8:30am</option>
            <option>9:00am</option>
            <option>9:30am</option>
            <option>10:00am</option>
            <option>10:30am</option>
            <option>11:00am</option>
            <option>11:30am</option>
            <option>12:00pm</option>
            <option>12:30pm</option>
            <option>1:00pm</option>
            <option>1:30pm</option>
            <option>2:00pm</option>
            <option>2:30pm</option>
            <option>3:00pm</option>
            <option>3:30pm</option>
            <option>4:00pm</option>
            <option>4:30pm</option>
            <option>5:00pm</option>
            <option>5:30pm</option>
            <option>6:00pm</option>
            <option>6:30pm</option>
            <option>7:00pm</option>
            <option>7:30pm</option>
            <option>8:00pm</option>
            <option>8:30pm</option>
            <option>9:00pm</option>
            <option>9:30pm</option>
            <option>10:00pm</option>
            <option>10:30pm</option>
            <option>11:00pm</option>
            <option>11:30pm</option>
        </select>
        <span class="d-inline-flex">&nbsp;đến&nbsp;</span>
        <select readonly class="form-control d-inline-flex justify-content-center w-auto" id="event-end-time">
            <option>12:00am</option>
            <option>12:30am</option>
            <option>1:00am</option>
            <option>1:30am</option>
            <option>2:00am</option>
            <option>2:30am</option>
            <option>3:00am</option>
            <option>3:30am</option>
            <option>4:00am</option>
            <option>4:30am</option>
            <option>5:00am</option>
            <option>5:30am</option>
            <option>6:00am</option>
            <option>6:30am</option>
            <option>7:00am</option>
            <option>7:30am</option>
            <option>8:00am</option>
            <option>8:30am</option>
            <option>9:00am</option>
            <option>9:30am</option>
            <option>10:00am</option>
            <option>10:30am</option>
            <option>11:00am</option>
            <option>11:30am</option>
            <option>12:00pm</option>
            <option>12:30pm</option>
            <option>1:00pm</option>
            <option>1:30pm</option>
            <option>2:00pm</option>
            <option>2:30pm</option>
            <option>3:00pm</option>
            <option>3:30pm</option>
            <option>4:00pm</option>
            <option>4:30pm</option>
            <option>5:00pm</option>
            <option>5:30pm</option>
            <option>6:00pm</option>
            <option>6:30pm</option>
            <option>7:00pm</option>
            <option>7:30pm</option>
            <option>8:00pm</option>
            <option>8:30pm</option>
            <option>9:00pm</option>
            <option>9:30pm</option>
            <option>10:00pm</option>
            <option>10:30pm</option>
            <option>11:00pm</option>
            <option>11:30pm</option>
        </select>
        <input type="text" readonly style="width: 120px" class="form-control d-inline-flex text-center end-date" id="event-end-date">
    </div>
</div>
<div class="row margin-bottom-15">
    <div class="col-12">
        <table>
            <tbody>
            <tr style="line-height: 1px">
                <td>
                    <input type="checkbox" style="width: 15px; height: 15px">
                </td>
                <td>
                    <span class="d-inline-flex">Cả ngày</span>
                    <select class="form-control d-inline-flex justify-content-center w-auto">
                        <option>A</option>
                        <option>B</option>
                    </select>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
<div class="row margin-bottom-15">
    <div class="col-md-8 col-lg-8">
        <span class="text-primary">Chi tiết</span>
        <hr class="z-mgt">
        <table>
            <tbody>
            <tr>
                <td style="height: 45px">
                    <i class="far fa-bell text-primary mgr-10"></i>
                </td>
                <td>
                    <select class="form-control d-inline-flex justify-content-center w-auto">
                        <option>Email</option>
                    </select>
                    <input type="number" style="width: 70px" class="form-control d-inline-flex" value="30">
                    <select class="form-control d-inline-flex justify-content-center w-auto">
                        <option>Minutes</option>
                        <option>Hours</option>
                        <option>Days</option>
                        <option>Weeks</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td style="height: 45px">
                    <i class="fas fa-tags text-primary mgr-10"></i>
                </td>
                <td>
                    <span class="d-inline-flex">ngsang@tkp.com</span>
                    <select class="form-control d-inline-flex justify-content-center w-auto">
                        <option><i class="fas fa-circle tomato"></i></option>
                    </select>
                </td>
            </tr>
            <tr>
                <td style="vertical-align: top;">
                    <i class="fas fa-align-left text-primary mgr-10"></i>
                </td>
                <td>
                    <textarea class="form-control" name="txt_desc"></textarea>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
    <div class="col-md-4 col-lg-4">
        <span class="text-primary">Người phụ trách</span>
        <hr class="z-mgt">
        <div class="dropdown event-pic margin-bottom-30">
            <input type="text"
                   data-toggle="dropdown"
                   aria-haspopup="true"
                   aria-expanded="false"
                   style="width: 300px" class="form-control dropdown-toggle"
                   id="event-pic" placeholder="Thêm người phụ trách">
            <div class="dropdown-menu z-pdt z-pdb margin-bottom-15" aria-labelledby="event-pic"></div>
            <ul class="list-group assigned-list list-group-flush" style="width: 300px">
                <li pic="1" class="list-group-item z-pdl z-pdr" style="display: flex; align-items: flex-start;">
                    <div style="width: 30px; height: 30px" class="mr-3">
                        <img src="data:image/png;base64,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" class="img-fluid img-thumbnail" alt="">
                    </div>
                    <div class="media-body" style="height: 30px; line-height: 5px">
                        <h6 class="mt-0 mb-1">Vu van thuan</h6>
                        <small>Nhan vien kinh doanh</small>
                    </div>
                    <div style="height: 30px; line-height: 30px">
                        <i class="fas fa-times pdr-5"></i>
                    </div>
                </li>
            </ul>
        </div>
        <span>Người phụ trách có thể:</span>
        <table>
            <tbody>
            <tr style="line-height: 1px">
                <td style="height: 30px">
                    <input type="checkbox" class="mgr-10" style="width: 15px; height: 15px">
                </td>
                <td>
                    <span>Sửa</span>
                </td>
            </tr>
            <tr style="line-height: 1px">
                <td style="height: 30px">
                    <input type="checkbox" class="mgr-10" style="width: 15px; height: 15px">
                </td>
                <td>
                    <span>Thêm người phụ trách</span>
                </td>
            </tr>
            <tr style="line-height: 1px">
                <td style="height: 30px">
                    <input type="checkbox" class="mgr-10" style="width: 15px; height: 15px">
                </td>
                <td>
                    <span>Thấy danh sách người phụ trách</span>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
<hr>
<div class="row">
    <div class="col-12 text-right">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
    </div>
</div>