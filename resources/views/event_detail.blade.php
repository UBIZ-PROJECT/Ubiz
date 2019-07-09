<div class="row">
    <input type="hidden" id="event-id" value="0">
    <div class="col-md-6 col-lg-6">
        <input type="text" style="width: 500px" class="form-control light-color" id="event-title" placeholder="{{ __('Add title') }}">
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
        <input type="text" readonly style="width: 140px" class="form-control light-color d-inline-flex text-center start-date" id="event-start-date">
        <select readonly class="form-control light-color d-inline-flex justify-content-center w-auto"
                id="event-start-time">
            <option value="12:00am">12:00SA</option>
            <option value="12:30am">12:30SA</option>
            <option value="12:30am">1:00SA</option>
            <option value="1:30am">1:30SA</option>
            <option value="2:00am">2:00SA</option>
            <option value="2:30am">2:30SA</option>
            <option value="3:00am">3:00SA</option>
            <option value="3:30am">3:30SA</option>
            <option value="4:00am">4:00SA</option>
            <option value="4:30am">4:30SA</option>
            <option value="5:00am">5:00SA</option>
            <option value="5:30am">5:30SA</option>
            <option value="6:00am">6:00SA</option>
            <option value="6:30am">6:30SA</option>
            <option value="7:00am">7:00SA</option>
            <option value="7:30am">7:30SA</option>
            <option value="8:00am">8:00SA</option>
            <option value="8:30am">8:30SA</option>
            <option value="9:00am">9:00SA</option>
            <option value="9:30am">9:30SA</option>
            <option value="10:00am">10:00SA</option>
            <option value="10:30am">10:30SA</option>
            <option value="11:00am">11:00SA</option>
            <option value="11:30am">11:30SA</option>
            <option value="12:00pm">12:00CH</option>
            <option value="12:30pm">12:30CH</option>
            <option value="1:00pm">1:00CH</option>
            <option value="1:30pm">1:30CH</option>
            <option value="2:00pm">2:00CH</option>
            <option value="2:30pm">2:30CH</option>
            <option value="3:00pm">3:00CH</option>
            <option value="3:30pm">3:30CH</option>
            <option value="4:00pm">4:00CH</option>
            <option value="4:30pm">4:30CH</option>
            <option value="5:00pm">5:00CH</option>
            <option value="5:30pm">5:30CH</option>
            <option value="6:00pm">6:00CH</option>
            <option value="6:30pm">6:30CH</option>
            <option value="7:00pm">7:00CH</option>
            <option value="7:30pm">7:30CH</option>
            <option value="8:00pm">8:00CH</option>
            <option value="8:30pm">8:30CH</option>
            <option value="9:00pm">9:00CH</option>
            <option value="9:30pm">9:30CH</option>
            <option value="10:00pm">10:00CH</option>
            <option value="10:30pm">10:30CH</option>
            <option value="11:00pm">11:00CH</option>
            <option value="11:30pm">11:30CH</option>
        </select>
        <span class="d-inline-flex">&nbsp;{{ __('to') }}&nbsp;</span>
        <select readonly class="form-control light-color d-inline-flex justify-content-center w-auto" id="event-end-time">
            <option value="12:00am">12:00SA</option>
            <option value="12:30am">12:30SA</option>
            <option value="12:30am">1:00SA</option>
            <option value="1:30am">1:30SA</option>
            <option value="2:00am">2:00SA</option>
            <option value="2:30am">2:30SA</option>
            <option value="3:00am">3:00SA</option>
            <option value="3:30am">3:30SA</option>
            <option value="4:00am">4:00SA</option>
            <option value="4:30am">4:30SA</option>
            <option value="5:00am">5:00SA</option>
            <option value="5:30am">5:30SA</option>
            <option value="6:00am">6:00SA</option>
            <option value="6:30am">6:30SA</option>
            <option value="7:00am">7:00SA</option>
            <option value="7:30am">7:30SA</option>
            <option value="8:00am">8:00SA</option>
            <option value="8:30am">8:30SA</option>
            <option value="9:00am">9:00SA</option>
            <option value="9:30am">9:30SA</option>
            <option value="10:00am">10:00SA</option>
            <option value="10:30am">10:30SA</option>
            <option value="11:00am">11:00SA</option>
            <option value="11:30am">11:30SA</option>
            <option value="12:00pm">12:00CH</option>
            <option value="12:30pm">12:30CH</option>
            <option value="1:00pm">1:00CH</option>
            <option value="1:30pm">1:30CH</option>
            <option value="2:00pm">2:00CH</option>
            <option value="2:30pm">2:30CH</option>
            <option value="3:00pm">3:00CH</option>
            <option value="3:30pm">3:30CH</option>
            <option value="4:00pm">4:00CH</option>
            <option value="4:30pm">4:30CH</option>
            <option value="5:00pm">5:00CH</option>
            <option value="5:30pm">5:30CH</option>
            <option value="6:00pm">6:00CH</option>
            <option value="6:30pm">6:30CH</option>
            <option value="7:00pm">7:00CH</option>
            <option value="7:30pm">7:30CH</option>
            <option value="8:00pm">8:00CH</option>
            <option value="8:30pm">8:30CH</option>
            <option value="9:00pm">9:00CH</option>
            <option value="9:30pm">9:30CH</option>
            <option value="10:00pm">10:00CH</option>
            <option value="10:30pm">10:30CH</option>
            <option value="11:00pm">11:00CH</option>
            <option value="11:30pm">11:30CH</option>
        </select>
        <input type="text" readonly style="width: 140px" class="form-control light-color d-inline-flex text-center end-date" id="event-end-date">
    </div>
</div>
<div class="row margin-bottom-15">
    <div class="col-12">
        <table>
            <tbody>
            <tr style="line-height: 1px">
                <td>
                    <input type="checkbox" onchange="event_all_day_change(this)" id="event-all-day" style="width: 15px; height: 15px">
                </td>
                <td>
                    <span class="d-inline-flex">{{ __('All day') }}</span>
                    <select readonly class="form-control light-color d-inline-flex justify-content-center w-auto">
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
        <span class="text-primary">{{ __('Detail') }}</span>
        <hr class="z-mgt">
        <table>
            <tbody>
            <tr>
                <td style="height: 45px">
                    <i class="fas fa-map-marker-alt text-primary mgr-10"></i>
                </td>
                <td>
                    <input type="text" style="width: 500px" class="form-control light-color" id="event-location">
                </td>
            </tr>
            <tr>
                <td style="height: 45px">
                    <i class="far fa-bell text-primary mgr-10"></i>
                </td>
                <td>
                    <select readonly class="form-control light-color d-inline-flex justify-content-center w-auto">
                        <option>Email</option>
                    </select>
                    <input type="number" style="width: 70px" class="form-control light-color d-inline-flex" value="30">
                    <select readonly class="form-control light-color d-inline-flex justify-content-center w-auto">
                        <option>{{ __('Minutes') }}</option>
                        <option>{{ __('Hours') }}</option>
                        <option>{{ __('Days') }}</option>
                        <option>{{ __('Weeks') }}</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td style="height: 45px">
                    <i class="fas fa-tags text-primary mgr-10"></i>
                </td>
                <td>
                    <span class="d-inline-flex" id="event-email"></span>
                    <div id="event-tag-dropdown" class="btn-group">
                        <button class="btn btn-sm light-color" type="button">
                            <i tag_id="" id="event-tag" class="fas fa-circle" title=""></i>
                        </button>
                        <button type="button" class="btn btn-sm light-color dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="sr-only">Toggle Dropdown</span>
                        </button>
                        <div class="dropdown-menu z-pdt z-pdb">
                            @foreach($tags as $key => $tag)
                                <a tag_id="{{ $tag->id }}" tag_title="{{ $tag->title }}"
                                   tag_color="{{ $tag->color }}"
                                   class="dropdown-item media pdl-5"
                                   onclick="epic_select_tag(this)" href="#">
                                    <div style="width: 20px; height: 20px; line-height: 20px" class="mr-3">
                                        <i class="fas fa-circle {{ $tag->color }}"></i>
                                    </div>
                                    <div class="media-body" style="height: 20px; line-height: 20px">
                                        <h6 class="mt-0 mb-1">{{ $tag->title }}</h6>
                                    </div>
                                </a>
                                @if($key < (sizeof($tags) - 1))
                                    <div class="dropdown-divider z-mgt z-mgb"></div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td style="vertical-align: top;">
                    <i class="fas fa-align-left text-primary mgr-10"></i>
                </td>
                <td>
                    <textarea id="event_desc" class="form-control" name="txt_desc"></textarea>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
    <div class="col-md-4 col-lg-4">
        <div class="dropdown event-pic">
            <span class="text-primary">{{ __('Person in charge') }}</span>
            <i class="fas fa-cog float-right" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></i>
            <div class="dropdown-menu dropdown-menu-right z-pdt z-pdb margin-bottom-15 mgt-10"></div>
        </div>
        <hr class="z-mgt">
        <ul class="list-group assigned-list list-group-flush margin-bottom-30" style="width: 300px"></ul>
        <span>{{ __('Person in charge permission:') }}</span>
        <table>
            <tbody>
            <tr style="line-height: 1px">
                <td style="height: 30px">
                    <input id="event_pic_edit" type="checkbox" class="mgr-10 light-color" style="width: 15px; height: 15px">
                </td>
                <td>
                    <span>{{ __('Edit') }}</span>
                </td>
            </tr>
            <tr style="line-height: 1px">
                <td style="height: 30px">
                    <input id="event_pic_assign" type="checkbox" class="mgr-10" style="width: 15px; height: 15px">
                </td>
                <td>
                    <span>{{ __('Add person in charge') }}</span>
                </td>
            </tr>
            <tr style="line-height: 1px">
                <td style="height: 30px">
                    <input id="event_pic_see_list" type="checkbox" class="mgr-10" style="width: 15px; height: 15px">
                </td>
                <td>
                    <span>{{ __('See the list of people in charge') }}</span>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
<hr>
<div class="row">
    <div class="col-12 text-right">
        <button type="button" id="btn-delete" onclick="event_delete()" class="btn btn-danger mgr-20">{{ __('Delete') }}</button>
        <button type="button" id="btn-close" onclick="event_cancel()" class="btn btn-outline-secondary" data-dismiss="modal">{{ __('Close') }}</button>
        <button type="button" id="btn-save" onclick="event_save()" class="btn btn-primary">{{ __('Save') }}</button>
    </div>
</div>