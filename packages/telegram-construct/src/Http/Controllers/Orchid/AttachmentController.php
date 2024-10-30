<?php
declare(strict_types=1);

namespace Valibool\TelegramConstruct\Http\Controllers\Orchid;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Orchid\Platform\Dashboard;
use Orchid\Platform\Http\Controllers\Controller;
use Valibool\TelegramConstruct\Models\File\TgConstructAttachment;
use Valibool\TelegramConstruct\Platform\Events\UploadedFileEvent;
use Valibool\TelegramConstruct\Services\File\FileService;

class AttachmentController extends Controller
{
    protected $attachment;

    /**
     * AttachmentController constructor.
     */
    public function __construct()
    {
//        dd(Auth::user());
//        $this->checkPermission('platform.systems.attachment');
        $this->attachment = Dashboard::modelClass(TgConstructAttachment::class);
    }

    public function upload(Request $request): JsonResponse
    {
        $attachment = collect($request->allFiles())
            ->flatten()
            ->map(fn (UploadedFile $file) => $this->createModel($file, $request));

        $response = $attachment->count() > 1 ? $attachment : $attachment->first();

        return response()->json($response);
    }

    /**
     * Update the sort order of the files.
     */
    public function sort(Request $request): void
    {
        collect($request->get('files', []))
            ->each(function ($sort, $id) {
                $attachment = $this->attachment->find($id);
                $attachment->sort = $sort;
                $attachment->save();
            });
    }

    /**
     * Delete files.
     */
    public function destroy(string $id, Request $request): void
    {
        $storage = $request->get('storage', 'public');
        $this->attachment->findOrFail($id)->delete($storage);
    }

    public function update(string $id, Request $request)
    {
        $attachment = $this->attachment
            ->findOrFail($id)
            ->fill($request->all());

        $attachment->save();

        return response()->json($attachment);
    }

    /**
     * Create and load an attachment model from the uploaded file.
     *
     * @throws BindingResolutionException
     *
     * @return mixed
     */
    private function createModel(UploadedFile $file, Request $request)
    {
        $file = resolve(FileService::class, [
            'file'  => $file,
            'disk'  => $request->get('storage'),
            'group' => $request->get('group'),
        ]);

        if ($request->has('path')) {
            $file->path($request->get('path'));
        }

        $model = $file->load();

        $model->url = $model->url();

        event(new UploadedFileEvent($model));

        return $model;
    }

    /**
     * Retrieve paginated media attachments.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function media(): JsonResponse
    {
        $attachments = $this->attachment->filters()->paginate(12);

        return response()->json($attachments);
    }
}

