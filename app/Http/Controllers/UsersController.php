<?php

namespace App\Http\Controllers;

use App\Handlers\ImageUploadHandler;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Models\User;
class UsersController extends Controller
{
    public function __construct()
    {
        // 使用中间件验证用户是否具有操作权限
        $this -> middleware('auth', ['except'=> ['show']]);
    }

    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        // 检测用户是否获得授权
        $this->authorize('update', $user);
        return view('users.edit', compact('user'));
    }

    public function update(UserRequest $request, ImageUploadHandler $imageUploadHandler, User $user)
    {
        // 检测用户是否获得授权
        $this->authorize('update', $user);

        $data = $request->all();
        if ($request->picture) {
            $result = $imageUploadHandler -> save($request->picture, 'picture', $user->id);
            if ($result) {
                $data['picture'] = $result['path'];
            }
        }
        $user->update($data);
        return redirect()->route('users.show', $user->id)->with('success', '个人资料更新成功！');
    }

}
