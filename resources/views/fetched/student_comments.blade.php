@foreach ($comments as $item)
    <li class="list-group-item">
        <span class="badge">{{ $item->admin->name . '|' . $item->created_at }} @if (auth()->user()->id == $item->admin_id)
                <a href="{{ route('student.comment.delete', $item->id) }}" class="text-danger badge">delete</a>
            @endif
        </span>
        {{ $item->comment }}
    </li>
@endforeach
