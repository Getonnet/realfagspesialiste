@extends('layouts.general')

@section('title')
    {{__('Edit Event Data')}}
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col">

                <div class="card card-custom">
                    <div class="card-header">
                        <div class="card-title">
                        <span class="card-icon">
                            <i class="flaticon-edit text-success"></i>
                        </span>
                            <h3 class="card-label">{{__('Edit Event Data')}}</h3>
                        </div>
                    </div>
                    <form id="edit_form" action="{{route('teacher.events-update', ['id' => $table->id])}}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <x-ninput label="{{__('Title')}}" name="name" required="required" />
                                    <x-ninput label="{{__('Event Date')}}" name="event_start" required="required" />
                                    <x-ninput label="{{__('Start')}}" name="start_time" required="required" />
                                    <x-ninput label="{{__('End')}}" name="end_time" required="required" />
                                    <x-nselect label="{{__('Select Student')}}" name="student_id" required="required" >
                                        <option value="">{{__('Select Student')}}</option>
                                        @foreach($students as $row)
                                            @php
                                                $hour = $row->students->purchase()->where('status', 'Active')->sum('hours');
                                                $spends = $row->students->time_log()->where('status', 'End')->get();
                                                $spend_times = 0;
                                                foreach ($spends as $spend){
                                                    $spend_times += $spend->spend_time();
                                                }
                                                $hour_to_min = $hour * 60;
                                                $remain_min = $hour_to_min - $spend_times;
                                                $remaining = number_format(($remain_min / 60), 2, '.', ' ');

                                            @endphp

                                            <option value="{{$row->student_id}}">{{$row->students->name ?? ''}} ({{$remaining}})</option>
                                        @endforeach
                                    </x-nselect>
                                    <x-nselect label="{{__('Subject Select')}}" name="subject_id" required="required" >
                                        <option value="">{{__('Select Subject')}}</option>
                                        @foreach($subjects as $row)
                                            <option value="{{$row->subject_id}}">{{$row->subject->name ?? ''}}</option>
                                        @endforeach
                                    </x-nselect>

                                </div>
                                <div class="col">
                                    <x-nselect label="{{__('Transport Time')}}" name="hour_spend" required="required" >
                                        <option value="">{{__('Select Time')}}</option>
                                        <option value="0">0 min</option>
                                        <option value="15">15 min</option>
                                        <option value="20">20 min</option>
                                        <option value="25">25 min</option>
                                        <option value="30">30 min</option>
                                    </x-nselect>
                                    <x-ninput label="{{__('Motivational Scale (1-10)')}}" name="motivational" type="number" min="1" max="10" required="required" />
                                    <x-ninput label="{{__('Understanding Scale (1-10)')}}" name="understanding" type="number" min="1" max="10" required="required" />

                                    <div class="form-group">
                                        <label for="descriptionx">{{__('Descriptions')}}</label>
                                        <textarea class="form-control" id="descriptionx" name="description" placeholder="{{__('Lesson Descriptions')}}" rows="3"></textarea>
                                    </div>

                                    <div class="form-group">
                                        <label for="summeryx">{{__('Summery')}}</label>
                                        <textarea class="form-control" id="summeryx" name="summery" placeholder="{{__('Summery this session')}}" rows="3"></textarea>
                                    </div>

                                    <div class="form-group">
                                        <label for="files">{{__('Study Materials')}}</label>
                                        <input id="files" type="file" name="materials[]" multiple>
                                    </div>

                                    <div>
                                        @php
                                            $mat = $table->studyMaterials()->get();
                                        @endphp
                                        <table class="table table-sm">
                                            @foreach($mat as $row)
                                                <tr>
                                                    <td><a class="btn btn-sm btn-success" href="{{asset($row->file_name)}}">{{__('Download')}}</a></td>
                                                    <td class="text-right"><a class="btn btn-sm btn-danger" href="javascript:;" data-href="{{route('teacher.events-file-del',['id' => $row->id])}}"  onclick="delFn(this)">{{__('Delete')}}</a></td>
                                                </tr>
                                            @endforeach
                                        </table>
                                    </div>


                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-right">
                            <button type="submit" class="btn btn-success">{{__('Save changes')}}</button>
                        </div>
                    </form>

                </div>

            </div>
        </div>
    </div>

@endsection

@section('script')
    <script type="text/javascript">
        $(function () {
            $('#edit_form [name=name]').val("{{$table->name}}");
            $('#edit_form [name=student_id]').val("{{$table->student_id}}");
            $('#edit_form [name=subject_id]').val("{{$table->subject_id}}");
            $('#edit_form [name=hour_spend]').val("{{$table->hour_spend}}");
            $('#edit_form [name=motivational]').val("{{$table->motivational}}");
            $('#edit_form [name=understanding]').val("{{$table->understanding}}");
            $('#edit_form [name=description]').val("{{$table->description}}");
            $('#edit_form [name=summery]').val("{{$table->summery}}");


            $('#edit_form [name=event_start]').daterangepicker({
                timePicker: true,
                timePicker24Hour: true,
                singleDatePicker: true,
                startDate: "{{date('d-m-Y H:i', strtotime($table->event_start))}}",
                locale: picker_loc
            });

            $('#edit_form [name=start_time]').daterangepicker({
                timePicker: true,
                timePicker24Hour: true,
                singleDatePicker: true,
                startDate: "{{date('d-m-Y H:i', strtotime($table->start_time))}}",
                locale: picker_loc
            });

            $('#edit_form [name=end_time]').daterangepicker({
                timePicker: true,
                timePicker24Hour: true,
                singleDatePicker: true,
                startDate: "{{date('d-m-Y H:i', strtotime($table->end_time))}}",
                locale: picker_loc
            });
        });
    </script>
@endsection
