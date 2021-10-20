<?php

namespace App\Http\Livewire;

use App\Profile;
use App\User;
use App\MessageMedia;
use App\Message as Msg;
use App\WebsiteMessageCenter;
use Livewire\Component;
use Livewire\WithFileUploads;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;



class Message extends Component
{

    use WithFileUploads;

    public $messages;
    public $message;
    public $toName;
    public $toUserId = null;
    public $toUserProfileImage;
    public $lockType = 'Free';
    public $unlockPrice;
    public $attachmentType = 'None';
    public $images = [];
    public $audios = '';
    public $videos = '';
    public $zips = '';
    public $mobileProfileId;
    public $unreadMessageCount;
    public $massMessage;
    public $massMessageUsers;

    protected $listeners = ['scrollTolast', 'emojioneArea'];

    public function scrollToLast()
    {
        $this->emit('scroll-to-last');
    }

    public function emojioneArea()
    {
        $this->emit('emoji_attached');
        $this->dispatchBrowserEvent('emoji_attached', ['name' => 'John']);
    }

    public function mount()
    {
        $message = '';
    }

    public function setAttachmentType($type)
    {
        $this->attachmentType = $type;

        if($type == 'None') {
            $this->images = [];
            $this->audios = '';
            $this->videos = '';
            $this->zips = '';
        }

    }
    public function deleteMessage($msg_id, $user_id, $type){
        $m = Msg::findorFail($msg_id);
        if($type == 'receiver'){
            if ($m->to_id == $user_id && $m->to_id == auth()->id()) {
                $m->delete();
                //return response()->json( $m );
            }
        }elseif($type == 'sender') {
            if ($m->from_id == $user_id && $m->from_id == auth()->id()) {
                $m->delete();
                //return response()->json( $m );
            }
        }else{
            return false;
        }
        //
        //return response()->json( $r );
    }
    public function deleteConversation($from, $to){
        $m = Msg::where([
            ['from_id', $from],
            ['to_id', $to]
        ])->orWhere([
            ['from_id', $to],
            ['to_id', $from]
        ]);
        if($from == auth()->id()){
           $m->delete();
            //return response()->json( $m );
        }
    }
    public function sendMessage()
    {

        // validate message
        $this->validate(['message' => 'required|min:1']);

        // validate min amount if lockType = Paid
        if($this->lockType == 'Paid') {

            $min = auth()->user()->profile->minTip;
            $max = opt('maxTipAmount', 999.00);

            if (!$min)
                $min = opt('minTipAmount', 1.99);

            $this->validate(['unlockPrice' => 'required|numeric|between:' . '£' . $min . ',' . '£' . $max]);
        }
        

        // add the new msg to db
        $msg = new Msg;
        $msg->from_id = auth()->id();
        $msg->to_id = $this->toUserId;
        $msg->message = $this->message;
        $msg->save();

        // do we have images
        if(count($this->images)) {
            
            $this->validate(['images.*' => 'mimes:jpeg,png,jpg,gif']);

            foreach($this->images as $imageUpload) {

                if ($imageUpload->getMimeType() == 'image/gif') {

                    // if it's a gif, resizing will break it, so upload as is
                    $fileName = $imageUpload->storePublicly('userPics', env('DEFAULT_STORAGE'));

                } else {

                    // get ext
                    $imageExt = $imageUpload->getClientOriginalExtension();

                    // resize
                    $imageUpload = Image::make($imageUpload);
                    
                    // resize for feed (auto width) - 100% quality ratio
                    $imageUpload->resize(1180, null, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })->encode(null, 100)->orientate();

                    // compute a file name
                    $fileName = 'userPics/' . uniqid() . '.' . $imageExt;

                    // store the resized image
                    Storage::disk(env('DEFAULT_STORAGE'))->put($fileName, $imageUpload, 'public');

                    // insert message media
                    $media = new MessageMedia;
                    $media->message_id = $msg->id;
                    $media->media_content = $fileName;
                    $media->media_type = 'Image';
                    $media->disk = env('DEFAULT_STORAGE');
                    $media->lock_type = $this->lockType;
                    $media->lock_price = $this->unlockPrice;
                    $media->save();
                    
                    
                }

            }

        }

        // do we have an audio file
        if ($this->audios != '') {

            $this->validate(['audios' => 'mimes:mp3,ogg,wav']);

            // store audio
            $fileName = $this->audios->storePublicly('userAudio', env('DEFAULT_STORAGE'));

            // insert message media
            $media = new MessageMedia;
            $media->message_id = $msg->id;
            $media->media_content = $fileName;
            $media->media_type = 'Audio';
            $media->disk = env('DEFAULT_STORAGE');
            $media->lock_type = $this->lockType;
            $media->lock_price = $this->unlockPrice;
            $media->save();

        }

        // do we have a video file
        if ($this->videos != '') {

            $this->validate(['videos' => 'mimes:mp4,ogg,webm,mov,qt']);

            // store audio
            $fileName = $this->videos->storePublicly('userVids', env('DEFAULT_STORAGE'));

            // insert message media
            $media = new MessageMedia;
            $media->message_id = $msg->id;
            $media->media_content = $fileName;
            $media->media_type = 'Video';
            $media->disk = env('DEFAULT_STORAGE');
            $media->lock_type = $this->lockType;
            $media->lock_price = $this->unlockPrice;
            $media->save();
            
        }

        // do we have a zip file
        if ($this->zips != '') {

            $this->validate(['zips' => 'mimes:zip']);

            // store audio
            $fileName = $this->zips->storePublicly('userZips', env('DEFAULT_STORAGE'));

            // insert message media
            $media = new MessageMedia;
            $media->message_id = $msg->id;
            $media->media_content = $fileName;
            $media->media_type = 'Zip';
            $media->disk = env('DEFAULT_STORAGE');
            $media->lock_type = $this->lockType;
            $media->lock_price = $this->unlockPrice;
            $media->save();
            
        }
        

        // reset this message
        $this->message = '';
        $this->images = [];
        $this->audios = '';
        $this->videos = '';
        $this->zips = '';
        $this->unlockPrice = '';
        $this->lockType = 'None';

        // refresh message list
        $this->messages = $this->getMessages($this->toUserId);

        // clean livewire directory
        

        $this->emit('scroll-to-last');
        $this->emit('reset-message');
        $this->emit('emoji_attached');
    }

    public function updatedMobileProfileId($id) {
        if(!empty($id))
            $this->openConversation($id);
    }

    public function clickConversation($user){
        $this->openConversation($user);
        $this->emit('scroll-to-last');
    }

    public function openConversation($user)
    {
        // get recipient
        $toName = User::select('name')->where('id', $user)->first();
        // set messages
        $messages = $this->getMessages($user);

        $this->messages = $messages;
        $this->toName = $toName->name;
        $this->toUserId = $user;
        $this->toUserProfileImage = User::find($user)->profile->profilePic;
        // $this->emit('scroll-to-last');
    }

    public function render()
    {
        // get followers and follows
        $people = $this->getPeople();
        $messages = $this->messages;
        //$unreadMessagesByUser = getUnreadMessages();
        $m = WebsiteMessageCenter::findOrFail(1);
        $this->dispatchBrowserEvent('contentChanged');
        // get last messages toward this user
        $unreadMsg = Msg::select('message', 'from_id', 'is_read','to_id')
            ->where('to_id', auth()->id())
            ->with('media')
            ->orderByDesc('id')
            ->get()
            ->unique('from_id');

        $this->massMessageUsers = $people;
        return view('livewire.message', compact('people', 'messages', 'unreadMsg','m'));
    }

    public function uploadLink($eventType)
    {
        $this->emit($eventType);
    }

    private function getPeople()
    {
        // get followers and follows with total messages
        $people = auth()->user()
            ->whereHas('followings', function ($q) {
                $q->where('following_id', auth()->id());
            })
            ->orWhereHas('followers', function ($q) {
                $q->where('follower_id', auth()->id());
            })
            ->get();

        return $people;
    }

    public function getMessages($user)
    {

        // get prior conversation with this user
        return Msg::where(function ($q) use ($user) {
            $q->where('to_id', auth()->id());
            $q->where('from_id', $user);
        })->orWhere(function ($q) use ($user) {
            $q->where('from_id', auth()->id());
            $q->where('to_id', $user);
        })
            ->with('receiver:id,name', 'sender:id,name')
            ->orderBy('created_at')
            ->get();
    }
    public function unreadMessageCount($from_id){
        $unread = Msg::where([
            ['to_id', auth()->id()],
            ['from_id', $from_id],
            ['is_read', 'No']
        ])->count();
        $this->unreadMessageCount = $unread;
        return $unread;
    }
    public static function getUnreadMessages($from_id){
        $u = auth()->user();
        $unread = Msg::where('from_id', $from_id)->where('to_id', $u)->get();

        return $unread;
    }
    public function sendMassMessage()
    {

        // add the new msg to db
        foreach($this->massMessageUsers as $user ) {
            $msg = new Msg;
            $msg->from_id = auth()->id();
            $msg->to_id = $user->id;
            $msg->message = $this->massMessage;
            $msg->save();
        }

        $this->massMessage = '';
       // refresh message list
       if ($this->toUserId != null) {
        $this->messages = $this->getMessages($this->toUserId);
        // clean livewire directory       

        $this->emit('scroll-to-last');
        $this->emit('reset-message');
        $this->emit('emoji_attached');
       }

       $this->emit('sent-mass-message');
    }

}
