<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Friends;
use App\Models\User;
class FriendsController extends Controller
{

    //* made a mistake on the "Friend" model name it should be FriendRequest 


    public function sendFriendRequest(User $receiverId)
    {
        
        // Get the authenticated user (sender)

        $sender = auth()->user();

        // Check if a friend request already exists
        $existingRequest = Friends::where('sender_id', $sender->id)
        ->where('receiver_id', $receiverId->id)
        ->first();

        if ($existingRequest) {
            return response()->json(['error' => 'Friend request already sent'], 400);
        }

        // Create a new friend request
        Friends::create([
            'sender_id' => $sender->id,
            'receiver_id' => $receiverId->id, // Make sure receiver_id is set
            'status' => 0, // Assuming 'false' means pending
        ]);

        return response()->json(['message' => 'Friend request sent successfully']);

    }



    //* made a mistake on the "Friend" model name it should be FriendRequest 

    public function acceptFriendRequest(User $senderId)
    {
        // Assume you have the authenticated user (receiver of the request)
        $receiver = auth()->user();

        // Check if there is a pending friend request from $sender to $receiver
        $friendRequest = $senderId->friendRequestsSent()->where('receiver_id', $receiver->id)->first();

        if ($friendRequest) {
            // Accept the friend request
            $friendRequest->update(['status' => true]); // Assuming 'true' means accepted

            // Create a friendship by updating the pivot table
            $receiver->friends()->attach($senderId->id);
            $senderId->friends()->attach($receiver->id);

            return response()->json(['message' => 'Friend request accepted successfully']);
        }

        return response()->json(['error' => 'Friend request not found'], 404);
    }








    //* made a mistake on the "Friend" model name it should be FriendRequest 

    public function rejectFriendRequest(User $sender)
    {
        // Assume you have the authenticated user (receiver of the request)
        $receiver = auth()->user();

        // Find and delete the friend request
        $friendRequest = Friends::where('sender_id', $sender->id)
            ->where('receiver_id', $receiver->id)
            ->first();

        if ($friendRequest) {
            // Delete the friend request
            $friendRequest->delete();

            return response()->json(['message' => 'Friend request rejected and deleted successfully']);
        }

        return response()->json(['error' => 'Friend request not found'], 404);
    }





    //* made a mistake on the "Friend" model name it should be FriendRequest 

    public function getFriendsList(User $user)
    {
        // Retrieve the list of friends for the specified user
        $friends = $user->friends;

        // Return a JSON response with the friends list
        return response()->json(['friends' => $friends]);
    }


}
