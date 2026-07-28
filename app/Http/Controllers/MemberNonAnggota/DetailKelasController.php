<?php

namespace App\Http\Controllers\MemberNonAnggota;

use App\Http\Controllers\Controller;
use App\Models\ClassContentModel;
use App\Models\ClassEventModel;
use App\Models\ClassesModel;
use App\Models\DataPayment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DetailKelasController extends Controller
{
    public function show(Request $request, string $uniqueId, string $title)
    {
        $class = $this->ownedClassesQuery($request)
            ->where('unique_id', $uniqueId)
            ->firstOrFail();

        $participantCount = (int) DataPayment::query()
            ->where('user_id', $request->user()->id)
            ->where('class_id', $class->id)
            ->where('status', DataPayment::STATUS_PAID)
            ->latest('id')
            ->value('qty');

        $contentUnlockAt = $this->contentUnlockAt((int) $class->id);
        $accessEvent = $this->accessEvent((int) $class->id);

        $contents = ClassContentModel::query()
            ->where('class_id', $class->id)
            ->orderBy('id')
            ->get();

        return view('membernonkeanggotaan.pages.kelas.detailkelas', [
            'class' => $class,
            'participantCount' => $participantCount,
            'contents' => $contents,
            'contentUnlockAt' => $contentUnlockAt,
            'contentUnlocked' => $contentUnlockAt && now()->greaterThanOrEqualTo($contentUnlockAt),
            'accessEvent' => $accessEvent,
        ]);
    }

    public function showContent(Request $request, int $contentId)
    {
        $content = ClassContentModel::query()->findOrFail($contentId);
        $this->ownedClassesQuery($request)
            ->whereKey((int) $content->class_id)
            ->firstOrFail();

        $contentUnlockAt = $this->contentUnlockAt((int) $content->class_id);

        abort_if(! $contentUnlockAt || now()->lt($contentUnlockAt), 403, 'Materi belum tersedia.');

        if (! in_array((int) $content->type, [
            0,
            ClassContentModel::TYPE_DOCUMENT,
            ClassContentModel::TYPE_IMAGE,
        ], true)) {
            abort(404);
        }

        $path = ltrim((string) $content->url, '/');
        abort_if($path === '' || $path === '-', 404);
        abort_unless(Storage::exists($path), 404);

        if ($request->boolean('download')) {
            return Storage::download($path, basename($path));
        }

        return Storage::response($path);
    }

    private function ownedClassesQuery(Request $request)
    {
        return ClassesModel::query()
            ->where('status', 1)
            ->whereIn('id', DataPayment::query()
                ->select('class_id')
                ->where('user_id', $request->user()->id)
                ->where('status', DataPayment::STATUS_PAID)
                ->whereNotNull('class_id'));
    }

    private function contentUnlockAt(int $classId): ?Carbon
    {
        return ClassEventModel::query()
            ->where('class_id', $classId)
            ->whereNotNull('time_end')
            ->get(['time_end'])
            ->map(fn ($event) => Carbon::parse($event->time_end))
            ->sortBy(fn (Carbon $time) => $time->timestamp)
            ->last();
    }

    private function accessEvent(int $classId): ?ClassEventModel
    {
        $events = ClassEventModel::query()
            ->where('class_id', $classId)
            ->orderBy('time_start')
            ->get();

        $event = $events->first(function (ClassEventModel $event) {
            if ((int) $event->type === 0) {
                return filled($event->link) || filled($event->password_link);
            }

            return (int) $event->type === 1 && filled($event->description);
        });

        return $event ?: $events->first();
    }
}
