<?php

namespace App\Http\Controllers\Api\User\Message;

use App\Events\SendNotificationForMessage;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\Message\ChatStatusRequest;
use App\Http\Requests\Api\User\Message\SendAttachmentRequest;
use App\Models\Chat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MessageController extends Controller
{
    public function chatList(Request $request)
    {
        
        // return auth()->id();
        $get_chat_list_1 = DB::table('chats')->select(
            'users.id',
            // 'users.full_name',
            DB::raw('(select Case when users.role = "company"
            THEN 
            (SELECT companies.representative_name FROM companies WHERE companies.user_id = users.id ORDER by companies.id asc LIMIT 1) 
            ELSE users.full_name END 
            )as full_name'),
            'users.avatar',
            'users.role',
            'chats.chat_id',
            DB::raw('(select chat_message  from chats as st where st.chat_id = chats.chat_id order by st.chat_id desc limit 1) as chat_message'),
            DB::raw('(select chat_sender_id  from chats as st where st.chat_id = chats.chat_id order by st.chat_id desc limit 1) as sender_id'),
            DB::raw('(select is_rejected  from chats as st where st.chat_id = chats.chat_id order by st.chat_id desc limit 1) as is_rejected'),
            DB::raw('(select chat_type  from chats as st where st.chat_id = chats.chat_id order by st.chat_id desc limit 1) as chat_type'),
            DB::raw('(select count(chat_id) from chats as st where ((st.chat_sender_id = "'.auth()->id().'" AND st.chat_reciever_id = users.id) OR (st.chat_sender_id = users.id AND st.chat_reciever_id = "'.auth()->id().'" )) AND st.chat_read_at is NULL ) as unread_chat_count'),
            DB::raw('(select count(chat_id) from chats as st where ((st.chat_sender_id = "'.auth()->id().'" AND st.chat_reciever_id = users.id) OR (st.chat_sender_id = users.id AND st.chat_reciever_id = "'.auth()->id().'" )) AND st.chat_read_at is NOT NULL ) as read_chat_count'),
            'chats.chat_read_at',
            'chats.created_at'
        )
        ->leftJoin('users', 'users.id', '=', 'chats.chat_reciever_id')
        ->where('users.deleted_at', Null)
        ->whereRaw('( chat_id in (select MAX(chat_id) from chats where chats.chat_sender_id = "'.auth()->id().'" group by chat_sender_id , chat_reciever_id )  )');

        $get_chat_list_2 = DB::table('chats')->select(
            'users.id',
            // 'users.full_name',
            DB::raw('(select Case when users.role = "company"
            THEN 
            (SELECT companies.representative_name FROM companies WHERE companies.user_id = users.id ORDER by companies.id asc LIMIT 1) 
            ELSE users.full_name END )as full_name'),
            'users.avatar',
            'users.role',
            'chats.chat_id',
            DB::raw('(select chat_message  from chats as st where st.chat_id = chats.chat_id order by st.chat_id desc limit 1) as chat_message'),
            DB::raw('(select chat_sender_id  from chats as st where st.chat_id = chats.chat_id order by st.chat_id desc limit 1) as sender_id'),
            DB::raw('(select is_rejected  from chats as st where st.chat_id = chats.chat_id order by st.chat_id desc limit 1) as is_rejected'),
            DB::raw('(select chat_type  from chats as st where st.chat_id = chats.chat_id order by st.chat_id desc limit 1) as chat_type'),
            DB::raw('(select count(chat_id) from chats as st where ((st.chat_sender_id = "'.auth()->id().'" AND st.chat_reciever_id = users.id) OR (st.chat_sender_id = users.id AND st.chat_reciever_id = "'.auth()->id().'" )) AND st.chat_read_at is NULL ) as unread_chat_count'),
            DB::raw('(select count(chat_id) from chats as st where ((st.chat_sender_id = "'.auth()->id().'" AND st.chat_reciever_id = users.id) OR (st.chat_sender_id = users.id AND st.chat_reciever_id = "'.auth()->id().'" )) AND st.chat_read_at is NOT NULL ) as read_chat_count'),
            'chats.chat_read_at',
            'chats.created_at'
        )
        ->leftJoin('users', 'users.id', '=', 'chats.chat_sender_id')
        ->where('users.deleted_at', Null)
        ->whereRaw('( chat_id in (select MAX(chat_id) from chats where chats.chat_reciever_id = "'.auth()->id().'" group by chat_sender_id , chat_reciever_id )  )')
        ->union($get_chat_list_1);
        // return;
        $groupby = DB::query()->fromSub($get_chat_list_2, 'p_pn')
            ->select('id', 'full_name', 'avatar','role', 'read_chat_count', 'unread_chat_count','is_rejected','chat_id','sender_id',
            DB::raw('(  case when  ( (role = "user" AND  read_chat_count = 0 ) AND ("'.auth()->user()->role.'" != "user") AND sender_id != "'.auth()->id().'" ) THEN 1 ELSE 0 END ) as can_show') ,
            'chat_message','chat_type', 'chat_read_at', 'created_at')
            ->orderBy('chat_id','desc')
            ->get();

        
        if( $groupby->count() == 0 )
        {
            return commonErrorMessage("No chat list found",404);
        }

        $data = [];

        foreach(collect($groupby)->groupBy('id') as $result)
        {
            if( $result[0]->is_rejected == 0 )
            {
                $data[] = $result[0];
            }
        }    
        return apiSuccessMessage("Chat List ", collect($data));
            
    }

    public function sendAttachment(SendAttachmentRequest $request)
    {
        $avatar = '';
        if($request->hasFile('attachment'))
        {
            $imageName = time().'.'.$request->attachment->getClientOriginalExtension();
            $request->attachment->move(public_path('/uploadedimages'), $imageName);
            $avatar = asset('public/uploadedimages')."/".$imageName;
        }
        // $attachment = [
        //     'chat_sender_id' => auth()->id(),
        //     'chat_reciever_id' => $request->receiver_id,
        //     'chat_message' => $avatar,
        //     'chat_type' => $request->attachment->getClientMimeType(),
        // ];

        // Chat::create($attachment);

        return apiSuccessMessage("Success", ['message' => $avatar]);
    }

    public function chatStatus(ChatStatusRequest $request)
    {
        $type = $request->type;
        $user_id = $request->user_id;
        
        if ( $type == 'accept')
        {
            DB::select('UPDATE chats SET chat_read_at = now() WHERE ( (chats.chat_sender_id = "'.$user_id.'" AND chats.chat_reciever_id = "'.auth()->id().'") ) ORDER BY chats.chat_id DESC LIMIT 1');
        }else{
            DB::select('UPDATE chats SET is_rejected = 1 WHERE ( (chats.chat_sender_id = "'.$user_id.'" AND chats.chat_reciever_id = "'.auth()->id().'") ) ORDER BY chats.chat_id DESC LIMIT 1');
        }
        $this->sendMessageNotification($type, $user_id);
        return commonSuccessMessage("Success");
    }

    protected function sendMessageNotification($type, $to_user_id)
    {
        $data = [
            'to_user_id'        =>  $to_user_id,
            'from_user_id'      =>  auth()->id(),
            'notification_type' =>  'MESSAGE',
            'title'             =>  auth()->user()->full_name ." has ".$type."ed message request " ,
            'redirection_id'    =>   auth()->id(),
            'description'       => 'MESSAGE DESCRIPTION',
            'full_name'         => auth()->user()->full_name,
        ];

        $token = DB::table('users')->select('device_token')->where('id', $to_user_id)->value('device_token');
        
        event( new SendNotificationForMessage($data, $token));
    }
}
