<?php

namespace App\Http\Controllers\Api;
use App\Events\SentMessage;
use App\Http\Collections\MessageCollection;
use App\Http\Resources\MessageResource;
use App\Repos\MessageRepo;
use App\Validations\MessageValidation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;
use Validator, Auth, Artisan, Hash, File, Mail;

class MessageController extends Controller
{
    use \App\Traits\ApiResponseTrait;
    public function __construct(MessageRepo $messageRepo
        ,MessageValidation $messageValidation)
    {
        $this->messageRepo = $messageRepo;
        $this->messageValidation = $messageValidation;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function get(Request $request)
    {
        $request['user_id'] = Auth::user()->id;
        $messages = $this->messageRepo->get($request);
        return $this->apiResponseData(new MessageCollection($messages));
    }
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function send_message(Request $request)
    {
        App::setLocale($request->header('lang'));
        $validateMessage = $this->messageValidation->validate($request);
        if($validateMessage->operationType==ERROR){
            return $this->apiResponseMessage(0,$validateMessage->error,200);
        }
        $data = $this->messageRepo->create($request);
        event(new SentMessage($data));
        return $this->apiResponseData(new MessageResource($data));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function mark_as_seen(Request $request)
    {
        $request['message_ids']=json_decode($request->message_ids,true);
        $this->messageRepo->updateIsSeen($request->message_ids);
        return $this->apiResponseMessage(1, 'success');
    }

}
