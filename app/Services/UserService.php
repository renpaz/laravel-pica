<?php

namespace App\Services;

use App\Enums\PersonTypeEnum;
use App\Models\User;
use App\Utils\StringFormat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserService
{
    // private $modelClass = User::class;
    private $result = [];

    public function __construct()
    {
    }

    /**
     * Creates a new user
     *
     * @param mixed $data
     * @return User
     */
    public function create($data)
    {
        $user = new User();
        $this->fill($user, $data);
        $user->save();

        return $user;
    }

    /**
     * Updates user
     *
     * @param mixed $data
     * @param User $user
     * @return User
     */
    public function update($data, $user)
    {
        $this->fill($user, $data->toArray());
        $user->save();

        return $user;
    }

    /**
     * Deletes user and all of its dependencies
     *
     * @param mixed $data
     * @return array
     */
    public function multiDelete($data)
    {
        return [
            User::destroy($data)
        ];
    }

    /**
     * Fill all user data and must be updated after every new migration related to users
     *
     * @param User $model
     * @param mixed $data
     * @return void
     */
    public function fill(&$model, $data)
    {
        $model->name = $data['name'];
        $model->email = $data['email'];
        $model->password = bcrypt($data['password']);
        $model->person_type = isset($data['person_type']) ? $data['person_type'] : PersonTypeEnum::NATURAL_PERSON;
    }

    private function createFilteredQuery(Request $request)
    {
        $users = User::select();
        $filters = $request->get('search');

        if (isset($filters))
            $this->applyFilters($users, $filters);

        return $users;
    }

    private function applyFilters(&$users, $filters)
    {
        if ($filters) {
            $users->whereRaw(DB::raw(StringFormat::rawTextFilter($filters, 'name')));
        }
        return $users;
    }
}
