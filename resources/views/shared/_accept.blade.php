@can('accept', $model)
    <a title="Mark this answer as best answer"
        class="{{ $model->status }} mt-2"
        onclick="event.preventDefault(); document.getElementById('accept-answer-{{ $model->id }}').submit();">
        <i class="fa fa-check fa-lg"></i>
    </a>
    <form style="display: none;" action="{{ route('answers.accept', $model->id) }}" id="accept-answer-{{ $model->id }}" method="post">
        @csrf
    </form>
@else
    @if ($model->is_best)
        <a title="The question owner accepted this answer as best answer"
            class="{{ $model->status }} mt-2">
            <i class="fa fa-check fa-lg"></i>
        </a>
    @endif
@endcan