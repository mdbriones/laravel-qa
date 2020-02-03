<a title="Click to mark as favorite question (Click again to undo)" 
    class="favorite mt-2 {{ Auth::guest() ? 'off' : ($model->is_favorited ? 'favorited' : '') }}"
    onclick="event.preventDefault(); document.getElementById('favorite-question-{{ $model->id }}').submit();">
    <i class="fa fa-star fa-lg"></i>
    <span class="favorites-count">{{ $model->favorites_count }}</span>
</a>
<form style="display: none;" action="/{{ $firstURISegment }}/{{ $model->id }}/favorites" id="favorite-question-{{ $model->id }}" method="post">
    @csrf
    @if ($model->is_favorited)
        @method('DELETE')
    @endif
</form>