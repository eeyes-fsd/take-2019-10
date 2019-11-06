<?php

namespace App\Http\Controllers\Api;

use App\Models\Image;
use Illuminate\Support\Str;
use App\Handlers\ImageUploadHandler;
use App\Http\Requests\Api\ImageRequest;

class ImagesController extends Controller
{
    /**
     * @param ImageRequest $request
     * @param ImageUploadHandler $handler
     * @return \Dingo\Api\Http\Response
     */
    public function store(ImageRequest $request, ImageUploadHandler $handler)
    {
        $user = $request->user();

        $result = $handler->save($request->file('image'), Str::plural($request->post('type')), $user->id);

        $image = new Image();

//        dd($result);

        $image->path = $result['path'];
        $image->type = $request->type;
        $image->user_id = $user->id;

        $image->save();

        return $this->response->created($image->path);
    }
}
