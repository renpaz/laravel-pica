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

    public function create($data)
    {
        $user = new User();
        $this->fill($user, $data);
        $user->save();

        return $user;
    }

    public function update($data, $user)
    {
        $this->fill($user, $data->toArray());
        $user->save();

        return $user;
    }

    public function multiDelete($data)
    {
        return User::destroy($data);
    }

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

        // $this->filterByUser($users);

        if (isset($filters))
            $this->applyFilters($users, $filters);

        return $users;
    }

    private function applyFilters(&$contacts, $filters)
    {
        if ($filters) {
            $contacts->whereRaw(DB::raw(StringFormat::rawTextFilter($filters, 'name')));
        }
        return $contacts;
    }

    // public function filterByUser(&$users)
    // {

    // }
}
