<?php

namespace App\Policies;

use App\Exam;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ExamPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @param  \App\Exam  $exam
     * @return mixed
     */
    public function view(User $user, Exam $exam)
    {
        return $user->is_admin() || $exam->user_id == $user->id;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return boolval($user);
    }

    /**
     * Determine whether the user can submit answers.
     *
     * @param  \App\User  $user
     * @param  \App\Exam  $exam
     * @return mixed
     */
    public function submit(User $user, Exam $exam)
    {
        return $user->id == $exam->user_id;        
    }
}
