@extends('admin.layouts.admin')

@section('title', trans('musicuploader::messages.adm_music_control'))

@section('content')
<div class="card shadow mb-4">
    <div class="card-body">
        <h1 class="h3 mb-3">🎵 {{ trans('musicuploader::messages.adm_all_music') }}</h1>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>{{ trans('musicuploader::messages.adm_user') }}</th>
                        <th>{{ trans('musicuploader::messages.adm_file') }}</th>
                        <th>{{ trans('musicuploader::messages.adm_date') }}</th>
                        <th>{{ trans('musicuploader::messages.adm_action') }}</th>
                    </tr>
                </thead>
<tbody>
    @foreach($tracks as $track)
        <tr>
            <td class="align-middle">{{ $track->id }}</td>
            <td class="align-middle">
                <strong>{{ $track->user->name ?? trans('musicuploader::messages.adm_del_user') }}</strong>
            </td>
            <!-- Колонка с треком и встроенным плеером -->
            <td class="align-middle">
                <div class="d-flex align-items-center justify-content-between gap-3">
                    <div class="text-truncate" style="max-width: 200px;" title="{{ $track->name }}">
                        {{ $track->name }}
                    </div>
                    <!-- Компактный плеер, прижатый к правой части ячейки -->
                    <audio controls preload="metadata" style="height: 32px; width: 350px;">
                        <source src="{{ url($track->file_path) }}" type="audio/mpeg">
                        <source src="{{ url($track->file_path) }}" type="audio/ogg">
                        <source src="{{ url($track->file_path) }}" type="audio/wav">
                    </audio>
                </div>
            </td>
            <td class="align-middle text-muted">
                {{ $track->created_at->format('d.m.Y H:i') }}
            </td>
            <!-- Действия модератора -->
            <td class="align-middle text-end">
                <div class="d-flex justify-content-end gap-2">
                    <!-- Добавим админу тоже кнопку копирования, это полезно -->
                    <button type="button" class="btn btn-sm btn-outline-secondary copy-btn" data-url="{{ url($track->file_path) }}">
                        {{ trans('musicuploader::messages.btn_copy') }}
                    </button>
                    
                    <form action="{{ route('musicuploader.admin.destroy', $track) }}" method="POST" onsubmit="return confirm('{{ trans('musicuploader::messages.confirm_delete') }}')" class="m-0">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">{{ trans('musicuploader::messages.btn_delete') }}</button>
                    </form>
                </div>
            </td>
        </tr>
    @endforeach
</tbody>
            </table>
            {{ $tracks->links() }}
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
