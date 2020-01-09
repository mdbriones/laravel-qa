@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center p-2 bd-highlight">
                            <h4>Edit answer for : <strong> {{ $question->title }}</strong></h4>
                            <div class="ml-auto">
                                <a class="btn btn-sm btn-outline-info" href="{{ route('questions.show', $question->slug) }}">Back</a>
                            </div>
                        </div>
                        <hr>
                        <form action="{{ route('questions.answers.update', [$question->id, $answer->id]) }}" method="post">
                            @csrf
                            @method("PATCH") {{-- PUT if there are many to be updated, PATCH if you will only update one column --}}
                            <div class="form-group">
                                <textarea name="body" class="form-control {{ $errors->has('body') ? 'is-invalid' : '' }}" id="" rows="8">{{ old('body', $answer->body) }}</textarea>
                                @if ($errors->has('body'))
                                    <div class="invalid-feedback">
                                        <strong>{{ $errors->first('body') }}</strong>
                                    </div>
                                @endif
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-sm btn-outline-primary">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection