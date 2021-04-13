@if($table->count() > 0)

    <div class="row">
        @foreach($table as $row)
            <div class="col-md-3">
                <div class="card card-custom mb-5 bg-hover-light"  data-toggle="modal" data-target="#viewModal" onclick="viewFn(this)"
                     data-href="{{route('teacher.events-overview', ['id' => $row->id])}}">
                    <div class="card-header">
                        <div class="card-title">
                            <h3 class="card-label">
                                {{Str::limit($row->name ?? __('No Title'), 20)}}
                            </h3>
                        </div>
                        <!--<div class="card-toolbar">
                            <div class="dropdown dropdown-inline" data-toggle="tooltip" title="" data-placement="left" data-original-title="Quick actions">
                                <a href="#" class="btn btn-hover-light-primary btn-sm btn-icon" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="ki ki-bold-more-hor"></i>
                                </a>
                                <div class="dropdown-menu p-0 m-0 dropdown-menu-md dropdown-menu-right" style="">

                                    <ul class="navi navi-hover">
                                        <li class="navi-item">
                                            <a href="#" class="navi-link">
                                                <span class="navi-text">
                                                    <span class="label label-xl label-inline label-light-success">Customer</span>
                                                </span>
                                            </a>
                                        </li>
                                        <li class="navi-item">
                                            <a href="#" class="navi-link">
                                                <span class="navi-text">
                                                    <span class="label label-xl label-inline label-light-danger">Partner</span>
                                                </span>
                                            </a>
                                        </li>
                                    </ul>

                                </div>
                            </div>
                        </div>-->
                    </div>
                    <div class="card-body">
                        <p><b>{{__('Student')}}</b></p>
                        <p class="bg-primary-o-100 p-1"><i class="flaticon2-user text-danger"></i> {{$row->student_name}}</p>
                        <p><b>{{__('Start')}}</b></p>
                        {{isset($row->start_time) ? date('d, M H:i', strtotime($row->start_time)) : ''}}
                    </div>
                </div>
            </div>
        @endforeach
    </div>
{{--    <table class="table table-separate table-sm table-striped">--}}
{{--        <thead>--}}
{{--        <tr>--}}
{{--            <th>{{__('Event Date')}}</th>--}}
{{--            <th>{{__('Subject')}}</th>--}}
{{--            <th>{{__('Student')}}</th>--}}
{{--            <th>{{__('Email')}}</th>--}}
{{--            <th>{{__('Start')}}</th>--}}
{{--            <th>{{__('End')}}</th>--}}
{{--            <th>{{__('Hour')}}</th>--}}
{{--            <th>{{__('Travel')}}</th>--}}
{{--            <th>{{__('Status')}}</th>--}}
{{--        </tr>--}}
{{--        </thead>--}}
{{--        <tbody>--}}
{{--        @foreach($table as $row)--}}
{{--            <tr>--}}
{{--                <td>{{date('d, M h:i A', strtotime($row->event_start))}}</td>--}}
{{--                <td>{{$row->subject_name}}</td>--}}
{{--                <td>{{$row->student_name}}</td>--}}
{{--                <td>{{$row->student_email}}</td>--}}
{{--                <td>{{isset($row->start_time) ? date('d, M h:i A', strtotime($row->start_time)) : ''}}</td>--}}
{{--                <td>{{isset($row->end_time) ? date('d, M h:i A', strtotime($row->end_time)) : ''}}</td>--}}
{{--                <td>{{$row->spend_time('H')}} {{__('Hr')}}</td>--}}
{{--                <td>{{$row->hour_spend}} Min</td>--}}
{{--                <td>{{__($row->status)}}</td>--}}
{{--            </tr>--}}
{{--        @endforeach--}}
{{--        </tbody>--}}
{{--    </table>--}}

@else
    <p class="text-center text-gray-500">{{__('Nothing to found')}}</p>
@endif
