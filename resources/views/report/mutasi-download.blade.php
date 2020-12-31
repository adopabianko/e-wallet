<table>
    <thead>
        <tr>
            <th>NO</th>
            <th>Uraian</th>
            <th>Tipe</th>
            <th>Nominal</th>
            <th>Saldo Akhir</th>
        </tr>
    </thead>
    <tbody>
        @php $no = 1 @endphp
        @foreach($data as $item)
        <tr>
            <td>{{ $no }}</td>
            
            @if($item->type == 'topup')
            <td>Topup melalui bank {{ $item->bank_code }}</td>
            @elseif($item->type == 'transfer' && $item->destination_id != 0)
            <td>
                @php $user = user_data($item->destination_id) @endphp
                Transfer ke {{ $user->name }} ({{ $user->phone_number}})
            </td>
            @elseif($item->type == 'transfer' && $item->transferer_id != 0)
            <td>
                @php $user = user_data($item->transferer_id) @endphp
                Transfer ke {{ $user->name }} ({{ $user->phone_number}})
            </td>
            @endif

            @if($item->credit != 0)
            <td>Credit</td>
            @elseif($item->debit != 0)
            <td>Debit</td>
            @endif
            
            <td>{{ $item->amount }}</td>

            @if($item->credit != 0)
            <td>{{ $item->credit }}</td>
            @elseif($item->debit != 0)
            <td>{{ $item->debit }}</td>
            @endif
        </tr>
        @php $no++ @endphp
        @endforeach
    </tbody>
</table>