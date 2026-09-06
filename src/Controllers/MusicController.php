<?php

namespace Azuriom\Plugin\MusicUploader\Controllers;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Plugin\MusicUploader\Models\MusicTrack;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MusicController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $tracks = MusicTrack::where('user_id', $user->id)->latest()->get();

        return view('musicuploader::index', compact('tracks'));
    }

    public function upload(Request $request)
    {
        if (!auth()->user()->hasPermission('musicuploader.upload') && !auth()->user()->is_admin) {
            abort(403, trans('musicuploader::messages.no_permission'));
        }

        $request->validate([
            'audio' => 'required|mimes:mp3,wav,ogg|max:131072',
        ]);

        if ($request->file('audio')->isValid()) {
            $file = $request->file('audio');
            $path = $file->store('public/music');
            $url = Storage::url($path);

            MusicTrack::create([
                'user_id' => auth()->id(),
                'name' => $file->getClientOriginalName(),
                'file_path' => $url,
            ]);

            return redirect()->back()->with('success', trans('musicuploader::messages.success_upload'));
        }

        return redirect()->back()->with('error', trans('musicuploader::messages.error_upload'));
    }

    public function destroy(MusicTrack $track)
    {
        if ($track->user_id !== auth()->id() && !auth()->user()->is_admin) {
            abort(403, trans('musicuploader::messages.no_permission'));
        }

        $relativePath = str_replace('/storage/', 'public/', $track->file_path);
        if (Storage::exists($relativePath)) {
            Storage::delete($relativePath);
        }

        $track->delete();

        return redirect()->back()->with('success', trans('musicuploader::messages.success_delete'));
    }
}
