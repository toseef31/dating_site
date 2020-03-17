<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function main()
    {
        $users = User::paginate(30);
        $pages = $users->links();
        return view('admin.users', compact('users','pages'));
    }

    public function edit($id)
    {
        $user = User::where('id',$id)->first();
        if($user){
            return view('admin.user', compact('user'));
        }
        else return redirect()->route('adminusers');
    }

    public function updateUser($id)
    {
        $user = User::where('id',$id)->first();
        if($user){
            if($this->request->has('email')){
                $user->email = $this->request->get('email');
            }
            if($this->request->has('firstname')){
                $user->firstname = $this->request->get('firstname');
            }
            if($this->request->has('lastname')){
                $user->lastname = $this->request->get('lastname');
            }
            if($this->request->has('about')){
                $user->about = $this->request->get('about');
            }
            if($this->request->has('country')){
                $user->country = $this->request->get('country');
            }
            if($this->request->has('username')){
                $user->username = $this->request->get('username');
            }
            if($this->request->has('active')){
                $user->active = $this->request->get('active');
            }
            if($this->request->has('day') && $this->request->has('month') && $this->request->has('year')){
                $user->birthday = date('Y-m-d H:i:s', strtotime($this->request->get('year').'-'.$this->request->get('month').'-'.$this->request->get('day')));
            }
            if($this->request->has('password') && $this->request->has('password_confirm') && $this->request->get('password') != '' && $this->request->get('password') == $this->request->get('password_confirm')){
                $user->password = Hash::make($this->request->password);
            }
            if($this->request->hasFile('avatar')){
                $avatar = $this->request->file('avatar');
                if(in_array($avatar->getClientOriginalExtension(),['jpg','png','gif','jpeg'])){
                    $filename = md5($user->username.time()).time();
                    $tempFile= $avatar->getPathname();
                    $targetPath = $this->create_folder($user->id);
                    $targetFile = $targetPath.DIRECTORY_SEPARATOR.$filename.'.'.$avatar->getClientOriginalExtension();
                    $file = compress_image($tempFile, $targetFile, 100);
                    var_dump($file);
                    $size = getimagesize($tempFile);
                    $nw = $nh = 250;
                    $x = (int) $this->request->get('x');
                    $y = (int) $this->request->get('y');
                    $w = (int) $this->request->get('w') ? $this->request->get('w') : $size[0];
                    $h = (int) $this->request->get('h') ? $this->request->get('h') : $size[1];
                    $data = file_get_contents($tempFile);
                    $vImg = imagecreatefromstring($data);
                    $dstImg = imagecreatetruecolor($nw, $nh);
                    imagecopyresampled($dstImg, $vImg, 0, 0, $x, $y, $nw, $nh,$w, $h);
                    imagejpeg($dstImg, $targetFile);
                    imagedestroy($dstImg);
                    if($user->avatar && file_exists(base_path('../').DIRECTORY_SEPARATOR.$user->avatar)) {
                        @unlink(base_path('../'). DIRECTORY_SEPARATOR . $user->avatar);
                    }
                    $user->avatar = 'uploads/photos/'.$user->id.'/'.$filename.'.'.$avatar->getClientOriginalExtension();
                }
            }
            $user->save();
            return redirect()->back()->with('success_update', 'Update user successfully');
        }
        else return redirect()->route('adminusers');
    }

    private function create_folder($id)
    {
        $path = base_path('../').DIRECTORY_SEPARATOR.'uploads';
        if(!realpath($path)){
            mkdir($path,0777);
        }
        $path .= DIRECTORY_SEPARATOR.'photos';
        if(!realpath($path)){
            mkdir($path, 0777);
        }
        $path .= DIRECTORY_SEPARATOR.$id;
        if(!realpath($path)){
            mkdir($path, 0777);
        }
        return $path;
    }

    public function deleteUser($id)
    {
        $user = User::where('id',$id)->first();
        if($user){
            $user->delete();
            return redirect()->back();
        }
        else return redirect()->back();
    }
}
