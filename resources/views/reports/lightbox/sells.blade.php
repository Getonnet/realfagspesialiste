@if($table->count() > 0)

    <table class="table table-separate table-sm table-striped">
        <thead>
        <tr>
            <th>{{__('Date')}}</th>
            <th>{{__('Student')}}</th>
            <th>{{__('Email')}}</th>
            <th>{{__('Package')}}</th>
            <th>{{__('Hours')}}</th>
            <th>{{__('Price')}}</th>
            <th>{{__('Discount')}}</th>
            <th>{{__('Status')}}</th>

        </tr>
        </thead>
        <tbody>
            @php
                $price = 0;
                $hour = 0;
                $discount = 0;
            @endphp
        @foreach($table as $row)
            <tr>
                <td>{{date('d.M.Y', strtotime($row->created_at))}}</td>
                <td>{{$row->user->name ?? ''}}</td>
                <td>{{$row->user->email ?? ''}}</td>
                <td>{{$row->name}}</td>
                <td>{{$row->hours}} {{__('Hr')}}</td>
                <td>{{$row->price}} kr</td>
                <td>{{$row->discount}} kr</td>
                <td>{{__($row->status)}}</td>

            </tr>
            @php
                $price += $row->price;
                $hour += $row->hours;
                $discount += $row->discount;
            @endphp
        @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="4" class="text-right">{{__('Total')}}</th>
                <th>{{$hour}} {{__('Hr')}}</th>
                <th>{{$price}} kr</th>
                <th>{{$discount}} kr</th>
                <th></th>
            </tr>
        </tfoot>
    </table>
@else
    <p class="text-center text-gray-500">{{__('Nothing to found')}}</p>
@endif
