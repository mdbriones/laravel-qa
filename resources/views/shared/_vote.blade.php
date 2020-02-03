@if ($model instanceof App\Question)
    @php
        $name = 'question';
        $firstURISegment = "questions";
    @endphp
@elseif ($model instanceof App\Anwer)
    @php
        $name = 'answer';
        $firstURISegment = "answers";
    @endphp
@endif

@php
    $formID = $name . "-" . $model->id;  
    $formAction = "/{$firstURISegment}/{$model->id}/vote";  
@endphp

<div class="d-flex flex-column vote-controls">
    <a title="This {{ $name }} is useful" class="vote-up {{ Auth::guest() ? 'off' : '' }}"
        onclick="event.preventDefault(); document.getElementById('up-vote-{{ $formID }}').submit();">
        <i class="fa fa-caret-up fa-2x"></i>
    </a> 
    <form style="display: none;" action="{{ $formAction }}" id="up-vote-{{ $formID }}" method="post">
        @csrf
        <input type="hidden" name="vote" value="1">
    </form>
    
    <span class="votes-count">{{ $model->votes_count }}</span>

    <a title="This {{ $name }} is not useful" class="vote-down {{ Auth::guest() ? 'off' : '' }} mb-2"
        onclick="event.preventDefault(); document.getElementById('down-vote-{{ $formID }}').submit();">
        <i class="fa fa-caret-down fa-2x"></i>
    </a>
    <form style="display: none;" action="{{ $formAction }}" id="down-vote-{{ $formID }}" method="post">
        @csrf
        <input type="hidden" name="vote" value="-1">
    </form>
    
    @if ($model instanceof App\Question)
        @include('shared._favorite', [
            'model' => $model
        ])
    @elseif($model instanceof App\Answer)
        @include('shared._accept', [
            'model' => $model
        ])
    @endif
</div>