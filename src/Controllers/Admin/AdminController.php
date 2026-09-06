<?php

namespace Azuriom\Plugin\MusicUploader\Controllers\Admin;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Plugin\MusicUploader\Models\MusicTrack;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function index()
    {
        $tracks = MusicTrack::with('user')->latest()->paginate(20);
        return view('musicuploader::admin.index', compact('tracks'));
    }

    public function destroy(MusicTrack $track)
    {
        $relativePath = str_replace('/storage/', 'public/', $track->file_path);
        if (Storage::exists($relativePath)) {
            Storage::delete($relativePath);
        }

        $track->delete();

        return redirect()->route('musicuploader.admin.index')->with('success', 'Трек успешно удален администратором!');
    }
}
