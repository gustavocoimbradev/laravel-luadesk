<?php

namespace App\Observers;

use App\Models\Answer;

class AnswerObserver
{
    /**
     * Handle the Answer "created" event.
     */
    public function created(Answer $answer): void
    {


        $ticket = $answer->ticket;
        $user = $answer->user;

        $status = 0; 

        if ($answer->closes_ticket) {
            $status = 2; 
        } elseif ($user->is_admin) {
            $status = 1; 
        } else {
            $status = 0;
        }

        $ticket->update(['status' => $status]); 
    }

    /**
     * Handle the Answer "updated" event.
     */
    public function updated(Answer $answer): void
    {
        //
    }

    /**
     * Handle the Answer "deleted" event.
     */
    public function deleted(Answer $answer): void
    {
        //
    }

    /**
     * Handle the Answer "restored" event.
     */
    public function restored(Answer $answer): void
    {
        //
    }

    /**
     * Handle the Answer "force deleted" event.
     */
    public function forceDeleted(Answer $answer): void
    {
        //
    }
}
