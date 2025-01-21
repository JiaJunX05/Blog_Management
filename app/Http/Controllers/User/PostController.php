<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use App\Models\Image;

class PostController extends Controller
{
    public function dashboard() {
        $posts = Post::with('image')                        // 预加载关联的图片
                    ->where('user_id', Auth::user()->id)    // 仅获取当前用户的文章
                    ->get();
        return view('user.dashboard', compact('posts'));
    }

    public function showCreateForm() {
        return view('user.create');
    }

    public function create(Request $request) {
        $request->validate([
            'feature' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'title' => 'required|string|max:255',
            'content' => 'required|string|max:1000',
            'image.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('feature')) {
            $feature = $request->file('feature');
            $featureName = time() . '.' . $feature->getClientOriginalExtension();
            $feature->move(public_path('assets/features'), $featureName);
        }

        $post = Post::create([
            'feature' => 'features/' . $featureName,
            'title' => $request->title,
            'content' => $request->content,
            'user_id' => Auth::user()->id, // 设置文章的作者为当前用户
        ]);

        if ($request->hasFile('image')) {
            foreach ($request->file('image') as $imageFile) {
                $imageName = time() . uniqid() . '.' . $imageFile->getClientOriginalExtension();
                $imageFile->move(public_path('assets/images'), $imageName);

                Image::create([
                    'image' => 'images/' . $imageName,
                    'post_id' => $post->id,
                ]);
            }
        } else {
            return redirect()->back()->withErrors(['image' => 'No image uploaded.']);
        }

        return redirect()->route('user.dashboard')->with('success', 'Post created successfully.');
    }

    public function viewPost($id) {
        $post = Post::with('image')->find($id);
        return view('user.view', compact('post'));
    }

    public function showEditForm($id) {
        $post = Post::with('image')->find($id);
        return view('user.edit', compact('post'));
    }

    public function update(Request $request, $id) {
        $request->validate([
            'feature' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'title' => 'required|string|max:255',
            'content' => 'required|string|max:1000',
            'image.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $post = Post::findOrFail($id);

        if ($request->hasFile('feature')) {
            if ($post->feature && file_exists(public_path('assets/' . $post->feature))) {
                unlink(public_path('assets/' . $post->feature));
            }

            $featureName = time() . '.' . $request->file('feature')->getClientOriginalExtension();
            $request->file('feature')->move(public_path('assets/features'), $featureName);
            $post->feature = 'features/' . $featureName;
        }

        $post->update([
            'title' => $request->title,
            'content' => $request->content,
        ]);

        // 删除选中的图片
        if ($request->has('remove_image')) {
            foreach ($request->remove_image as $imageId) {
                $image = Image::find($imageId);
                if ($image) {
                    // 删除文件
                    if (file_exists(public_path('assets/' . $image->image))) {
                        unlink(public_path('assets/' . $image->image));
                    }
                    // 删除数据库记录
                    $image->delete();
                }
            }
        }

        // 添加新的图片
        if ($request->hasFile('image')) {
            foreach ($request->file('image') as $imageFile) {
                $imageName = time() . uniqid() . '.' . $imageFile->getClientOriginalExtension();
                $imageFile->move(public_path('assets/images'), $imageName);

                Image::create([
                    'image' => 'images/' . $imageName,
                    'post_id' => $post->id,
                ]);
            }
        }

        return redirect()->route('user.dashboard')->with('success', 'Post updated successfully.');
    }

    public function destroy($id) {
        $post = Post::findOrFail($id);

        if ($post->feature && file_exists(public_path('assets/' . $post->feature))) {
            unlink(public_path('assets/' . $post->feature));
        }

        $images = Image::where('post_id', $post->id)->get(); // Get all images linked to this post
        foreach ($images as $image) {
            $imagePath = public_path('assets/' . $image->image);
            if (file_exists($imagePath)) {
                unlink($imagePath); // Delete the image file
            }
            $image->delete(); // Delete the image record from the database
        }

        $post->delete();
        return redirect()->route('user.dashboard')->with('success', 'Post deleted successfully.');
    }
}
