@if ($answersCount > 0)
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <h4>{{ $answersCount . " " . str_plural('Answer', $answersCount) }}</h4>
                    </div>
                    <hr>
                    @include('layouts._messages')
                    @foreach ($answers as $answer)
                        <div class="media">
                            <div class="d-flex flex-column vote-controls">
                                <a title="This answer is useful" class="vote-up {{ Auth::guest() ? 'off' : '' }}"
                                    onclick="event.preventDefault(); document.getElementById('up-vote-answer-{{ $answer->id }}').submit();">
                                    <i class="fa fa-caret-up fa-2x"></i>
                                </a> 
                                <form style="display: none;" action="/answers/{{ $answer->id }}/vote" id="up-vote-answer-{{ $answer->id }}" method="post">
                                    @csrf
                                    <input type="hidden" name="vote" value="1">
                                </form>

                                <span class="votes-count">{{ $answer->votes_count }}</span>

                                <a title="This answer is not useful" class="vote-down {{ Auth::guest() ? 'off' : '' }} mb-2"
                                    onclick="event.preventDefault(); document.getElementById('down-vote-answer-{{ $answer->id }}').submit();">
                                    <i class="fa fa-caret-down fa-2x"></i>
                                </a>
                                <form style="display: none;" action="/answers/{{ $answer->id }}/vote" id="down-vote-answer-{{ $answer->id }}" method="post">
                                    @csrf
                                    <input type="hidden" name="vote" value="-1">
                                </form>
                            </div>
                            <div class="media-body">
                                {!! $answer->body_html !!}
                                <div class="row">
                                    <div class="col-4">
                                        <div class="ml-auto">
                                            @can ('update', $answer)
                                                <a href="{{ route('questions.answers.edit', [$question->id, $answer->id]) }}" class="btn btn-outline-info btn-sm">Edit</a>
                                            @endcan    
                                            @can ('delete', $answer)
                                                <form method="POST" class="form-delete" action="{{ route('questions.answers.destroy', [$question->id, $answer->id]) }}">
                                                    @method('DELETE')
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-outline-danger" onClick="return confirm('Are you sure?')">
                                                        Delete
                                                    </button>
                                                </form>
                                            @endcan
                                        </div>
                                    </div>
                                    <div class="col-4"></div>
                                    <div class="col-4">
                                        @include('shared._author', [
                                            'model' => $answer,
                                            'label' => 'answered'
                                        ])
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                        <hr>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endif