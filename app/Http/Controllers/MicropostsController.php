<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Micropost;

class MicropostsController extends Controller
{
    public function index()
    {
        $data = [];
        if (\Auth::check()) {
            $user = \Auth::user();
            $microposts = $user->feed_microposts()->orderBy('created_at', 'desc')->paginate(10);
            
            $data = [
                'user' => $user,
                'microposts' => $microposts,
            ];
        }
        
        return view('welcome', $data);
    }
    
    public function store(Request $request)
    {
        $this->validate($request, [
            'content' => 'required|max:191',
            'image' => 'file|image|mimes:jpg,png,bmp,gif,svg|max:5000'
        ]);
        
        // 画像のアップロードがある場合
        if (!$request->file('image') == null) {
            // 拡張子を取得
            $ext = $request->file('image')->guessExtension();
            // ファイル名生成
            $fileName = uniqid() . ".{$ext}";
            // 画像を/public/item/uploaded_imageに保存
            $path = $request->file('image')->storeAs('uploaded_image', $fileName);

            $request->user()->microposts()->create([
                'content' => $request->content,
                'image_file_name' => $path,
            ]);
        }
        // 画像のアップロードがない場合、ファイルパス＝0
        else {
            $path = 0;
            
            $request->user()->microposts()->create([
                'content' => $request->content,
                'image_file_name' => $path,
            ]);
        }
        
        return back();
    }

    public function destroy($id)
    {
        $micropost = \App\Micropost::find($id);

        if (\Auth::id() === $micropost->user_id) {
            $micropost->delete();
        }

        return back();
    }
}






