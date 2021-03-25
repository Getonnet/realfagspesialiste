@if($table->count() > 0)

    <table class="table table-separate table-sm table-striped">
        <thead>
        <tr>
            <th>{{__('Date')}}</th>
            <th>{{__('Teacher')}}</th>
            <th>{{__('Email')}}</th>
            <th>{{__('Paid Hour')}}</th>
            <th>{{__('Paid Amount')}}</th>
            <th>{{__('Payment Descriptions')}}</th>

        </tr>
        </thead>
        <tbody>
        @php
            $amount = 0;
            $hour = 0;
            $discount = 0;
        @endphp
        @foreach($table as $row)
            <tr>
                <td>{{date('d/m/Y', strtotime($row->created_at))}}</td>
                <td>{{$row->user->name ?? ''}}</td>
                <td>{{$row->user->email ?? ''}}</td>
                <td>{{$row->description}}</td>
                <td>{{$row->paid_hour}}</td>
                <td>{{$row->amount}}</td>
            </tr>
            @php
                $amount += $row->amount;
                $hour += $row->paid_hour;
            @endphp
        @endforeach
        </tbody>
        <tfoot>
        <tr>
            <th colspan="4" class="text-right">{{__('Total')}}</th>
            <th>{{$hour}}</th>
            <th>{{$amount}}</th>
        </tr>
        </tfoot>
    </table>
@else
    <p class="text-center text-gray-500">{{__('Nothing to found')}}</p>
@endif
