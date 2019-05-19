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
    <div class="col-md-7 col-lg-7">
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
    <div class="col-md-5 col-lg-5">
        <span class="text-primary">Người phụ trách</span>
        <hr class="z-mgt">
        <input type="text" style="width: 200px" class="form-control margin-bottom-20" id="event-title" placeholder="Thêm người phụ trách">
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