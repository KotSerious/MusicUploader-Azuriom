@extends('layouts.app')

@section('title', trans('musicuploader::messages.title'))

@section('content')
<div class="container text-start">
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h1 class="h3 mb-3">{{ trans('musicuploader::messages.upload_title') }}</h1>
            
            @if(auth()->user()->hasPermission('musicuploader.upload') || auth()->user()->is_admin)
                <form action="{{ route('musicuploader.upload') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="audio" class="form-label">{{ trans('musicuploader::messages.select_file') }}</label>
                        <input class="form-control" type="file" id="audio" name="audio" accept="audio/*" required>
                    </div>
                    <button type="submit" class="btn btn-primary">{{ trans('musicuploader::messages.btn_upload') }}</button>
                </form>
            @else
                <div class="alert alert-warning">{{ trans('musicuploader::messages.no_permission') }}</div>
            @endif
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <h2 class="h4 mb-3">{{ trans('musicuploader::messages.my_tracks') }}</h2>
            @if($tracks->isEmpty())
                <p class="text-muted">{{ trans('musicuploader::messages.empty') }}</p>
            @else
                <div class="list-group">
@foreach($tracks as $track)
    <div class="list-group-item d-flex align-items-center justify-content-between py-3">
        <!-- Левая часть: название трека (всегда слева и не ломает строку) -->
        <div class="pe-3 text-truncate" style="max-width: 40%;">
            <strong class="text-truncate d-block" title="{{ $track->name }}">{{ $track->name }}</strong>
            <small class="text-muted d-block mt-1">{{ trans('musicuploader::messages.uploaded_at') }}: {{ $track->created_at->format('d.m.Y H:i') }}</small>
        </div>

        <!-- Правая часть: плеер и кнопки -->
        <div class="d-flex align-items-center gap-3 ms-auto">
            <!-- Плеер -->
            <audio controls preload="metadata" style="height: 36px; width: 350px;">
                <source src="{{ url($track->file_path) }}" type="audio/mpeg">
                <source src="{{ url($track->file_path) }}" type="audio/ogg">
                <source src="{{ url($track->file_path) }}" type="audio/wav">
            </audio>

            <!-- Кнопка копирования -->
            <button type="button" class="btn btn-sm btn-outline-secondary copy-btn" data-url="{{ url($track->file_path) }}" style="white-space: nowrap;">
                {{ trans('musicuploader::messages.btn_copy') }}
            </button>
            
            <!-- Кнопка удаления -->
            <form action="{{ route('musicuploader.destroy', $track) }}" method="POST" onsubmit="return confirm('{{ trans('musicuploader::messages.confirm_delete') }}')" class="m-0">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-outline-danger" style="white-space: nowrap;">{{ trans('musicuploader::messages.btn_delete') }}</button>
            </form>
        </div>
    </div>
@endforeach
                </div>
            @endif
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.copy-btn').forEach(button => {
        button.addEventListener('click', function () {
            const url = this.getAttribute('data-url');

            // Используем современное API браузера для копирования
            navigator.clipboard.writeText(url).then(() => {
                const originalText = this.innerHTML;

                // Меняем текст кнопки, чтобы пользователь понял, что всё скопировалось
                this.innerHTML = '{{ trans('musicuploader::messages.btn_copied') }}';
                this.classList.remove('btn-outline-secondary');
                this.classList.add('btn-success');

                // Через 2 секунды возвращаем исходный вид кнопки
                setTimeout(() => {
                    this.innerHTML = originalText;
                    this.classList.remove('btn-success');
                    this.classList.add('btn-outline-secondary');
                }, 2000);
            }).catch(err => {
                console.error('{{ trans('musicuploader::messages.error_copy_console') }}', err);
                alert('{{ trans('musicuploader::messages.error_copy') }}' + url);
            });
        });
    });
});
</script>

@endsection
