<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePostRequest;
use App\Http\Resources\PostResource;
use App\Models\Subscription;
use App\Models\WallPost;
use App\Services\PusherService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\File;

class PostController extends Controller
{
    protected function getFileSize($path) {
        // Get the file size in bytes
        $fileSizeBytes = filesize($path);

        // Convert bytes to kilobytes (1 KB = 1024 bytes)
        $fileSizeKB = $fileSizeBytes / 1024;

        // Convert kilobytes to megabytes (1 MB = 1024 KB)

        return $fileSizeKB;
    }

    protected function compressImage($id, $path, $extension) {
        $filename = 'image2.' . $extension; //create a different filename for compressed image
        $compressed_image_path = public_path('/uploads/posts/images/' . $id . '/' . $filename);

        // Load the image
        $image = new \Imagick($path);

        // Get the width and height
        $width = $image->getImageWidth();
        $height = $image->getImageHeight();

        // Check if the image is horizontal or vertical
        if ($width > $height) {
            $new_width = 1200;
            $image->resizeImage($new_width, 0, \Imagick::FILTER_LANCZOS, 1);

        } elseif ($width < $height) {
            $new_height = 1350;
            $image->resizeImage(0, $new_height, \Imagick::FILTER_LANCZOS, 1);
        } else {
            $new_width = 1200;
            $image->resizeImage($new_width, 0, \Imagick::FILTER_LANCZOS, 1);
        }

        if($extension == 'png') {
            // Set the image format to PNG
            $image->setImageFormat('png');

            $image->setImageDepth(8);  // 8 bits per channel
            $image->setImageType(\Imagick::IMGTYPE_PALETTE);  // Palette-based (reduce color depth)

            $image->stripImage();  // Remove all profiles and comments from the image

        }
        elseif($extension == 'jpg' || $extension == 'jpeg') {
            // Set compression type to JPEG (adjust for PNG if needed)
            $image->setImageCompression(\Imagick::COMPRESSION_JPEG);

            // Set the compression quality (0 to 100)
            $jpegQuality = 60;
            $image->setImageCompressionQuality($jpegQuality);
        }

        $image->writeImage($compressed_image_path);

        File::delete($path);

        return $filename;
    }

    public function getPostsByCode($code, Request $request) {
        $subscription = Subscription::where('event_code', $code)->first();
        $id = $subscription->id;
        if($request->randomized) {
            $posts = WallPost::where('approved', $request->approved)->where('subscription_id', $id)->inRandomOrder();
        }
        else {
            $posts = WallPost::where('approved', $request->approved)->where('subscription_id', $id)->orderBy('id', 'DESC');
        }

        return PostResource::collection($posts->get());
    }

    public function getPostsByKey($key, Request $request) {
        $subscription = Subscription::where('subscription_key', $key)->first();
        if(is_object($subscription)) {
            $id = $subscription->id;
            $posts = WallPost::where('approved', $request->approved)->where('subscription_id', $id)->orderBy('id', 'DESC');

            return PostResource::collection($posts->get());
        }
        else {
            return response()->json(['message' => 'Not Found'], 404);
        }
    }

    public function getDetails($id, $uid) {
        $post = WallPost::where('id', $id)
            ->where('unique_id', $uid)
            ->first();

        if(is_object($post)) {
            return new PostResource($post);
        }

        return response()->json(['message' => 'Not Found'], 404);
    }

    public function create(CreatePostRequest $request) {
        $subscription = Subscription::find($request->subscription_id);
        $post = WallPost::create([
            'name' => $request->name,
            'email' => $request->email,
            'message' => $request->message . "\n" . $subscription->hash_tag,
            'company' => $request->company,
            'position' => $request->position,
            'subscription_id' => $request->subscription_id,
            'mobile_no' => $request->mobile_no ? $request->mobile_no : null
        ]);

        $post = WallPost::find($post->id);
        if($request->hasFile('image')) {
            $image = $request->file('image');

            $extension = $image->getClientOriginalExtension() ? $image->getClientOriginalExtension() : 'jpg';
            $filename = 'image.' . $extension;
            $image->move(public_path('/uploads/posts/images/' . $post->id), $filename);
            
            // $uploaded_image_path = public_path('/uploads/posts/images/' . $post->id . '/' . $filename);

            // if(in_array($extension, ['jpg', 'png', 'jpeg'])) {
            //     if($this->getFileSize($uploaded_image_path) > 500) {
            //         $filename = $this->compressImage($post->id, $uploaded_image_path, $extension);
            //     }
            // }

            $post->image = $filename;
        }

        $subscription = Subscription::find($post->subscription_id);
        $post->approved = $subscription->enable_message_approval ? 0 : 1;
        $post->background = $this->getBackgroundColor();
        $post->font_color = $this->getFontColor($post->background);
        $post->unique_id = uniqid();
        $post->save();

        $resource = new PostResource($post);
        if($post->approved) {
            PusherService::sendNotification($resource, 'approve');
        }
        
        return $resource;
    }

    public function getBackgroundColor() {
        $index = floor(rand(0, 20));
        $colors = [
            '#185678',
            '#630094',
            '#F68383',
            '#F2AD3E',
            '#027C8B',
            '#A13554',
            '#8fa84c',
            '#9BC9DD',
            '#5385B0',
            '#00403F',
            '#C8C6F7',
            '#9BC9DD',
            '#083552',
            '#F1E2BB',
            '#BEEAEB',
            '#A4C2F4',
            '#192E3C',
            '#908B3E',
            '#006F4B',
            '#EA44BB',
            '#000F3F'
        ];

        return $colors[$index];
    }

    public function getFontColor($background) {
        $rgb = $this->HTMLToRGB($background);
        $hsl = $this->RGBToHSL($rgb);
        if($hsl->lightness > 200) {
        // this is light colour!
            return '#000';
        }
        return '#fff';
    }

    function HTMLToRGB($htmlCode)
    {
        if($htmlCode[0] == '#')
        $htmlCode = substr($htmlCode, 1);

        if (strlen($htmlCode) == 3)
        {
        $htmlCode = $htmlCode[0] . $htmlCode[0] . $htmlCode[1] . $htmlCode[1] . $htmlCode[2] . $htmlCode[2];
        }

        $r = hexdec($htmlCode[0] . $htmlCode[1]);
        $g = hexdec($htmlCode[2] . $htmlCode[3]);
        $b = hexdec($htmlCode[4] . $htmlCode[5]);

        return $b + ($g << 0x8) + ($r << 0x10);
    }

    function RGBToHSL($RGB) {
        $r = 0xFF & ($RGB >> 0x10);
        $g = 0xFF & ($RGB >> 0x8);
        $b = 0xFF & $RGB;

        $r = ((float)$r) / 255.0;
        $g = ((float)$g) / 255.0;
        $b = ((float)$b) / 255.0;

        $maxC = max($r, $g, $b);
        $minC = min($r, $g, $b);

        $l = ($maxC + $minC) / 2.0;

        if($maxC == $minC)
        {
        $s = 0;
        $h = 0;
        }
        else
        {
        if($l < .5)
        {
            $s = ($maxC - $minC) / ($maxC + $minC);
        }
        else
        {
            $s = ($maxC - $minC) / (2.0 - $maxC - $minC);
        }
        if($r == $maxC)
            $h = ($g - $b) / ($maxC - $minC);
        if($g == $maxC)
            $h = 2.0 + ($b - $r) / ($maxC - $minC);
        if($b == $maxC)
            $h = 4.0 + ($r - $g) / ($maxC - $minC);

        $h = $h / 6.0; 
        }

        $h = (int)round(255.0 * $h);
        $s = (int)round(255.0 * $s);
        $l = (int)round(255.0 * $l);

        return (object) Array('hue' => $h, 'saturation' => $s, 'lightness' => $l);
    }

    public function updateImages($id) {
        $wallposts = WallPost::where('subscription_id', $id)->where('image', 'like', 'image.%');

        $response = [];
        foreach($wallposts->get() as $post) {
            if($post->image) {
                $path = public_path('/uploads/posts/images/' . $post->id . '/' . $post->image);
                $extension = explode('.', $post->image);
                if(in_array($extension[1], ['png', 'jpg', 'jpeg'])) {
                    $filename = $this->compressImage($post->id, $path, $extension[1]);

                    $wallpost = WallPost::find($post->id);
                    $wallpost->image = $filename; 
                    $wallpost->save();

                    $response[] = $wallpost;
                }
            }
            
        }

        return response()->json($response);
    }

}
