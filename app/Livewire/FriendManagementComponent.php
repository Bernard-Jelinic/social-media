<?php

namespace App\Livewire;

use Livewire\Component;
use App\Enums\FriendStatus;

class FriendManagementComponent extends Component
{
    public $user_profile;
    public $request_in_process = false;
    public $request_accepted = false;

    public function mount($user_profile): void
    {
        $this->user_profile = $user_profile;
        $friend = auth()->user()->sentRequestTo()->withPivot('status')->where('receiver_id', $user_profile->id)->first();
        if ($friend !== null) {
            $friend = $friend->pivot;
            if ($friend->status == FriendStatus::IN_PROCESS) {
                $this->request_in_process = true;
            }
        }
    }

    public function addFriend(): void
    {
        auth()->user()->sentRequestTo()->attach($this->user_profile->id);
        $this->request_in_process = true;
    }

    public function cancelFriendRequest(): void
    {
        auth()->user()->sentRequestTo()->detach($this->user_profile->id);
        $this->request_in_process = false;
    }

    public function deleteFriendRequest(): void
    {
        dd( 'deleteFriendRequest' );
    }

    public function render(): \Illuminate\View\View
    {
        return view('livewire.friend-management-component');
    }
}
